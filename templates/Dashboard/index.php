<?php
/**
 * @var \App\View\AppView $this
 */
$this->Html->script('https://cdn.jsdelivr.net/npm/chart.js', ['block' => true]);
?>
<div class="row">
    <div class="column-responsive column-100">
        <div class="dashboard index content">
            <h3 style="margin-bottom: 2rem;"><?= __('Payroll Dashboard') ?></h3>
            <div class="row">
                <div class="column">
                    <div class="card" style="padding: 20px; background: #f4f6f9; border-left: 5px solid #2e6c80; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 20px;">
                        <h5 style="color: #666; margin-bottom: 10px; font-size: 0.95rem;">Total Base Gross (USD eq)</h5>
                        <h2 style="margin: 0; color: #333;"><?= $this->Number->currency((float)($totalGross ?? 0), 'USD') ?></h2>
                    </div>
                </div>
                <div class="column">
                    <div class="card" style="padding: 20px; background: #fffcfcfc; border-left: 5px solid #d9534f; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 20px;">
                        <h5 style="color: #666; margin-bottom: 10px; font-size: 0.95rem;">Total Deductions (USD eq)</h5>
                        <h2 style="margin: 0; color: #333;"><?= $this->Number->currency((float)($totalDeductions ?? 0), 'USD') ?></h2>
                    </div>
                </div>
                <div class="column">
                    <div class="card" style="padding: 20px; background: #fcfffcfc; border-left: 5px solid #5cb85c; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 20px;">
                        <h5 style="color: #666; margin-bottom: 10px; font-size: 0.95rem;">Total Net Pay (USD eq)</h5>
                        <h2 style="margin: 0; color: #333;"><?= $this->Number->currency((float)($totalNet ?? 0), 'USD') ?></h2>
                    </div>
                </div>
                <div class="column">
                    <div class="card" style="padding: 20px; background: #fdfafa; border-left: 5px solid #f0ad4e; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 20px;">
                        <h5 style="color: #666; margin-bottom: 10px; font-size: 0.95rem;">Outstanding Leave Total</h5>
                        <h2 style="margin: 0; color: #333;"><?= $this->Number->format((float)($outstandingLeaves ?? 0)) ?> Days</h2>
                    </div>
                </div>
            </div>

            <!-- ===================== PROPERTY MANAGEMENT ===================== -->
            <h4 style="margin:2rem 0 1rem;color:#444;border-bottom:2px solid #e8ecf0;padding-bottom:6px">
                🏢 Property Management
                <a href="<?= $this->Url->build(['controller' => 'Enrolments', 'action' => 'index']) ?>" style="font-size:0.8rem;margin-left:12px">View Leases</a> &nbsp;
                <a href="<?= $this->Url->build(['controller' => 'LeasePayments', 'action' => 'index']) ?>" style="font-size:0.8rem;margin-right:8px">Payments</a>
                <a href="<?= $this->Url->build(['controller' => 'Repairs', 'action' => 'index']) ?>" style="font-size:0.8rem;margin-right:8px">Repairs</a>
                <a href="<?= $this->Url->build(['controller' => 'Levies', 'action' => 'index']) ?>" style="font-size:0.8rem">Levies</a>
            </h4>
            <div class="row">
                <div class="column">
                    <div class="card" style="padding:20px;background:#f0f8ff;border-left:5px solid #2196f3;border-radius:4px;box-shadow:0 1px 3px rgba(0,0,0,.1);margin-bottom:20px">
                        <h5 style="color:#666;margin-bottom:8px;font-size:0.9rem">Total Units</h5>
                        <h2 style="margin:0;color:#333"><?= $totalUnits ?></h2>
                        <small style="color:#888"><?= $occupiedCount ?> occupied / <?= $vacantCount ?> vacant</small>
                    </div>
                </div>
                <div class="column">
                    <div class="card" style="padding:20px;background:#f0fff4;border-left:5px solid #4caf50;border-radius:4px;box-shadow:0 1px 3px rgba(0,0,0,.1);margin-bottom:20px">
                        <h5 style="color:#666;margin-bottom:8px;font-size:0.9rem">Occupancy Rate</h5>
                        <h2 style="margin:0;color:#333"><?= $occupancyRate ?>%</h2>
                        <div style="background:#ddd;border-radius:4px;height:6px;margin-top:8px">
                            <div style="background:#4caf50;width:<?= $occupancyRate ?>%;height:6px;border-radius:4px"></div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="card" style="padding:20px;background:#fffbf0;border-left:5px solid #ff9800;border-radius:4px;box-shadow:0 1px 3px rgba(0,0,0,.1);margin-bottom:20px">
                        <h5 style="color:#666;margin-bottom:8px;font-size:0.9rem">Rental Income (This Month)</h5>
                        <h2 style="margin:0;color:#333">USD <?= number_format((float)$monthlyRentalIncome, 2) ?></h2>
                    </div>
                </div>
                <div class="column">
                    <a href="<?= $this->Url->build(['controller' => 'Repairs', 'action' => 'index']) ?>" style="text-decoration:none">
                        <div class="card" style="padding:20px;background:<?= $openRepairs > 0 ? '#fff5f5' : '#f5fff5' ?>;border-left:5px solid <?= $openRepairs > 0 ? '#f44336' : '#4caf50' ?>;border-radius:4px;box-shadow:0 1px 3px rgba(0,0,0,.1);margin-bottom:20px">
                            <h5 style="color:#666;margin-bottom:8px;font-size:0.9rem">Open Repairs</h5>
                            <h2 style="margin:0;color:<?= $openRepairs > 0 ? '#f44336' : '#4caf50' ?>"><?= $openRepairs ?></h2>
                            <small style="color:#888">Reported or In Progress</small>
                        </div>
                    </a>
                </div>
                <div class="column">
                    <a href="<?= $this->Url->build(['controller' => 'Levies', 'action' => 'index']) ?>" style="text-decoration:none">
                        <div class="card" style="padding:20px;background:<?= $outstandingLevies > 0 ? '#fffbf0' : '#f5fff5' ?>;border-left:5px solid <?= $outstandingLevies > 0 ? '#ff9800' : '#4caf50' ?>;border-radius:4px;box-shadow:0 1px 3px rgba(0,0,0,.1);margin-bottom:20px">
                            <h5 style="color:#666;margin-bottom:8px;font-size:0.9rem">Outstanding Levies</h5>
                            <h2 style="margin:0;color:<?= $outstandingLevies > 0 ? '#ff9800' : '#4caf50' ?>"><?= $outstandingLevies ?></h2>
                            <small style="color:#888">Unpaid levy charges</small>
                        </div>
                    </a>
                </div>
            </div>
            <!-- =================== END PROPERTY MANAGEMENT =================== -->
            
            <div class="row" style="margin-top: 2rem;">
                <div class="column column-100">
                    <h4 style="margin-bottom: 20px; color: #444;">Active Modules</h4>
                    <div class="row">
                        <?php 
                        $activeCount = 0;
                        foreach($allModules as $module): 
                            if ($module->is_active): 
                                $activeCount++;
                        ?>
                            <div class="column column-25">
                                <a href="<?= $this->Url->build(['controller' => h($module->model), 'action' => 'index']) ?>" style="text-decoration: none;">
                                    <div class="card" style="padding: 20px; background: #fff; border-left: 5px solid #0275d8; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 20px; text-align: center; transition: transform 0.2s;">
                                        <h4 style="margin: 0; color: #333;"><?= h($module->name) ?></h4>
                                    </div>
                                </a>
                            </div>
                        <?php 
                            endif;
                        endforeach; 
                        if ($activeCount === 0): 
                        ?>
                            <div class="column"><p>No active modules found.</p></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top: 2rem;">
                <div class="column column-100">
                    <div class="card" style="padding: 20px; background: #fff; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        <h4 style="margin-bottom: 20px; color: #444;">Module Management</h4>
                        <table class="table table-striped" style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="border-bottom: 2px solid #ddd; text-align: left;">
                                    <th style="padding: 10px;">Module Name</th>
                                    <th style="padding: 10px;">Status</th>
                                    <th style="padding: 10px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($allModules as $module): ?>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td style="padding: 10px;"><?= h($module->name) ?></td>
                                    <td style="padding: 10px;">
                                        <?= $module->is_active ? '<span class="badge" style="background: #5cb85c; color: #fff; padding: 5px 10px; border-radius: 4px; display: inline-block;">Active</span>' : '<span class="badge" style="background: #d9534f; color: #fff; padding: 5px 10px; border-radius: 4px; display: inline-block;">Inactive</span>' ?>
                                    </td>
                                    <td style="padding: 10px;">
                                        <?= $this->Form->postLink(
                                            $module->is_active ? 'Deactivate' : 'Activate',
                                            ['controller' => 'Modules', 'action' => 'toggle', $module->id],
                                            [
                                                'block' => true, 
                                                'class' => 'btn btn-sm ' . ($module->is_active ? 'btn-danger' : 'btn-success'), 
                                                'style' => 'margin: 0; padding: 5px 10px; font-size: 0.85rem;'
                                            ]
                                        ) ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top: 2rem;">
                <div class="column column-100">
                    <div class="card" style="padding: 20px; background: #fff; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        <h4 style="margin-bottom: 20px; color: #444;">Payroll Costs to Date (USD eq)</h4>
                        <canvas id="payrollChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('payrollChart').getContext('2d');
    var payrollChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($chartLabels) ?>,
            datasets: [
                {
                    label: 'Gross Pay (USD eq)',
                    backgroundColor: 'rgba(46, 108, 128, 0.7)',
                    borderColor: 'rgba(46, 108, 128, 1)',
                    borderWidth: 1,
                    data: <?= json_encode($grossData) ?>
                },
                {
                    label: 'Deductions (USD eq)',
                    backgroundColor: 'rgba(217, 83, 79, 0.7)',
                    borderColor: 'rgba(217, 83, 79, 1)',
                    borderWidth: 1,
                    data: <?= json_encode($deductionsData) ?>
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value, index, values) {
                            return '$' + value;
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(context.parsed.y);
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });
});
</script>
<?= $this->fetch('postLink') ?>
