<?php
declare(strict_types=1);

namespace App\Service\Asset;

use Cake\ORM\Locator\LocatorAwareTrait;

class TransferService
{
    use LocatorAwareTrait;

    public function requestTransfer(array $data, int $userId)
    {
        $transfers = $this->fetchTable('AssetTransfers');
        $data['status'] = 'pending';
        $transfer = $transfers->newEntity($data);
        if ($transfers->save($transfer)) {
            $assetService = new AssetService();
            $assetService->logAction($transfer->asset_id, 'transfer_request', $userId, 'Transfer requested to office ' . $data['to_office_id']);
            return $transfer;
        }
        return false;
    }

    public function approveTransfer(int $transferId, int $userId): bool
    {
        $transfers = $this->fetchTable('AssetTransfers');
        $transfer = $transfers->get($transferId);
        
        $transfer->status = 'approved';
        $transfer->approved_by = $userId;
        
        if ($transfers->save($transfer)) {
            // Update the Actual Asset
            $assets = $this->fetchTable('Assets');
            $asset = $assets->get($transfer->asset_id);
            $asset->office_id = $transfer->to_office_id;
            $assets->save($asset);

            $assetService = new AssetService();
            $assetService->logAction($asset->id, 'transfer_approved', $userId, 'Transfer approved.');
            return true;
        }
        return false;
    }
}
