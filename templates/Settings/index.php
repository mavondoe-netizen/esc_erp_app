<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Setting $setting
 */
?>
<div class="settings-layout">
    <?= $this->element('settings_sidebar') ?>
    <div class="settings-content">
        <div class="settings form content">
            <?= $this->Form->create($setting) ?>
            <fieldset>
                <legend><?= __('Zimbabwe Statutory Settings') ?></legend>
                <?php
                    echo $this->Form->control('nssa_ceiling', ['label' => 'USD NSSA Ceiling Limit']);
                    echo $this->Form->control('nssa_rate', ['label' => 'Standard NSSA Rate (%)', 'step' => '0.01']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Save Settings')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

