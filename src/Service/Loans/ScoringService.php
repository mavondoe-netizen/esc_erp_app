<?php
declare(strict_types=1);
namespace App\Service\Loans;

use Cake\ORM\TableRegistry;

/**
 * ScoringService — computes a client credit score (0–1000).
 *
 * Scoring formula:
 *   40% repayment history (on-time payments / total payments)
 *   30% debt ratio (monthly installment / monthly income)
 *   20% delinquency history (penalises past defaults)
 *   10% active loans count (higher count = lower score)
 */
class ScoringService
{
    public function calculate(int $clientId): object
    {
        $clientsTable   = TableRegistry::getTableLocator()->get('LoanClients');
        $loansTable     = TableRegistry::getTableLocator()->get('Loans');
        $scheduleTable  = TableRegistry::getTableLocator()->get('LoanSchedules');
        $scoresTable    = TableRegistry::getTableLocator()->get('ClientScores');

        $client = $clientsTable->get($clientId);
        $income = max(1, (float)$client->monthly_income);

        // 1. Repayment history score (40%)
        $allPeriods  = $scheduleTable->find()->matching('Loans', fn($q) => $q->where(['client_id' => $clientId]))->count();
        $paidOnTime  = $scheduleTable->find()
            ->matching('Loans', fn($q) => $q->where(['client_id' => $clientId]))
            ->where(['LoanSchedules.status' => 'paid'])
            ->count();
        $repaymentScore = $allPeriods > 0 ? ($paidOnTime / $allPeriods) * 400 : 200; // neutral if no history

        // 2. Debt ratio (30%) — total monthly installments vs income
        $activeLoans = $loansTable->find()->where(['client_id' => $clientId, 'status' => 'active'])->all();
        $totalMonthlyInstallment = 0.0;
        foreach ($activeLoans as $loan) {
            $nextPeriod = $scheduleTable->find()
                ->where(['loan_id' => $loan->id, 'status' => 'pending'])
                ->order(['due_date' => 'ASC'])->first();
            if ($nextPeriod) $totalMonthlyInstallment += (float)$nextPeriod->total_due;
        }
        $debtRatio     = min(1.0, $totalMonthlyInstallment / $income);
        $debtRatioScore = (1 - $debtRatio) * 300; // 0 debt = 300 points

        // 3. Delinquency history (20%)
        $flagsTable    = TableRegistry::getTableLocator()->get('DelinquencyFlags');
        $defaultFlags  = $flagsTable->find()
            ->matching('Loans', fn($q) => $q->where(['client_id' => $clientId]))
            ->where(['DelinquencyFlags.category IN' => ['delinquent', 'default']])->count();
        $delinquencyScore = max(0, 200 - ($defaultFlags * 50));

        // 4. Active loans penalty (10%)
        $activeCount  = $loansTable->find()->where(['client_id' => $clientId, 'status' => 'active'])->count();
        $activeScore  = max(0, 100 - ($activeCount * 20));

        $totalScore = (int)round($repaymentScore + $debtRatioScore + $delinquencyScore + $activeScore);
        $totalScore = max(0, min(1000, $totalScore));

        $grade = match(true) {
            $totalScore >= 800 => 'A',
            $totalScore >= 650 => 'B',
            $totalScore >= 500 => 'C',
            $totalScore >= 350 => 'D',
            default            => 'E',
        };

        $riskLevel = match(true) {
            $totalScore >= 800 => 'low',
            $totalScore >= 600 => 'medium',
            $totalScore >= 400 => 'high',
            default            => 'very_high',
        };

        // Upsert
        $existing = $scoresTable->find()->where(['client_id' => $clientId])->first();
        $scoreEntity = $existing ?? $scoresTable->newEmptyEntity();

        $scoreEntity = $scoresTable->patchEntity($scoreEntity, [
            'client_id'               => $clientId,
            'score'                   => $totalScore,
            'grade'                   => $grade,
            'risk_level'              => $riskLevel,
            'debt_ratio'              => round($debtRatio, 4),
            'repayment_history_score' => round($repaymentScore, 4),
            'delinquency_score'       => round($delinquencyScore, 4),
            'active_loans_count'      => $activeCount,
            'computed_at'             => date('Y-m-d H:i:s'),
        ]);
        $scoresTable->save($scoreEntity);

        return $scoreEntity;
    }
}
