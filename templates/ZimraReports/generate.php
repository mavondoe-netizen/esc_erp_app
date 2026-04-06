<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PayPeriod $payPeriod
 * @var array $reportData
 */
?>
<div class="row">
    <div class="column">
        <div class="zimraReport generate content">
            <h3 style="margin-bottom: 1rem;">
                <?= __('ZIMRA PAYE Tax Return') ?> - <?= h($payPeriod->name) ?>
            </h3>
            
            <div style="margin-bottom: 2rem;">
                <button onclick="exportTableToCSV('zimra_report_<?= h($payPeriod->name) ?>.csv')" class="button button-outline" style="float: right;">Export to CSV</button>
                <?= $this->Html->link(__('New Report'), ['action' => 'index'], ['class' => 'button']) ?>
            </div>

            <?php if (empty($reportData)): ?>
                <div class="message notice">No payslip data found for this period.</div>
            <?php else: ?>
                <div style="overflow-x: auto; width: 100%; border: 1px solid #eee; margin-top: 1rem;">
                    <table id="zimraDataTable" class="table table-striped" style="white-space: nowrap; font-size: 0.85rem;">
                        <thead>
                            <tr>
                                <?php foreach (array_keys($reportData[0]) as $header): ?>
                                    <th><?= h($header) ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reportData as $row): ?>
                                <tr>
                                    <?php foreach ($row as $key => $value): ?>
                                        <td style="<?= is_numeric($value) ? 'text-align: right;' : '' ?>">
                                            <?= is_numeric($value) && strpos($key, ' TIN') === false && strpos($key, 'Number') === false ? $this->Number->format($value, ['places' => 2]) : h($value) ?>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;
    csvFile = new Blob([csv], {type: "text/csv"});
    downloadLink = document.createElement("a");
    downloadLink.download = filename;
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}

function exportTableToCSV(filename) {
    var csv = [];
    var table = document.getElementById("zimraDataTable");
    if (!table) return;
    
    var rows = table.querySelectorAll("tr");
    
    for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");
        
        for (var j = 0; j < cols.length; j++) {
            // Remove formatting commas for CSV export
            var text = cols[j].innerText.replace(/,/g, '');
            // Quote the text if it contains spaces or quotes to be safe
            if (text.indexOf(' ') !== -1 || text.indexOf('"') !== -1) {
                text = '"' + text.replace(/"/g, '""') + '"';
            }
            row.push(text);
        }
        
        csv.push(row.join(","));
    }
    downloadCSV(csv.join("\n"), filename);
}
</script>
