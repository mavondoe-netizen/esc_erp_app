<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

/**
 * Accounting Component
 */
class AccountingComponent extends Component
{
    /**
     * Gets the latest exchange rate for a currency.
     * 
     * @param int $company_id
     * @param string $currency
     * @param string|null $date
     * @return float
     */
    public function getCurrentRate(int $company_id, string $currency, $date = null): float
    {
        $ratesTable = TableRegistry::getTableLocator()->get('ExchangeRates');
        $query = $ratesTable->find()
            ->where(['company_id' => $company_id, 'currency' => $currency]);
            
        if ($date) {
            $query->where(['date <=' => $date]);
        }
        
        $rate = $query->orderBy(['date' => 'DESC'])->first();
        
        return $rate ? (float)$rate->rate_to_base : 1.0;
    }

    /**
     * Records exchange gain/loss if the rate has changed between invoice/bill date and payment date.
     * 
     * @param int $company_id
     * @param string $type 'invoice' or 'bill'
     * @param int $source_id The ID of the invoice or bill
     * @param float $payment_amount Amount in foreign currency
     * @param float $payment_rate Current exchange rate (Base CC / Foreign CC)
     * @param \Cake\I18n\DateTime $date Date of the gain/loss entry
     */
    public function recordExchangeVariance(int $company_id, string $type, int $source_id, float $payment_amount, float $payment_rate, $date)
    {
        $table = ($type === 'invoice') ? TableRegistry::getTableLocator()->get('Invoices') : TableRegistry::getTableLocator()->get('Bills');
        $source = $table->get($source_id);
        
        // Original Rate = Original Base Amount / Original Foreign Amount
        // In this app, 'zwg' is often used as the base amount, and 'amount' as the foreign.
        if (!$source->zwg || !$source->total || $source->total == 0) {
            return; // Cannot determine original rate
        }
        
        $original_rate = (float)$source->zwg / (float)$source->total;
        
        // Variance = (Payment Rate - Original Rate) * Payment Amount
        $variance = ($payment_rate - $original_rate) * $payment_amount;
        
        if (round($variance, 2) == 0) {
            return;
        }

        $transactionsTable = TableRegistry::getTableLocator()->get('Transactions');
        $accountsTable = TableRegistry::getTableLocator()->get('Accounts');
        
        // Find or Create an 'Exchange Gain/Loss' account (Category 6 = Expenses)
        $account = $accountsTable->find()
            ->where(['name' => 'Exchange Gain/Loss', 'company_id' => $company_id])
            ->first();
            
        if (!$account) {
            $account = $accountsTable->newEntity([
                'company_id' => $company_id,
                'name' => 'Exchange Gain/Loss',
                'category' => 6,
                'subcategory' => 'Financial Costs',
                'balance' => 0
            ]);
            $accountsTable->save($account);
        }

        // Create the transaction
        // If it's a Gain (positive for invoices, negative for bills), it's a Credit to the P&L account (or Debit if loss)
        // For simplicity, we just record the variance in 'zwg' (base currency)
        $isGain = ($type === 'invoice') ? ($variance > 0) : ($variance < 0);
        
        $txn = $transactionsTable->newEntity([
            'company_id' => $company_id,
            'date' => $date,
            'description' => "Exchange " . ($isGain ? "Gain" : "Loss") . " on " . ucfirst($type) . " #" . $source_id,
            'amount' => 0, // No foreign currency movement, just base currency adjustment
            'currency' => $source->currency,
            'zwg' => abs($variance),
            'account_id' => $account->id,
            'type' => $isGain ? '1' : '2', // 1=Credit (Gain), 2=Debit (Loss)
            ($type . '_id') => $source_id
        ]);
        
        $transactionsTable->save($txn);
    }
}
