<?php
namespace App\Service;
use Cake\ORM\TableRegistry;

class PayrollService
{
    public function calculateGross($data)
    {
        return (float)($data['basic_salary'] ?? 0) +
               (float)($data['allowances'] ?? 0) +
               (float)($data['bonuses'] ?? 0) +
               (float)($data['overtime'] ?? 0) +
               (float)($data['benefits'] ?? 0);
    }

    public function calculateTaxableIncome($gross, $pension, $nssa)
    {
        return max(0, $gross - (float)($pension ?? 0) - (float)($nssa ?? 0));
    }

    public function calculatePAYE($taxableIncome)
    {
        $taxTable = TableRegistry::getTableLocator()
            ->get('TaxTables')
            ->find()
            ->where([
                'lower_limit <=' => $taxableIncome,
                'upper_limit >=' => $taxableIncome
            ])
            ->first();

        if (!$taxTable) {
            return 0;
        }

        $tax = ($taxableIncome * $taxTable->rate/100) - $taxTable->deduction;
        return max(0, $tax);
    }

    public function calculateAidsLevy($paye)
    {
        return round($paye * 0.03, 2);
    }

    public function calculateCredits($employee, $medicalAid, $medicalExpenses)
    {
        $credits = 0;
        
        // Safety check if employee entity is missing
        if ($employee) {
            if (!empty($employee->is_elderly)) {
                $credits += 75;
            }
            if (!empty($employee->disabled)) {
                $credits += 75;
            }
            if (!empty($employee->is_blind)) {
                $credits += 75;
            }
        }

        $credits += ($medicalAid * 0.5);
        $credits += ($medicalExpenses * 0.5);

        return $credits;
    }

