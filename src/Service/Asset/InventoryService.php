<?php
declare(strict_types=1);

namespace App\Service\Asset;

use Cake\ORM\Locator\LocatorAwareTrait;

class InventoryService
{
    use LocatorAwareTrait;

    public function getOfficeInventory(int $officeId)
    {
        return $this->fetchTable('Assets')->find()
            ->where(['office_id' => $officeId, 'status' => 'active'])
            ->contain(['AssetCategories', 'AssetClassifications'])
            ->all();
    }
    
    public function getDepartmentInventory(int $departmentId)
    {
        return $this->fetchTable('AssetAssignments')->find()
            ->where(['department_id' => $departmentId, 'status' => 'active'])
            ->contain(['Assets'])
            ->all();
    }
}
