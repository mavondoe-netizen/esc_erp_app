<?php
namespace App\Service;

use Cake\ORM\TableRegistry;

class IncidentService
{
    /**
     * Calculate Net Loss
     * 
     * @param float $lossAmount
     * @param float $recoveryAmount
     * @return float
     */
    public function calculateNetLoss(float $lossAmount, float $recoveryAmount): float
    {
        return max(0, $lossAmount - $recoveryAmount);
    }

    /**
     * Syncs Net Loss on Loss Events
     * @param int $lossEventId
     */
    public function syncLossEvent(int $lossEventId): bool
    {
        $lossTable = TableRegistry::getTableLocator()->get('LossEvents');
        $event = $lossTable->get($lossEventId);

        $event->net_loss = $this->calculateNetLoss((float)$event->amount, (float)$event->recovery_amount);
        return (bool)$lossTable->save($event);
    }
}
