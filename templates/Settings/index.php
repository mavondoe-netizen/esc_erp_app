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
                    echo $this->Form->control('apwcs_rate', [
                        'label'       => 'APWCS Rate (%) — NSSA Employer Levy (Industry-Specific)',
                        'step'        => '0.0001',
                        'placeholder' => 'e.g. 2.5 for 2.5%',
                        'help'        => 'Set per company based on the NSSA industry category this company is registered under.',
                    ]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Save Settings')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

