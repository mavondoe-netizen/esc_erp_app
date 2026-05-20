<?php
/**
 * @var \App\View\AppView $this
 * @var float $totalValue
 * @var float $weightedValue
 * @var array $byStage
 * @var array $byType
 */
$this->assign('title', 'Deal Analytics');
?>
<div class="row">
    <div class="column">
        <div class="deals index content">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3><?= __('Deal Analytics') ?></h3>
                <div>
                    <?= $this->Html->link(__('List Deals'), ['action' => 'index'], ['class' => 'button button-outline']) ?>
                    <?= $this->Html->link(__('Pipeline Board'), ['action' => 'pipeline'], ['class' => 'button button-outline']) ?>
                </div>
            </div>

            <div class="row" style="margin-bottom: 30px;">
                <div class="column column-50">
                    <div style="background: #f8f9fa; border: 1px solid #e1e4e8; border-radius: 8px; padding: 20px; text-align: center;">
                        <h4 style="color: #666; margin-bottom: 5px; font-weight: normal;">Total Pipeline Value</h4>
                        <h2 style="margin: 0; color: #2c3e50;">$<?= $this->Number->format($totalValue) ?></h2>
                    </div>
                </div>
                <div class="column column-50">
                    <div style="background: #f8f9fa; border: 1px solid #e1e4e8; border-radius: 8px; padding: 20px; text-align: center;">
                        <h4 style="color: #666; margin-bottom: 5px; font-weight: normal;">Weighted Forecast Value</h4>
                        <h2 style="margin: 0; color: #27ae60;">$<?= $this->Number->format($weightedValue) ?></h2>
                        <small style="color: #888;">(Value × Probability)</small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="column column-50">
                    <div style="background: #fff; border: 1px solid #e1e4e8; border-radius: 8px; padding: 20px;">
                        <h4>Deals by Stage</h4>
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="border-bottom: 2px solid #ddd;">
                                    <th style="padding: 10px; text-align: left;">Stage</th>
                                    <th style="padding: 10px; text-align: center;">Count</th>
                                    <th style="padding: 10px; text-align: right;">Total Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($byStage as $stat): ?>
                                <tr style="border-bottom: 1px solid #eee;">
                                    <td style="padding: 10px;"><?= h($stat['stage']) ?></td>
                                    <td style="padding: 10px; text-align: center;"><?= h($stat['count']) ?></td>
                                    <td style="padding: 10px; text-align: right;">$<?= $this->Number->format($stat['total']) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="column column-50">
                    <div style="background: #fff; border: 1px solid #e1e4e8; border-radius: 8px; padding: 20px;">
                        <h4>Deals by Type</h4>
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="border-bottom: 2px solid #ddd;">
                                    <th style="padding: 10px; text-align: left;">Type</th>
                                    <th style="padding: 10px; text-align: center;">Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($byType as $stat): ?>
                                <tr style="border-bottom: 1px solid #eee;">
                                    <td style="padding: 10px;"><?= h($stat['type']) ?></td>
                                    <td style="padding: 10px; text-align: center;"><?= h($stat['count']) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
