<?php
declare(strict_types=1);

namespace App\Service\Asset;

use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\I18n\FrozenDate;

class PostingService
{
    use LocatorAwareTrait;

    // This service integrates deeply with the Ledger/Transactions module.
    // Example implementation concept.

    public function postDepreciation(int $depreciationId, array $ledgerAccounts)
    {
        $depreciations = $this->fetchTable('AssetDepreciation');
        $depRecord = $depreciations->get($depreciationId, ['contain' => ['Assets']]);

        if ($depRecord->posted_to_ledger) {
            return false;
        }

        $transactions = $this->fetchTable('Transactions');
        
        $connection = $transactions->getConnection();
        return $connection->transactional(function () use ($transactions, $depRecord, $ledgerAccounts, $depreciations) {
            
            $batchStr = 'DEP-' . $depRecord->period . '-' . time();
            $date = new FrozenDate($depRecord->period . '-28'); // roughly end of month

            // Dr Depreciation Expense
            $debit = $transactions->newEntity([
                'account_id' => $ledgerAccounts['expense_account_id'],
                'date' => $date,
                'description' => 'Depreciation for ' . $depRecord->asset->asset_tag,
                'debit' => $depRecord->depreciation_amount,
                'credit' => 0,
                'transaction_group' => $batchStr
            ]);
            $transactions->saveOrFail($debit);

            // Cr Accumulated Depreciation
            $credit = $transactions->newEntity([
                'account_id' => $ledgerAccounts['accumulated_account_id'],
                'date' => $date,
                'description' => 'Accumulated Dep. for ' . $depRecord->asset->asset_tag,
                'debit' => 0,
                'credit' => $depRecord->depreciation_amount,
                'transaction_group' => $batchStr
            ]);
            $transactions->saveOrFail($credit);

            $depRecord->posted_to_ledger = true;
            $depreciations->saveOrFail($depRecord);

            return true;
        });
    }
}
