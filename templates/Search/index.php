<?php
/**
 * @var \App\View\AppView $this
 * @var array $results
 * @var string $q
 */
?>
<div class="search-everyone">
    <div class="content-header" style="margin-bottom: 2rem;">
        <h2><i class="fa fa-search"></i> Search Results for: "<?= h($q) ?>"</h2>
        <p class="text-muted">Found matches across the ERP ecosystem.</p>
    </div>

    <?php if (empty($results)): ?>
        <div class="content-box text-center" style="padding: 4rem;">
            <i class="fa fa-folder-open" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 1rem;"></i>
            <h3>No results found</h3>
            <p>We couldn't find anything matching "<?= h($q) ?>". Try a different search term.</p>
            <?= $this->Html->link(__('Return to Dashboard'), '/', ['class' => 'button']) ?>
        </div>
    <?php else: ?>
        <?php foreach ($results as $type => $rows): ?>
            <div class="search-group" style="margin-bottom: 2.5rem;">
                <h4 style="display: flex; align-items: center; gap: 0.75rem; color: var(--color-primary); border-bottom: 2px solid var(--color-primary-light); padding-bottom: 0.5rem; margin-bottom: 1rem;">
                    <?php
                    $icon = 'fa-dot-circle';
                    switch ($type) {
                        case 'Employees': $icon = 'fa-users'; break;
                        case 'Users': $icon = 'fa-user-shield'; break;
                        case 'Customers': $icon = 'fa-building'; break;
                        case 'Deals': $icon = 'fa-handshake'; break;
                        case 'Invoices': $icon = 'fa-file-invoice-dollar'; break;
                        case 'Bills': $icon = 'fa-file-invoice'; break;
                        case 'Estimates': $icon = 'fa-calculator'; break;
                        case 'DebitNotes': $icon = 'fa-minus-square'; break;
                        case 'CreditNotes': $icon = 'fa-plus-square'; break;
                        case 'Tasks': $icon = 'fa-tasks'; break;
                        case 'Products': $icon = 'fa-box'; break;
                    }
                    ?>
                    <i class="fa <?= $icon ?>"></i> <?= h($type) ?> (<?= count($rows) ?>)
                </h4>
                
                <div class="search-results-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1rem;">
                    <?php foreach ($rows as $row): ?>
                        <a href="<?= $this->Url->build(['controller' => $type, 'action' => 'view', $row->id]) ?>" class="stat-card" style="padding: 1.25rem;">
                            <div style="font-weight: 600; color: var(--color-text-heading); margin-bottom: 0.25rem;">
                                <?php
                                if ($type === 'Employees') echo h($row->first_name . ' ' . $row->last_name . ' (' . $row->employee_code . ')');
                                elseif ($type === 'Users' || $type === 'Customers' || $type === 'Products' || $type === 'Tasks' || $type === 'Deals') echo h($row->name ?? $row->email);
                                else echo h($row->description ?: 'No Description');
                                ?>
                            </div>
                            <div style="font-size: 0.85rem; color: var(--color-text-muted);">
                                <?php
                                if ($type === 'Invoices' || $type === 'Bills') echo 'ID: #' . h((string)$row->id);
                                else echo h($row->email ?? $row->employee_code ?? '');
                                ?>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
