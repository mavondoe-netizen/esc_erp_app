<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Earning $earning
 * @var \Cake\Collection\CollectionInterface|string[] $accounts
 * @var array $zimraOptions
 * @var array $calculationTypes
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Earnings'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="earnings form content">
            <?= $this->Form->create($earning) ?>
            <fieldset>
                <legend><?= __('Add Earning') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo '<div class="input-group" style="display:flex; align-items:center; gap:10px; margin-bottom:1rem;">';
                    echo '<div style="flex-grow:1; margin-bottom:0;">';
                    echo $this->Form->control('account_id', ['options' => $accounts, 'style' => 'margin-bottom:0;', 'id' => 'accountDropdown']);
                    echo '</div>';
                    echo '<button type="button" class="button button-outline" id="quickAddAccountBtn" style="margin-top:25px;" title="Quick Add Account">+ Add Account</button>';
                    echo '</div>';
                    echo $this->Form->control('taxable');
                    echo $this->Form->control('pensionable');
                    echo $this->Form->control('nssa_applicable');
                    echo $this->Form->control('calculation_type', ['options' => $calculationTypes]);
                    echo $this->Form->control('zimra_mapping', ['options' => $zimraOptions, 'empty' => true]);
                    echo '<hr>';
                    echo '<h5>Advanced Logic Settings</h5>';
                    echo '<div class="row">';
                    echo '<div class="column column-33">' . $this->Form->control('gross_up', ['label' => 'Gross Up (Iterative Calculation)']) . '</div>';
                    echo '<div class="column column-33">' . $this->Form->control('taxable_percentage', ['type' => 'number', 'step' => '0.01', 'default' => 100.00, 'label' => 'Taxable Percentage (%)']) . '</div>';
                    echo '<div class="column column-33">' . $this->Form->control('tax_free_amount', ['type' => 'number', 'step' => '0.01', 'default' => 0.00, 'label' => 'Tax-Free Threshold (Fixed Amt)']) . '</div>';
                    echo '</div>';
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<!-- Quick Add Modal Structure -->
<div id="quickAddModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
   <div style="background:#fff; width:80%; height:80%; max-width:800px; border-radius:8px; display:flex; flex-direction:column; overflow:hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
       <div style="padding:15px 20px; background:#f4f4f4; border-bottom:1px solid #ddd; display:flex; justify-content:space-between; align-items:center;">
           <h4 style="margin:0;">Quick Add Account</h4>
           <button type="button" id="closeAddModal" class="button button-clear" style="padding:0; margin:0; font-size:1.5em; line-height:1; color:#dc3545;">&times;</button>
       </div>
       <iframe id="quickAddIframe" style="flex-grow:1; border:none; width:100%;" src=""></iframe>
   </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('quickAddAccountBtn');
    const modal = document.getElementById('quickAddModal');
    const closeBtn = document.getElementById('closeAddModal');
    const iframe = document.getElementById('quickAddIframe');
    const dropdown = document.getElementById('accountDropdown');

    // Make sure we have the correct base URL
    const addUrl = '<?= $this->Url->build(['controller' => 'Accounts', 'action' => 'add', '?' => ['popup' => 1]]) ?>';

    btn.addEventListener('click', function() {
        iframe.src = addUrl;
        modal.style.display = 'flex';
    });

    closeBtn.addEventListener('click', function() {
        modal.style.display = 'none';
        iframe.src = '';
    });

    // Listen for messages from the iframe
    window.addEventListener('message', function(event) {
        if (event.data && event.data.action === 'itemAdded') {
            // Close the modal
            modal.style.display = 'none';
            iframe.src = '';

            // Add the new option to the dropdown
            const newOption = new Option(event.data.name, event.data.id, true, true);
            
            // If Select2 is active, use its append method
            if (typeof $ !== 'undefined' && $(dropdown).hasClass('select2-hidden-accessible')) {
                $(dropdown).append(newOption).trigger('change');
            } else {
                dropdown.add(newOption);
                dropdown.value = event.data.id;
            }
        }
    });
});
</script>
