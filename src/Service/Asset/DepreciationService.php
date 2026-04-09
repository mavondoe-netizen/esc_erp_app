<?php
declare(strict_types=1);

namespace App\Service\Asset;

use Cake\ORM\Locator\LocatorAwareTrait;

class DepreciationService
{
    use LocatorAwareTrait;

    public function runMonthly(string $period): bool
    {
        $assetsTable = $this->fetchTable('Assets');
        $depreciations = $this->fetchTable('AssetDepreciation');

        $assets = $assetsTable->find()
            ->where([
                'status' => 'active', 
                'useful_life >' => 0,
                'depreciation_method' => 'straight_line'
            ])
            ->all();

        foreach ($assets as $asset) {
            // Straight Line Formula
            $depreciationAmt = ($asset->acquisition_cost - $asset->residual_value) / $asset->useful_life;
            
            // Do not depreciate below residual value
            if ($asset->current_book_value - $depreciationAmt < $asset->residual_value) {
                $depreciationAmt = $asset->current_book_value - $asset->residual_value;
            }
            if ($depreciationAmt <= 0) {
                continue;
            }

            // Calculate accumulated
            $accum = $depreciations->find()
                ->where(['asset_id' => $asset->id])
                ->all()
                ->sumOf('depreciation_amount');

            $newAccum = $accum + $depreciationAmt;
            $newBookValue = $asset->acquisition_cost - $newAccum;

            $record = $depreciations->newEntity([
                'asset_id' => $asset->id,
                'period' => $period,
                'depreciation_amount' => $depreciationAmt,
                'accumulated_depreciation' => $newAccum,
                'book_value' => $newBookValue,
                'posted_to_ledger' => false
            ]);

            if ($depreciations->save($record)) {
                $asset->current_book_value = $newBookValue;
                $assetsTable->save($asset);
            }
        }

        return true;
    }
}
