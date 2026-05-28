<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Receipt $receipt
 * @var \Cake\Collection\CollectionInterface|string[] $customers
 * @var \Cake\Collection\CollectionInterface|string[] $accounts
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Receipts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="receipts form content">
            <?= $this->Form->create($receipt) ?>
            <fieldset>
                <legend><?= __('Add Receipt') ?></legend>
                <?php
                    echo $this->Form->control('customer_id', ['options' => $customers, 'empty' => '-- Select Customer --', 'id' => 'customer-id']);
                    echo $this->Form->control('invoice_id', ['options' => $invoices, 'empty' => '-- Select Invoice (Optional) --', 'id' => 'invoice-id']);
                    echo $this->Form->control('currency', ['options' => ['USD' => 'USD', 'ZWG' => 'ZWG', 'ZAR' => 'ZAR']]);
                    echo $this->Form->control('amount');
                    echo $this->Form->control('account_id', ['options' => $accounts, 'empty' => '-- Select Bank/Asset Account --', 'label' => 'Deposited Into Account']);
                    echo $this->Form->control('reference', ['label' => 'Reference (e.g., Bank Ref, Invoice #)']);
                    echo $this->Form->control('date');
                    echo $this->Form->control('description', ['rows' => 2]);
                    echo $this->Form->control('status', ['options' => ['Draft' => 'Draft', 'Pending Approval' => 'Pending Approval', 'Approved' => 'Approved', 'Rejected' => 'Rejected']]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'button secondary', 'style' => 'margin-left: 10px;']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function() {
    $('#customer-id').on('change', function() {
        const customerId = $(this).val();
        const $invoiceDropdown = $('#invoice-id');
        
        $invoiceDropdown.html('<option value="">-- Loading Invoices... --</option>');
        
        if (!customerId) {
            $invoiceDropdown.html('<option value="">-- Select Customer First --</option>');
            return;
        }

        $.ajax({
            url: '<?= $this->Url->build(['action' => 'apiFetchCustomerInvoices']) ?>/' + customerId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $invoiceDropdown.empty();
                $invoiceDropdown.append('<option value="">-- Select Invoice (Optional) --</option>');
                
                if (data.length === 0) {
                    $invoiceDropdown.append('<option value="">No invoices found for this customer</option>');
                } else {
                    data.forEach(function(inv) {
                        const label = 'Inv #' + inv.id + ' (' + inv.date + ') - Balance: ' + inv.balance + ' (Total: ' + inv.total + ')';
                        $invoiceDropdown.append($('<option>', {
                            value: inv.id,
                            text: label
                        }));
                    });
                }
            },
            error: function() {
                $invoiceDropdown.html('<option value="">-- Error loading invoices --</option>');
            }
        });
    });
});
</script>
