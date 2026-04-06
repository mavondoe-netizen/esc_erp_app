<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Transaction> $transactions
 */
?>
<div class="transactions index content">
    <?= $this->Html->link(__('New Transaction'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Transactions') ?></h3>
    
    <div class="filters" style="margin-bottom: 20px; padding: 15px; background: #f9f9f9; border-radius: 5px;">
        <?= $this->Form->create(null, ['type' => 'get', 'class' => 'row align-items-end']) ?>
        <div class="column column-20">
            <?= $this->Form->control('start_date', ['type' => 'date', 'value' => $this->request->getQuery('start_date'), 'label' => 'Start Date', 'required' => false]) ?>
        </div>
        <div class="column column-20">
            <?= $this->Form->control('end_date', ['type' => 'date', 'value' => $this->request->getQuery('end_date'), 'label' => 'End Date', 'required' => false]) ?>
        </div>
        <div class="column column-20">
            <?= $this->Form->control('category', ['options' => $categories, 'empty' => '-- Any Category --', 'value' => $this->request->getQuery('category'), 'label' => 'Account Category', 'required' => false]) ?>
        </div>
        <div class="column column-20">
            <?= $this->Form->control('account_id', ['options' => $accounts, 'empty' => '-- Any Account --', 'value' => $this->request->getQuery('account_id'), 'label' => 'Account', 'required' => false]) ?>
        </div>
        <div class="column column-20">
            <?= $this->Form->control('search', ['type' => 'text', 'value' => $this->request->getQuery('search'), 'label' => 'Search Description', 'placeholder' => 'Description...', 'required' => false]) ?>
        </div>
        <div class="column column-100" style="text-align: right; margin-top: 10px;">
            <?= $this->Html->link('Clear Filters', ['action' => 'index'], ['class' => 'button button-clear', 'style' => 'margin-right: 15px;']) ?>
            <?= $this->Form->button(__('Filter'), ['class' => 'button']) ?>
        </div>
        <?= $this->Form->end() ?>
    </div>
    <div class="bulk-actions" style="margin-bottom: 20px; display: none;">
        <select id="bulk-action" style="width: 200px; display: inline-block; padding: 5px;">
            <option value="">-- Select Bulk Action --</option>
            <option value="delete">Delete Selected</option>
        </select>
        <button id="apply-bulk-action" class="button button-outline" style="margin-bottom: 0;">Apply</button>
    </div>
    <div class="table-responsive">
        <table id="transactions-table">
            <thead>
                <tr>
                    <th style="width: 40px; text-align: center;"><input type="checkbox" id="select-all-rows"></th>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('date') ?></th>
                    <th><?= $this->Paginator->sort('description') ?></th>
                    <th><?= $this->Paginator->sort('currency') ?></th>
                    <th><?= $this->Paginator->sort('amount') ?></th>
                    <th><?= $this->Paginator->sort('zwg') ?></th>
                    <th><?= $this->Paginator->sort('type') ?></th>
                    <th><?= $this->Paginator->sort('account_id') ?></th>
                    <th><?= $this->Paginator->sort('building_id') ?></th>
                    <th><?= $this->Paginator->sort('tenant_id') ?></th>
                    <th><?= $this->Paginator->sort('supplier_id') ?></th>
                    <th><?= $this->Paginator->sort('customer_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $transaction): ?>
                <tr id="row-<?= $transaction->id ?>">
                    <td style="text-align: center;"><input type="checkbox" class="row-checkbox" value="<?= $transaction->id ?>"></td>
                    <td><?= $this->Number->format($transaction->id) ?></td>
                    <td><?= h($transaction->date) ?></td>
                    <td><?= h($transaction->description) ?></td>
                    <td><?= h($transaction->currency) ?></td>
                    <td><?= $this->Number->format($transaction->amount) ?></td>
                    <td><?= $this->Number->format($transaction->zwg) ?></td>
                    <td><?= h($transaction->type) ?></td>
                    <td><?= $transaction->hasValue('account') ? $this->Html->link($transaction->account->name, ['controller' => 'Accounts', 'action' => 'view', $transaction->account->id]) : '' ?></td>
                    <td><?= $transaction->hasValue('building') ? $this->Html->link($transaction->building->name, ['controller' => 'Buildings', 'action' => 'view', $transaction->building->id]) : '' ?></td>
                    <td><?= $transaction->hasValue('tenant') ? $this->Html->link($transaction->tenant->name, ['controller' => 'Tenants', 'action' => 'view', $transaction->tenant->id]) : '' ?></td>
                    <td><?= $transaction->hasValue('supplier') ? $this->Html->link($transaction->supplier->name, ['controller' => 'Suppliers', 'action' => 'view', $transaction->supplier->id]) : '' ?></td>
                    <td><?= $transaction->hasValue('customer') ? $this->Html->link($transaction->customer->name, ['controller' => 'Customers', 'action' => 'view', $transaction->customer->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $transaction->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $transaction->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $transaction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $transaction->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>

<?php $this->append('script'); ?>
<script>
$(document).ready(function() {
    const csrfToken = $('meta[name="csrfToken"]').attr('content');

    // Toggle bulk actions visibility
    function toggleBulkActions() {
        if ($('.row-checkbox:checked').length > 0) {
            $('.bulk-actions').fadeIn();
        } else {
            $('.bulk-actions').fadeOut();
        }
    }

    // Select all
    $('#select-all-rows').change(function() {
        $('.row-checkbox').prop('checked', $(this).prop('checked'));
        toggleBulkActions();
    });

    // Row selection
    $('.row-checkbox').change(function() {
        if ($('.row-checkbox:checked').length === $('.row-checkbox').length) {
            $('#select-all-rows').prop('checked', true);
        } else {
            $('#select-all-rows').prop('checked', false);
        }
        toggleBulkActions();
    });

    // Handle Bulk Action
    $('#apply-bulk-action').click(function() {
        const action = $('#bulk-action').val();
        if (!action) {
            alert('Please select an action first.');
            return;
        }

        const ids = [];
        $('.row-checkbox:checked').each(function() {
            ids.push($(this).val());
        });

        if (ids.length === 0) return;

        if (action === 'delete') {
            if (!confirm(`Are you sure you want to delete ${ids.length} selected transactions?`)) {
                return;
            }
        }

        const btn = $(this);
        btn.prop('disabled', true).text('Processing...');

        $.ajax({
            url: "<?= $this->Url->build(['action' => 'bulkAction']) ?>",
            type: 'POST',
            headers: { 'X-CSRF-Token': csrfToken },
            data: { action: action, ids: ids },
            success: function(res) {
                if (res.success) {
                    alert(res.message);
                    location.reload();
                } else {
                    alert('Error: ' + res.message);
                    btn.prop('disabled', false).text('Apply');
                }
            },
            error: function() {
                alert('An error occurred during processing.');
                btn.prop('disabled', false).text('Apply');
            }
        });
    });
});
</script>
<?php $this->end(); ?>