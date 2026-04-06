<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Company $company
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Company'), ['action' => 'edit', $company->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Company'), ['action' => 'delete', $company->id], ['confirm' => __('Are you sure you want to delete # {0}?', $company->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Companies'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Company'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="companies view content">
            <h3><?= h($company->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($company->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Address') ?></th>
                    <td><?= h($company->address) ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone') ?></th>
                    <td><?= h($company->phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($company->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($company->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($company->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($company->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Accounts') ?></h4>
                <?php if (!empty($company->accounts)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Category') ?></th>
                            <th><?= __('Type') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($company->accounts as $account) : ?>
                        <tr>
                            <td><?= h($account->id) ?></td>
                            <td><?= h($account->name) ?></td>
                            <td><?= h($account->category) ?></td>
                            <td><?= h($account->type) ?></td>
                            <td><?= h($account->company_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Accounts', 'action' => 'view', $account->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Accounts', 'action' => 'edit', $account->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Accounts', 'action' => 'delete', $account->id], ['confirm' => __('Are you sure you want to delete # {0}?', $account->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Customers') ?></h4>
                <?php if (!empty($company->customers)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Address') ?></th>
                            <th><?= __('Contact Id') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($company->customers as $customer) : ?>
                        <tr>
                            <td><?= h($customer->id) ?></td>
                            <td><?= h($customer->name) ?></td>
                            <td><?= h($customer->address) ?></td>
                            <td><?= h($customer->contact_id) ?></td>
                            <td><?= h($customer->company_id) ?></td>
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
                <h4><?= __('Related Employees') ?></h4>
                <?php if (!empty($company->employees)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Employee Code') ?></th>
                            <th><?= __('First Name') ?></th>
                            <th><?= __('Last Name') ?></th>
                            <th><?= __('Nssa Number') ?></th>
                            <th><?= __('Tax Number') ?></th>
                            <th><?= __('Date Of Birth') ?></th>
                            <th><?= __('Disabled') ?></th>
                            <th><?= __('Designation') ?></th>
                            <th><?= __('Basic Salary') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('National Identity') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($company->employees as $employee) : ?>
                        <tr>
                            <td><?= h($employee->id) ?></td>
                            <td><?= h($employee->employee_code) ?></td>
                            <td><?= h($employee->first_name) ?></td>
                            <td><?= h($employee->last_name) ?></td>
                            <td><?= h($employee->nssa_number) ?></td>
                            <td><?= h($employee->tax_number) ?></td>
                            <td><?= h($employee->date_of_birth) ?></td>
                            <td><?= h($employee->disabled) ?></td>
                            <td><?= h($employee->designation) ?></td>
                            <td><?= h($employee->basic_salary) ?></td>
                            <td><?= h($employee->created) ?></td>
                            <td><?= h($employee->modified) ?></td>
                            <td><?= h($employee->national_identity) ?></td>
                            <td><?= h($employee->company_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Employees', 'action' => 'view', $employee->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Employees', 'action' => 'edit', $employee->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Employees', 'action' => 'delete', $employee->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employee->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Invoices') ?></h4>
                <?php if (!empty($company->invoices)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Currency') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Total') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($company->invoices as $invoice) : ?>
                        <tr>
                            <td><?= h($invoice->id) ?></td>
                            <td><?= h($invoice->date) ?></td>
                            <td><?= h($invoice->customer_id) ?></td>
                            <td><?= h($invoice->currency) ?></td>
                            <td><?= h($invoice->description) ?></td>
                            <td><?= h($invoice->status) ?></td>
                            <td><?= h($invoice->total) ?></td>
                            <td><?= h($invoice->company_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Invoices', 'action' => 'view', $invoice->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Invoices', 'action' => 'edit', $invoice->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Invoices', 'action' => 'delete', $invoice->id], ['confirm' => __('Are you sure you want to delete # {0}?', $invoice->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Payslip Items') ?></h4>
                <?php if (!empty($company->payslip_items)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Payslip Id') ?></th>
                            <th><?= __('Item Type') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Amount') ?></th>
                            <th><?= __('Currency') ?></th>
                            <th><?= __('Is Permanent') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($company->payslip_items as $payslipItem) : ?>
                        <tr>
                            <td><?= h($payslipItem->id) ?></td>
                            <td><?= h($payslipItem->payslip_id) ?></td>
                            <td><?= h($payslipItem->item_type) ?></td>
                            <td><?= h($payslipItem->name) ?></td>
                            <td><?= h($payslipItem->amount) ?></td>
                            <td><?= h($payslipItem->currency) ?></td>
                            <td><?= h($payslipItem->is_permanent) ?></td>
                            <td><?= h($payslipItem->company_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'PayslipItems', 'action' => 'view', $payslipItem->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'PayslipItems', 'action' => 'edit', $payslipItem->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'PayslipItems', 'action' => 'delete', $payslipItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $payslipItem->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Payslips') ?></h4>
                <?php if (!empty($company->payslips)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Employee Id') ?></th>
                            <th><?= __('Pay Period Id') ?></th>
                            <th><?= __('Gross Pay') ?></th>
                            <th><?= __('Deductions') ?></th>
                            <th><?= __('Net Pay') ?></th>
                            <th><?= __('Exchange Rate') ?></th>
                            <th><?= __('Generated Date') ?></th>
                            <th><?= __('Basic Salary') ?></th>
                            <th><?= __('Allowances') ?></th>
                            <th><?= __('Bonuses') ?></th>
                            <th><?= __('Overtime') ?></th>
                            <th><?= __('Benefits') ?></th>
                            <th><?= __('Pension') ?></th>
                            <th><?= __('Nssa') ?></th>
                            <th><?= __('Medical Aid') ?></th>
                            <th><?= __('Medical Expenses') ?></th>
                            <th><?= __('Taxable Income') ?></th>
                            <th><?= __('Paye') ?></th>
                            <th><?= __('Tax Credits') ?></th>
                            <th><?= __('Aids Levy') ?></th>
                            <th><?= __('Total Tax') ?></th>
                            <th><?= __('Usd Gross') ?></th>
                            <th><?= __('Usd Deductions') ?></th>
                            <th><?= __('Usd Net') ?></th>
                            <th><?= __('Zwg Gross') ?></th>
                            <th><?= __('Zwg Deductions') ?></th>
                            <th><?= __('Zwg Net') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($company->payslips as $payslip) : ?>
                        <tr>
                            <td><?= h($payslip->id) ?></td>
                            <td><?= h($payslip->employee_id) ?></td>
                            <td><?= h($payslip->pay_period_id) ?></td>
                            <td><?= h($payslip->gross_pay) ?></td>
                            <td><?= h($payslip->deductions) ?></td>
                            <td><?= h($payslip->net_pay) ?></td>
                            <td><?= h($payslip->exchange_rate) ?></td>
                            <td><?= h($payslip->generated_date) ?></td>
                            <td><?= h($payslip->basic_salary) ?></td>
                            <td><?= h($payslip->allowances) ?></td>
                            <td><?= h($payslip->bonuses) ?></td>
                            <td><?= h($payslip->overtime) ?></td>
                            <td><?= h($payslip->benefits) ?></td>
                            <td><?= h($payslip->pension) ?></td>
                            <td><?= h($payslip->nssa) ?></td>
                            <td><?= h($payslip->medical_aid) ?></td>
                            <td><?= h($payslip->medical_expenses) ?></td>
                            <td><?= h($payslip->taxable_income) ?></td>
                            <td><?= h($payslip->paye) ?></td>
                            <td><?= h($payslip->tax_credits) ?></td>
                            <td><?= h($payslip->aids_levy) ?></td>
                            <td><?= h($payslip->total_tax) ?></td>
                            <td><?= h($payslip->usd_gross) ?></td>
                            <td><?= h($payslip->usd_deductions) ?></td>
                            <td><?= h($payslip->usd_net) ?></td>
                            <td><?= h($payslip->zwg_gross) ?></td>
                            <td><?= h($payslip->zwg_deductions) ?></td>
                            <td><?= h($payslip->zwg_net) ?></td>
                            <td><?= h($payslip->company_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Payslips', 'action' => 'view', $payslip->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Payslips', 'action' => 'edit', $payslip->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Payslips', 'action' => 'delete', $payslip->id], ['confirm' => __('Are you sure you want to delete # {0}?', $payslip->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Products') ?></h4>
                <?php if (!empty($company->products)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Account Id') ?></th>
                            <th><?= __('Unit Price') ?></th>
                            <th><?= __('Vat Rate') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($company->products as $product) : ?>
                        <tr>
                            <td><?= h($product->id) ?></td>
                            <td><?= h($product->name) ?></td>
                            <td><?= h($product->account_id) ?></td>
                            <td><?= h($product->unit_price) ?></td>
                            <td><?= h($product->vat_rate) ?></td>
                            <td><?= h($product->created) ?></td>
                            <td><?= h($product->modified) ?></td>
                            <td><?= h($product->company_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Products', 'action' => 'view', $product->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Products', 'action' => 'edit', $product->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Products', 'action' => 'delete', $product->id], ['confirm' => __('Are you sure you want to delete # {0}?', $product->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Transactions') ?></h4>
                <?php if (!empty($company->transactions)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Currency') ?></th>
                            <th><?= __('Amount') ?></th>
                            <th><?= __('Zwg') ?></th>
                            <th><?= __('Type') ?></th>
                            <th><?= __('Account Id') ?></th>
                            <th><?= __('Building Id') ?></th>
                            <th><?= __('Tenant Id') ?></th>
                            <th><?= __('Supplier Id') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($company->transactions as $transaction) : ?>
                        <tr>
                            <td><?= h($transaction->id) ?></td>
                            <td><?= h($transaction->date) ?></td>
                            <td><?= h($transaction->description) ?></td>
                            <td><?= h($transaction->currency) ?></td>
                            <td><?= h($transaction->amount) ?></td>
                            <td><?= h($transaction->zwg) ?></td>
                            <td><?= h($transaction->type) ?></td>
                            <td><?= h($transaction->account_id) ?></td>
                            <td><?= h($transaction->building_id) ?></td>
                            <td><?= h($transaction->tenant_id) ?></td>
                            <td><?= h($transaction->supplier_id) ?></td>
                            <td><?= h($transaction->customer_id) ?></td>
                            <td><?= h($transaction->company_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Transactions', 'action' => 'view', $transaction->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Transactions', 'action' => 'edit', $transaction->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Transactions', 'action' => 'delete', $transaction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $transaction->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Users') ?></h4>
                <?php if (!empty($company->users)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Password') ?></th>
                            <th><?= __('Role Id') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($company->users as $user) : ?>
                        <tr>
                            <td><?= h($user->id) ?></td>
                            <td><?= h($user->email) ?></td>
                            <td><?= h($user->password) ?></td>
                            <td><?= h($user->role_id) ?></td>
                            <td><?= h($user->company_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Users', 'action' => 'view', $user->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Users', 'action' => 'edit', $user->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Users', 'action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
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