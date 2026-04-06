<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Contact $contact
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Contact'), ['action' => 'edit', $contact->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Contact'), ['action' => 'delete', $contact->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contact->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Contacts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Contact'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="contacts view content">
            <h3><?= h($contact->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($contact->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Mobile') ?></th>
                    <td><?= h($contact->mobile) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($contact->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($contact->id) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Customers') ?></h4>
                <?php if (!empty($contact->customers)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Address') ?></th>
                            <th><?= __('Contact Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($contact->customers as $customer) : ?>
                        <tr>
                            <td><?= h($customer->id) ?></td>
                            <td><?= h($customer->name) ?></td>
                            <td><?= h($customer->address) ?></td>
                            <td><?= h($customer->contact_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Customers', 'action' => 'view', $customer->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Customers', 'action' => 'edit', $customer->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Customers', 'action' => 'delete', $customer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $customer->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Emails') ?></h4>
                <?php if (!empty($contact->emails)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Contact Id') ?></th>
                            <th><?= __('Subject') ?></th>
                            <th><?= __('Emailto') ?></th>
                            <th><?= __('Emailfrom') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($contact->emails as $email) : ?>
                        <tr>
                            <td><?= h($email->id) ?></td>
                            <td><?= h($email->name) ?></td>
                            <td><?= h($email->contact_id) ?></td>
                            <td><?= h($email->subject) ?></td>
                            <td><?= h($email->emailto) ?></td>
                            <td><?= h($email->emailfrom) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Emails', 'action' => 'view', $email->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Emails', 'action' => 'edit', $email->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Emails', 'action' => 'delete', $email->id], ['confirm' => __('Are you sure you want to delete # {0}?', $email->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Investors') ?></h4>
                <?php if (!empty($contact->investors)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Contact Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($contact->investors as $investor) : ?>
                        <tr>
                            <td><?= h($investor->id) ?></td>
                            <td><?= h($investor->name) ?></td>
                            <td><?= h($investor->contact_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Investors', 'action' => 'view', $investor->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Investors', 'action' => 'edit', $investor->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Investors', 'action' => 'delete', $investor->id], ['confirm' => __('Are you sure you want to delete # {0}?', $investor->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Meetings') ?></h4>
                <?php if (!empty($contact->meetings)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Contact Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Agenda') ?></th>
                            <th><?= __('Outcomes') ?></th>
                            <th><?= __('Attachments') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($contact->meetings as $meeting) : ?>
                        <tr>
                            <td><?= h($meeting->id) ?></td>
                            <td><?= h($meeting->name) ?></td>
                            <td><?= h($meeting->contact_id) ?></td>
                            <td><?= h($meeting->user_id) ?></td>
                            <td><?= h($meeting->agenda) ?></td>
                            <td><?= h($meeting->outcomes) ?></td>
                            <td><?= h($meeting->attachments) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Meetings', 'action' => 'view', $meeting->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Meetings', 'action' => 'edit', $meeting->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Meetings', 'action' => 'delete', $meeting->id], ['confirm' => __('Are you sure you want to delete # {0}?', $meeting->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Suppliers') ?></h4>
                <?php if (!empty($contact->suppliers)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Contact Id') ?></th>
                            <th><?= __('Industry') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($contact->suppliers as $supplier) : ?>
                        <tr>
                            <td><?= h($supplier->id) ?></td>
                            <td><?= h($supplier->name) ?></td>
                            <td><?= h($supplier->contact_id) ?></td>
                            <td><?= h($supplier->industry) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Suppliers', 'action' => 'view', $supplier->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Suppliers', 'action' => 'edit', $supplier->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Suppliers', 'action' => 'delete', $supplier->id], ['confirm' => __('Are you sure you want to delete # {0}?', $supplier->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Tenants') ?></h4>
                <?php if (!empty($contact->tenants)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Contact Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($contact->tenants as $tenant) : ?>
                        <tr>
                            <td><?= h($tenant->id) ?></td>
                            <td><?= h($tenant->name) ?></td>
                            <td><?= h($tenant->contact_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Tenants', 'action' => 'view', $tenant->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Tenants', 'action' => 'edit', $tenant->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Tenants', 'action' => 'delete', $tenant->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tenant->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>