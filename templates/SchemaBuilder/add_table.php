<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', 'Add New Model');
?>

<div class="dashboard-header" style="margin-bottom: 2rem;">
    <h2 style="color: var(--color-primary); font-weight: 700; margin: 0;">Create New Model</h2>
    <p style="color: var(--color-text-muted); font-size: 0.875rem;">This will create the database table and generate the Model, Controller, and Template files in the background.</p>
</div>

<div class="content-card" style="max-width: 600px;">
    <?= $this->Form->create(null) ?>
    <div style="margin-bottom: 1.5rem;">
        <label for="table_name" style="display: block; font-weight: 500; margin-bottom: 0.5rem; color: var(--color-text-main);">Model/Table Name (Plural)</label>
        <?= $this->Form->control('table_name', [
            'type' => 'text',
            'required' => true,
            'class' => 'form-control',
            'pattern' => '[a-z_]+',
            'placeholder' => 'e.g., custom_events',
            'title' => 'Only lowercase letters and underscores allowed.',
            'label' => false
        ]) ?>
        <small style="color: var(--color-text-muted); display: block; margin-top: 0.5rem;">Wait a few seconds after submitting for the background generator to complete.</small>
    </div>
    
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <?= $this->Form->button(__('Generate Model'), ['class' => 'btn btn-primary']) ?>
        <?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'btn btn-outline']) ?>
    </div>
    <?= $this->Form->end() ?>
</div>
