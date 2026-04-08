<?php
namespace App\Service;

use Cake\ORM\TableRegistry;

class RiskService
{
    /**
     * Re-calculate and update risk scores for a specific Risk based on its assessments.
     * 
     * @param int $riskId The risk ID
     * @return bool
     */
    public function calculateRiskScore(int $riskId): bool
    {
        $risksTable = TableRegistry::getTableLocator()->get('Risks');
        $assessmentsTable = TableRegistry::getTableLocator()->get('RiskAssessments');

        $risk = $risksTable->get($riskId);

        // Get all assessments for this risk
        $assessments = $assessmentsTable->find()
            ->where(['risk_id' => $riskId])
            ->all();

        if ($assessments->isEmpty()) {
            return true;
        }

        // Calculate average Likelihood and Impact for inherent risk
        $totalLikelihood = 0;
        $totalImpact = 0;
        $totalEffectiveness = 0;
        $count = $assessments->count();

        foreach ($assessments as $assessment) {
            $totalLikelihood += $assessment->likelihood;
            $totalImpact += $assessment->impact;
            $totalEffectiveness += $assessment->control_effectiveness;

            // Optional: update individual risk rating on the assessment
            $assessment->risk_rating = $assessment->likelihood * $assessment->impact;
            $assessmentsTable->save($assessment);
        }

        $avgLikelihood = $totalLikelihood / $count;
        $avgImpact = $totalImpact / $count;
        $avgEffectiveness = $totalEffectiveness / $count;

        $inherentRiskScore = $avgLikelihood * $avgImpact;
        // Residual Risk = Inherent Risk - Control Effectiveness
        $residualRiskScore = max(0, $inherentRiskScore - $avgEffectiveness);

        $risk->inherent_risk_score = $inherentRiskScore;
        $risk->residual_risk_score = $residualRiskScore;

        // Optionally map score to High/Medium/Low
        // ...

        return (bool)$risksTable->save($risk);
    }
}
