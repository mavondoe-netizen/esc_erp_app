<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 * @var \Cake\Collection\CollectionInterface|string[] $accounts
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Products'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="products form content">
            <?= $this->Form->create($product) ?>
            <fieldset>
                <legend><?= __('Add Product') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('account_id', ['options' => $accounts]);
                    echo $this->Form->control('unit_price', ['step' => '0.01']);
                    echo $this->Form->control('vat_rate', ['step' => '0.01']);
                    echo $this->Form->control('hs_code', [
                        'options' => [
                            '99001000' => '99001000',
                            '99002000' => '99002000',
                            '99003000' => '99003000'
                        ], 
                        'empty' => true
                    ]);
                    echo $this->Form->control('vat_type', ['options' => ['Standard' => 'Standard', 'Zero' => 'Zero', 'Exempt' => 'Exempt'], 'empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const hsCodeInput = document.getElementById('hs-code');
    const vatRateInput = document.getElementById('vat-rate');
    const vatTypeInput = document.getElementById('vat-type');

    if (hsCodeInput) {
        hsCodeInput.addEventListener('change', function() {
            if (this.value === '99001000') {
                vatRateInput.value = '15.50';
                vatTypeInput.value = 'Standard';
            } else if (this.value === '99002000') {
                vatRateInput.value = '0.00';
                vatTypeInput.value = 'Zero';
            } else if (this.value === '99003000') {
                vatRateInput.value = '0.00';
                vatTypeInput.value = 'Exempt';
            }
        });
    }
});
</script>