    /**
     * Parse dynamic arrays of Payslip Items from the front-end JS payload
     * 
     * @param array $items Array of line items from the add/edit form
     * @param float $exchangeRate The USD to ZWG exchange rate
     * @return array Calculated statutory taxes
     */
    public function calculateFromItems(array $items, float $exchangeRate = 1.0, $employee = null)
    {
        $usdGross = 0.0;
        $zwgGross = 0.0;
        
        $usdTaxableIncome = 0.0;
        $usdPensionableGross = 0.0;
        $usdNssaGross = 0.0;
        $usdBasicSalary = 0.0;
        
        $zwgTaxableIncome = 0.0;
        $zwgPensionableGross = 0.0;
        $zwgNssaGross = 0.0;
        $zwgBasicSalary = 0.0;

        $usdMedicalAid = 0.0;
        $usdMedicalExpenses = 0.0;
        $zwgMedicalAid = 0.0;
        $zwgMedicalExpenses = 0.0;
        
        // Fetch all earnings config to check their tax flags
        $earningsTable = TableRegistry::getTableLocator()->get('Earnings');
        $allEarnings = $earningsTable->find()->all()->indexBy('name')->toArray();

        // 1. Bucket the items
        foreach ($items as $item) {
            if (empty($item['item_type']) || empty($item['name']) || !isset($item['amount'])) {
                continue;
            }

            $type = $item['item_type'];
            $name = $item['name'];
            $amount = (float)$item['amount'];
            $currency = $item['currency'] ?? 'ZWG';

            if ($type === 'Earning') {
                $isTaxable = true;
                $isPensionable = true;
                $isNssaApplicable = true;
                $taxablePercentage = 100.0;
                $taxFreeAmount = 0.0;
                $isGrossUp = false;
                
                if (isset($allEarnings[$name])) {
                    $rule = $allEarnings[$name];
                    $isTaxable = (bool)$rule->taxable;
                    $isPensionable = (bool)$rule->pensionable;
                    $isNssaApplicable = (bool)$rule->nssa_applicable;
                    $taxablePercentage = (float)($rule->taxable_percentage ?? 100.0);
                    $taxFreeAmount = (float)($rule->tax_free_amount ?? 0.0);
                    $isGrossUp = (bool)($rule->gross_up ?? false);
                }

                $isFringeBenefit = stripos($name, 'fringe') !== false || stripos($name, 'airtime') !== false;
                $isBasicSalary = stripos($name, 'basic salary') !== false;
                
                $originalAmount = $amount;
                
                // Effective Taxable Portion
                if ($isTaxable) {
                    $taxableSection = max(0, $amount - $taxFreeAmount);
                    if ($taxablePercentage < 100) {
                        $taxableSection = $taxableSection * ($taxablePercentage / 100);
                    }
                } else {
                    $taxableSection = 0;
                }

                if ($currency === 'USD') {
                    if (!$isFringeBenefit) {
                        $usdGross += $amount;
                    }
                    if ($isTaxable) $usdTaxableIncome += $taxableSection;
                    if ($isPensionable) $usdPensionableGross += $amount;
                    if ($isNssaApplicable) $usdNssaGross += $amount;
                    if ($isBasicSalary) $usdBasicSalary += $amount;
                } else {
                    if (!$isFringeBenefit) {
                        $zwgGross += $amount;
                    }
                    if ($isTaxable) $zwgTaxableIncome += $taxableSection;
                    if ($isPensionable) $zwgPensionableGross += $amount;
                    if ($isNssaApplicable) $zwgNssaGross += $amount;
                    if ($isBasicSalary) $zwgBasicSalary += $amount;
                }
            } elseif ($type === 'Deduction') {
                if (stripos($name, 'medical aid') !== false) {
                    if ($currency === 'USD') $usdMedicalAid += $amount;
                    else $zwgMedicalAid += $amount;
                }
                if (stripos($name, 'medical expense') !== false) {
                    if ($currency === 'USD') $usdMedicalExpenses += $amount;
                    else $zwgMedicalExpenses += $amount;
                }
            }
        }

        // 2. Convert all ZWG values to USD for Tax Calculation Base
        $baseTaxableIncome = $usdTaxableIncome + ($zwgTaxableIncome / $exchangeRate);
        $basePensionableGross = $usdPensionableGross + ($zwgPensionableGross / $exchangeRate);
        $baseNssaGross = $usdNssaGross + ($zwgNssaGross / $exchangeRate);
        $baseBasicSalary = $usdBasicSalary + ($zwgBasicSalary / $exchangeRate);
        
        // Settings & NSSA (Using USD equivalent settings)
        $settingsTable = TableRegistry::getTableLocator()->get('Settings');
        $setting = $settingsTable->find()->first();
        $nssaRate = $setting && isset($setting->nssa_rate) ? (float)$setting->nssa_rate / 100 : 0.045; // default 4.5%

        // --- Proportions for NSSA / Pension split ---
        // These must follow BASIC SALARY proportions, not gross earnings
        $totalBaseBasicSalary = $usdBasicSalary + ($zwgBasicSalary / $exchangeRate);
        $usdBasicProportion = $totalBaseBasicSalary > 0 ? ($usdBasicSalary / $totalBaseBasicSalary) : 1;
        $zwgBasicProportion = 1 - $usdBasicProportion;

        // Base USD Deductions
        // NSSA uses Insurable Earnings (baseNssaGross), capped at statutory ceiling (e.g., $700 ceiling * 4.5% = $31.50)
        $nssaCeiling = $setting && isset($setting->nssa_ceiling) ? (float)$setting->nssa_ceiling : 700.00;
        $insurableEarnings = min($baseNssaGross, $nssaCeiling);
        $baseNssa = $insurableEarnings * $nssaRate;
        
        // Pension uses Pensionable Gross
        $basePension = $basePensionableGross * 0.10;

        // APWCS (employer-only) uses Basic Salary 
        $apwcsRate = $setting && isset($setting->apwcs_rate) ? (float)$setting->apwcs_rate / 100 : 0.01;
        $baseApwcs = $baseBasicSalary * $apwcsRate;

        // Final Base Taxable Income
        $finalBaseTaxableIncome = max(0, $baseTaxableIncome - $basePension - $baseNssa);

        // PAYE
        $basePaye = $this->calculatePAYE($finalBaseTaxableIncome);
        
        // Base Credits (Convert ZWG medical credits to USD first)
        $baseMedicalAid = $usdMedicalAid + ($zwgMedicalAid / $exchangeRate);
        $baseMedicalExpenses = $usdMedicalExpenses + ($zwgMedicalExpenses / $exchangeRate);
        $baseCredits = $this->calculateCredits($employee, $baseMedicalAid, $baseMedicalExpenses);
        
        $basePayeAfterCredits = max(0, $basePaye - $baseCredits);
        $baseAidsLevy = $this->calculateAidsLevy($basePayeAfterCredits);

        // Subdivide base taxes proportionally back into currencies based on respective Gross
        $totalBaseGross = $usdGross + ($zwgGross / $exchangeRate);
        $usdProportion = $totalBaseGross > 0 ? ($usdGross / $totalBaseGross) : 1;
        $zwgProportion = 1 - $usdProportion;

        $baseZimdef = $totalBaseGross * 0.01;
        $baseSdf = $totalBaseGross * 0.005;

        // Iterate any GROSS-UP items and find the inflated gross.
        // We do this by mathematically comparing base tax vs tax with the new net included.
        $updatedItems = [];
        $grossUpExtraTaxesUSD = ['PAYE' => 0.0, 'Aids Levy' => 0.0];

        foreach ($items as $idx => $item) {
            if (empty($item['item_type']) || $item['item_type'] !== 'Earning' || empty($item['name']) || !isset($item['amount'])) continue;
            
            $name = $item['name'];
            if (isset($allEarnings[$name]) && !empty($allEarnings[$name]->gross_up)) {
                $netTarget = (float)$item['amount'];
                if ($netTarget <= 0) continue;
                
                $currency = $item['currency'] ?? 'ZWG';
                $usdNetTarget = $currency === 'USD' ? $netTarget : ($netTarget / $exchangeRate);
                
                // Iterative solver to find Gross mapping to this exact Net Increase
                $grossGuess = $usdNetTarget;
                $resultingGrossAmount = $grossGuess;
                for ($i = 0; $i < 10; $i++) {
                    $taxWithGross = $this->calculatePAYE($finalBaseTaxableIncome + $grossGuess);
                    $marginalPaye = $taxWithGross - $basePaye;
                    $marginalAidsLevy = $this->calculateAidsLevy($marginalPaye);
                    
                    $yieldingNet = $grossGuess - $marginalPaye - $marginalAidsLevy;
                    $diff = $usdNetTarget - $yieldingNet;
                    if (abs($diff) < 0.01) {
                        $resultingGrossAmount = $grossGuess;
                        $grossUpExtraTaxesUSD['PAYE'] += $marginalPaye;
                        $grossUpExtraTaxesUSD['Aids Levy'] += $marginalAidsLevy;
                        break;
                    }
                    $grossGuess += $diff * 1.1; // modest acceleration multiplier
                }
                
                // Update the requested amount to the Inflated Gross
                $finalInflatedAmount = $currency === 'USD' ? $resultingGrossAmount : ($resultingGrossAmount * $exchangeRate);
                $updatedItems[] = [
                    'index' => $idx,
                    'amount' => round($finalInflatedAmount, 2)
                ];
            }
        }

        // Add gross-up taxes to standard tracking
        $totalBasePayeAfterCredits = $basePayeAfterCredits + $grossUpExtraTaxesUSD['PAYE'];
        $totalBaseAidsLevy = $baseAidsLevy + $grossUpExtraTaxesUSD['Aids Levy'];

        // --- Gross earnings proportions (for PAYE, Aids Levy, ZIMDEF, SDF) ---
        $totalBaseGross = $usdGross + ($zwgGross / $exchangeRate);
        // Default to USD proportion 1 if nothing earned
        $usdProportion = $totalBaseGross > 0 ? ($usdGross / $totalBaseGross) : 1;
        $zwgProportion = 1 - $usdProportion;

        $baseZimdef = $totalBaseGross * 0.01;
        $baseSdf    = $totalBaseGross * 0.005;

        $taxes = [];

        // Distribute proportionally if there's any respective earning
        if ($usdBasicProportion > 0) {
            // NSSA & Pension use BASIC SALARY proportion
            if ($baseNssa   > 0) $taxes[] = ['item_type' => 'Tax',                'currency' => 'USD', 'name' => 'NSSA',    'amount' => round($baseNssa   * $usdBasicProportion, 2)];
            if ($basePension > 0) $taxes[] = ['item_type' => 'Tax',                'currency' => 'USD', 'name' => 'Pension', 'amount' => round($basePension * $usdBasicProportion, 2)];
            // APWCS is employer-only, split by basic salary proportion
            if ($baseApwcs  > 0) $taxes[] = ['item_type' => 'Company Contribution', 'currency' => 'USD', 'name' => 'APWCS',   'amount' => round($baseApwcs  * $usdBasicProportion, 2)];
        }

        if ($usdProportion > 0) {
            // PAYE, Aids Levy, ZIMDEF, SDF use GROSS proportion
            if ($totalBasePayeAfterCredits > 0) $taxes[] = ['item_type' => 'Tax',                'currency' => 'USD', 'name' => 'PAYE',      'amount' => round($totalBasePayeAfterCredits * $usdProportion, 2)];
            if ($totalBaseAidsLevy         > 0) $taxes[] = ['item_type' => 'Tax',                'currency' => 'USD', 'name' => 'Aids Levy', 'amount' => round($totalBaseAidsLevy         * $usdProportion, 2)];
            if ($baseZimdef                > 0) $taxes[] = ['item_type' => 'Company Contribution', 'currency' => 'USD', 'name' => 'ZIMDEF',    'amount' => round($baseZimdef * $usdProportion, 2)];
            if ($baseSdf                   > 0) $taxes[] = ['item_type' => 'Company Contribution', 'currency' => 'USD', 'name' => 'SDF',       'amount' => round($baseSdf    * $usdProportion, 2)];
        }

        if ($zwgBasicProportion > 0) {
            // NSSA & Pension use BASIC SALARY proportion (converted to ZWG)
            if ($baseNssa   > 0) $taxes[] = ['item_type' => 'Tax',                'currency' => 'ZWG', 'name' => 'NSSA',    'amount' => round($baseNssa   * $zwgBasicProportion * $exchangeRate, 2)];
            if ($basePension > 0) $taxes[] = ['item_type' => 'Tax',                'currency' => 'ZWG', 'name' => 'Pension', 'amount' => round($basePension * $zwgBasicProportion * $exchangeRate, 2)];
            // APWCS employer-only in ZWG
            if ($baseApwcs  > 0) $taxes[] = ['item_type' => 'Company Contribution', 'currency' => 'ZWG', 'name' => 'APWCS',   'amount' => round($baseApwcs  * $zwgBasicProportion * $exchangeRate, 2)];
        }

        if ($zwgProportion > 0) {
            // PAYE, Aids Levy, ZIMDEF, SDF use GROSS proportion (converted to ZWG)
            if ($totalBasePayeAfterCredits > 0) $taxes[] = ['item_type' => 'Tax',                'currency' => 'ZWG', 'name' => 'PAYE',      'amount' => round($totalBasePayeAfterCredits * $zwgProportion * $exchangeRate, 2)];
            if ($totalBaseAidsLevy         > 0) $taxes[] = ['item_type' => 'Tax',                'currency' => 'ZWG', 'name' => 'Aids Levy', 'amount' => round($totalBaseAidsLevy         * $zwgProportion * $exchangeRate, 2)];
            if ($baseZimdef                > 0) $taxes[] = ['item_type' => 'Company Contribution', 'currency' => 'ZWG', 'name' => 'ZIMDEF',    'amount' => round($baseZimdef * $zwgProportion * $exchangeRate, 2)];
            if ($baseSdf                   > 0) $taxes[] = ['item_type' => 'Company Contribution', 'currency' => 'ZWG', 'name' => 'SDF',       'amount' => round($baseSdf    * $zwgProportion * $exchangeRate, 2)];
        }

        return [
            'taxes' => $taxes,
            'updated_items' => $updatedItems
        ];
    }
} 