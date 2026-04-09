<?php
declare(strict_types=1);

namespace App\Service\Asset;

use Cake\ORM\Locator\LocatorAwareTrait;

class DisposalService
{
    use LocatorAwareTrait;

    public function disposeAsset(int $assetId, array $data, int $userId): bool
    {
        $disposals = $this->fetchTable('AssetDisposals');
        $assets = $this->fetchTable('Assets');
        $asset = $assets->get($assetId);
        
        $data['asset_id'] = $assetId;
        $data['gain_or_loss'] = $data['disposal_amount'] - $asset->current_book_value;
        $data['approved_by'] = $userId;
        
        $disposal = $disposals->newEntity($data);
        if ($disposals->save($disposal)) {
            $asset->status = 'disposed';
            $assets->save($asset);
            
            $assetService = new AssetService();
            $assetService->logAction($assetId, 'dispose', $userId, 'Asset disposed: ' . $data['disposal_type'] . ' with G/L of ' . $data['gain_or_loss']);
            return true;
        }
        return false;
    }
}
