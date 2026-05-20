<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 * @var string[]|\Cake\Collection\CollectionInterface $accounts
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $product->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $product->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Products'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="products form content">
            <?= $this->Form->create($product) ?>
            <fieldset>
                <legend><?= __('Edit Product') ?></legend>
                <?php
                    echo $this->Form->control('name');
                ?>
                <div class="quick-add-group">
                    <div class="form-control-wrapper">
                        <?= $this->Form->control('account_id', ['options' => $accounts, 'id' => 'account-id', 'empty' => true]) ?>
                    </div>
                    <button type="button" class="global-quick-add-btn button button-outline" data-url="/accounts/index?popup=1" data-target-dropdown="account-id" title="Search/Pick Account">
                        <i class="fa fa-search"></i>
                    </button>
                    <button type="button" class="global-quick-add-btn button button-outline" data-url="/accounts/add?popup=1" data-target-dropdown="account-id" title="Add New Account">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
                <?php
                    echo $this->Form->control('unit_price', ['step' => '0.01', 'id' => 'unit-price']);
                    echo $this->Form->control('vat_rate', ['step' => '0.01', 'id' => 'vat-rate']);
                    echo $this->Form->control('hs_code', [
                        'options' => [
                            '99001000' => '99001000',
                            '99002000' => '99002000',
                            '99003000' => '99003000'
                        ], 
                        'empty' => true,
                        'label' => 'HS Code',
                        'id' => 'hs-code'
                    ]);
                    echo $this->Form->control('vat_type', [
                        'options' => ['Standard' => 'Standard', 'Zero' => 'Zero', 'Exempt' => 'Exempt'], 
                        'empty' => true,
                        'id' => 'vat-type'
                    ]);
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
