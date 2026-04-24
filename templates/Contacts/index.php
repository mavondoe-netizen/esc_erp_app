<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Contact> $contacts
 */
?>
<div class="contacts index content">
    <?= $this->Html->link(__('New Contact'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Contacts') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('mobile') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= __('Roles') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contacts as $contact): ?>
                <tr>
                    <td><?= $this->Number->format($contact->id) ?></td>
                    <td><?= h($contact->name) ?></td>
                    <td><?= h($contact->mobile) ?></td>
                    <td><?= h($contact->email) ?></td>
                    <td>
                        <div style="display:flex; gap:0.35rem; flex-wrap:wrap;">
                            <?php if (!empty($contact->suppliers)): ?>
                                <span style="background:#dcfce7; color:#166534; padding:2px 8px; border-radius:12px; font-size:0.75rem; font-weight:600;">Supplier</span>
                            <?php endif; ?>
                            <?php if (!empty($contact->customers)): ?>
                                <span style="background:#e0f2fe; color:#075985; padding:2px 8px; border-radius:12px; font-size:0.75rem; font-weight:600;">Customer</span>
                            <?php endif; ?>
                            <?php if (!empty($contact->tenants)): ?>
                                <span style="background:#fef9c3; color:#854d0e; padding:2px 8px; border-radius:12px; font-size:0.75rem; font-weight:600;">Tenant</span>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $contact->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $contact->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $contact->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contact->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>