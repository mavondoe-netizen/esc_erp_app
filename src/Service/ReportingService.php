<?php
namespace App\Service;

use Cake\ORM\TableRegistry;

class ReportingService
{
    /**
     * Generate Risk Heatmap Data
     * 
     * @param int $companyId
     * @return array
     */
    public function getRiskHeatmapData(int $companyId): array
    {
        $risksTable = TableRegistry::getTableLocator()->get('Risks');
        
        $risks = $risksTable->find()
            ->where(['company_id' => $companyId])
            ->all();

        $heatmap = [];
        // Map risks to likelihood vs impact grid

        return $heatmap;
    }

    /**
     * Get Open Audit Findings
     */
    public function getOpenAuditFindings(int $companyId): array
    {
        $findingsTable = TableRegistry::getTableLocator()->get('AuditFindings');
        return $findingsTable->find()
            ->where(['company_id' => $companyId, 'status !=' => 'Closed'])
            ->toArray();
    }
}
