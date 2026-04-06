<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DealRequest $dealRequest
 * @var string[]|\Cake\Collection\CollectionInterface $companies
 * @var string[]|\Cake\Collection\CollectionInterface $deals
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $dealRequest->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $dealRequest->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Deal Requests'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="dealRequests form content">
            <?= $this->Form->create($dealRequest) ?>
            <fieldset>
                <legend><?= __('Edit Deal Request') ?></legend>
                <?php
                    echo $this->Form->control('first_name');
                    echo $this->Form->control('last_name');
                    echo $this->Form->control('email');
                    echo $this->Form->control('phone');
                    echo $this->Form->control('company_name');
                    echo $this->Form->control('message');
                    echo $this->Form->control('source');
                    echo $this->Form->control('status');
                    echo $this->Form->control('company_id', ['options' => $companies]);
                    echo $this->Form->control('deal_id', ['options' => $deals]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?> <?= $this->Html->link(__("Cancel"), ["action" => "index"], ["class" => "button secondary", "style" => "margin-left: 10px;"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
