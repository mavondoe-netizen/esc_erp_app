<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var \App\Model\Entity\Invitation $invitation
 */
?>
<div class="users form content" style="max-width: 400px; margin: 0 auto; padding-top: 50px;">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Accept Invitation') ?></legend>
        <p>Welcome! You have been invited to join <strong><?= h($invitation->company_id ? 'your team' : 'the system') ?></strong>.</p>
        <p>Email: <strong><?= h($invitation->email) ?></strong></p>
        <p>Please set a secure password to activate your account.</p>
        <?php
            echo $this->Form->control('password', [
                'type' => 'password',
                'label' => 'New Password',
                'required' => true
            ]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Create Account')) ?>
    <?= $this->Form->end() ?>
</div>
