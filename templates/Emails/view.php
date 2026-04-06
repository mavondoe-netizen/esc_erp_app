<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Email $email
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Email'), ['action' => 'edit', $email->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Email'), ['action' => 'delete', $email->id], ['confirm' => __('Are you sure you want to delete # {0}?', $email->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Emails'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Email'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="emails view content">
            <h3><?= h($email->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($email->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Contact') ?></th>
                    <td><?= $email->hasValue('contact') ? $this->Html->link($email->contact->name, ['controller' => 'Contacts', 'action' => 'view', $email->contact->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Subject') ?></th>
                    <td><?= h($email->subject) ?></td>
                </tr>
                <tr>
                    <th><?= __('Emailto') ?></th>
                    <td><?= h($email->emailto) ?></td>
                </tr>
                <tr>
                    <th><?= __('Emailfrom') ?></th>
                    <td><?= h($email->emailfrom) ?></td>
                </tr>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $email->hasValue('company') ? $this->Html->link($email->company->name, ['controller' => 'Companies', 'action' => 'view', $email->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($email->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>