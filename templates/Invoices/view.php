/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Invoice $invoice
 * @var \App\Model\Entity\Company $company
 */
?>
<style>
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
        background: #fff;
    }

    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
        border-collapse: collapse;
    }

    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }

    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }

    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }

    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }

    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }

    .invoice-box table tr.item td {
        border-bottom: 1px solid #eee;
    }

    .invoice-box table tr.item.last td {
        border-bottom: none;
    }

    @media print {
        body * {
            visibility: hidden;
        }
        .invoice-box, .invoice-box * {
            visibility: visible;
        }
        .invoice-box {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            border: none;
            box-shadow: none;
        }
        .actions, .top-nav, .navigation {
            display: none !important;
        }
    }
</style>

<div class="row">
    <aside class="column actions" style="max-width: 200px;">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <a href="#" onclick="window.print();" class="side-nav-item button button-outline">Print Invoice</a>
            <?= $this->Html->link(__('Edit Invoice'), ['action' => 'edit', $invoice->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Invoice'), ['action' => 'delete', $invoice->id], ['confirm' => __('Are you sure you want to delete # {0}?', $invoice->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Invoices'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column">
        <div class="invoice-box">
            <table cellpadding="0" cellspacing="0">
                <tr class="top">
                    <td colspan="6">
                        <table>
                            <tr>
                                <td class="title">
                                    <?php if ($company->logo): ?>
                                        <img src="<?= h($company->logo) ?>" style="width: 100%; max-width: 150px; border-radius:5px;" alt="Logo" />
                                    <?php else: ?>
                                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($company->name) ?>&background=0D8ABC&color=fff&size=100" style="width: 100%; max-width: 100px; border-radius:10px;" alt="Avatar" />
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong>INVOICE</strong><br />
                                    Invoice #: <?= h($invoice->id) ?><br />
                                    Created: <?= h($invoice->date) ?><br />
                                    Status: <?= h($invoice->status) ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr class="information">
                    <td colspan="6">
                        <table>
                            <tr>
                                <td>
                                    <strong><?= h($company->name) ?></strong><br />
                                    <?= h($company->phone) ?><br />
                                    <?= h($company->email) ?><br />
                                    <?= nl2br(h($company->address)) ?>
                                </td>
                                <td>
                                    <strong>Bill To:</strong><br />
                                    <?= $invoice->hasValue('customer') ? h($invoice->customer->name) : 'N/A' ?><br />
                                    <?= $invoice->hasValue('customer') ? nl2br(h($invoice->customer->address)) : 'N/A' ?><br />
                                    <?= $invoice->hasValue('customer') && preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $invoice->customer->address) ? '' : ($invoice->hasValue('customer') && $invoice->customer->hasValue('contact') ? h($invoice->customer->contact->email) : '') ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr class="heading">
                    <td style="text-align: left;">Item</td>
                    <td style="text-align: center;">Quantity</td>
                    <td style="text-align: right;">Unit Price</td>
                    <td style="text-align: right;">VAT Rate</td>
                    <td style="text-align: right;">VAT Amount</td>
                    <td style="text-align: right;">Line Total</td>
                </tr>

                <?php 
                $subtotal = 0;
                $totalVat = 0;
                ?>
                <?php if (!empty($invoice->invoice_items)) : ?>
                    <?php foreach ($invoice->invoice_items as $item) : ?>
                        <?php 
                        $vatRate = $item->vat_rate ?? 0;
                        $vatAmount = $item->vat_amount ?? 0;
                        $basePrice = $item->quantity * $item->unit_price;
                        
                        $subtotal += $basePrice;
                        $totalVat += $vatAmount;
                        ?>
                        <tr class="item">
                            <td style="text-align: left;"><?= $item->hasValue('product') ? h($item->product->name) : 'Custom Item' ?></td>
                            <td style="text-align: center;"><?= $this->Number->format($item->quantity) ?></td>
                            <td style="text-align: right;"><?= $this->Number->currency($item->unit_price, $invoice->currency) ?></td>
                            <td style="text-align: right;"><?= $this->Number->format($vatRate) ?>%</td>
                            <td style="text-align: right;"><?= $this->Number->currency($vatAmount, $invoice->currency) ?></td>
                            <td style="text-align: right;"><?= $this->Number->currency($item->line_total, $invoice->currency) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr class="item"><td colspan="6" style="text-align: center;">No items found.</td></tr>
                <?php endif; ?>

                <tr class="total">
                    <td colspan="4"></td>
                    <td style="text-align: right; font-weight: bold;">Subtotal:</td>
                    <td style="text-align: right; border-top: 2px solid #eee;"><?= $this->Number->currency($subtotal, $invoice->currency) ?></td>
                </tr>
                <tr class="total">
                    <td colspan="4"></td>
                    <td style="text-align: right; font-weight: bold;">Total VAT:</td>
                    <td style="text-align: right;"><?= $this->Number->currency($totalVat, $invoice->currency) ?></td>
                </tr>
                <tr class="total">
                    <td colspan="4"></td>
                    <td style="text-align: right; font-weight: bold; font-size: 1.2em;">Grand Total:</td>
                    <td style="text-align: right; font-weight: bold; font-size: 1.2em;"><?= $this->Number->currency($invoice->total, $invoice->currency) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>