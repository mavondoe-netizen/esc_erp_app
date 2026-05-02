<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Evaluation $evaluation
 * @var \Cake\Collection\CollectionInterface|string[] $tenders
 * @var \Cake\Collection\CollectionInterface|string[] $users
 * @var \Cake\Collection\CollectionInterface|string[] $evaluators
 * @var \Cake\Collection\CollectionInterface|string[] $suppliers
 * @var \Cake\Collection\CollectionInterface|string[] $companies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Evaluations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="evaluations form content">
            <?= $this->Form->create($evaluation) ?>
            <fieldset>
                <legend><?= __('Add Evaluation') ?></legend>
                <?php
                    echo $this->Form->control('tender_id', ['options' => $tenders]);
                    echo $this->Form->control('evaluator_id', ['options' => $evaluators]);
                    echo $this->Form->control('supplier_id', ['options' => $suppliers]);
                    echo $this->Form->control('technical_score');
                    echo $this->Form->control('financial_score');
                    echo $this->Form->control('comments');
                    echo $this->Form->control('company_id', ['options' => $companies, 'empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
