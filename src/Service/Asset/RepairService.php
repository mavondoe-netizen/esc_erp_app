<?php
declare(strict_types=1);

namespace App\Service\Asset;

use Cake\ORM\Locator\LocatorAwareTrait;

class RepairService
{
    use LocatorAwareTrait;

    public function startRepair(array $data, int $userId)
    {
        $repairs = $this->fetchTable('AssetRepairs');
        $data['status'] = 'pending';
        $repair = $repairs->newEntity($data);
        
        if ($repairs->save($repair)) {
            $assets = $this->fetchTable('Assets');
            $asset = $assets->get($repair->asset_id);
            $asset->status = 'under_repair';
            $assets->save($asset);

            $assetService = new AssetService();
            $assetService->logAction($asset->id, 'repair_started', $userId, 'Sent for repair: ' . $repair->issue_description);
            return $repair;
        }
        return false;
    }

    public function completeRepair(int $repairId, int $userId, bool $capitalizeCost = false): bool
    {
        $repairs = $this->fetchTable('AssetRepairs');
        $repair = $repairs->get($repairId);
        
        $repair->status = 'completed';
        $repair->end_date = date('Y-m-d');
        
        if ($repairs->save($repair)) {
            $assets = $this->fetchTable('Assets');
            $asset = $assets->get($repair->asset_id);
            $asset->status = 'active';
            
            if ($capitalizeCost && $repair->repair_type === 'major') {
                $asset->acquisition_cost += $repair->cost;
                $asset->current_book_value += $repair->cost;
            }
            
            $assets->save($asset);

            $assetService = new AssetService();
            $assetService->logAction($asset->id, 'repair_completed', $userId, 'Repair completed. Capitalized: ' . ($capitalizeCost ? 'Yes' : 'No'));
            return true;
        }
        return false;
    }
}
