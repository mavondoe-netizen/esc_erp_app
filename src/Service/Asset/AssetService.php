<?php
declare(strict_types=1);

namespace App\Service\Asset;

use Cake\ORM\Locator\LocatorAwareTrait;

class AssetService
{
    use LocatorAwareTrait;

    public function registerAsset(array $data, int $userId)
    {
        $assets = $this->fetchTable('Assets');
        
        // Setup initial book value
        if (isset($data['acquisition_cost'])) {
            $data['current_book_value'] = $data['acquisition_cost'];
        }

        $asset = $assets->newEntity($data);
        if ($assets->save($asset)) {
            $this->logAction($asset->id, 'create', $userId, 'Asset registered.');
            return $asset;
        }
        return false;
    }

    public function logAction(int $assetId, string $action, ?int $userId, string $details = ''): void
    {
        $logs = $this->fetchTable('AssetLogs');
        $log = $logs->newEntity([
            'asset_id' => $assetId,
            'action' => $action,
            'user_id' => $userId,
            'details' => $details
        ]);
        $logs->save($log);
    }
}
