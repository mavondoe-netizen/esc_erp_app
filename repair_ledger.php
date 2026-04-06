<?php
/**
 * repair_ledger.php
 * 
 * Run this script ONCE via browser to scan your existing transaction history,
 * automatically pair historically un-grouped ledger rows by matching date,
 * amount, and currency, and assign them a shared transaction_group UUID.
 * 
 * Orphaned transactions (those with no matching pair found) will remain
 * WITHOUT a transaction_group so you can identify and manually delete them.
 * 
 * Access via: http://localhost/ESC_erp_app/repair_ledger.php
 */

// Bootstrap CakePHP
define('ROOT', __DIR__);
define('APP', ROOT . '/src/');
define('CONFIG', ROOT . '/config/');
define('CORE_PATH', ROOT . '/vendor/cakephp/cakephp/');

require ROOT . '/vendor/autoload.php';

use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Text;

// Load config
Configure::write('App.encoding', 'UTF-8');
Configure::write('App.defaultLocale', 'en_US');

$configFile = CONFIG . 'app.php';
Configure::load('app', 'default', false);

echo '<html><head><title>Ledger Repair</title></head><body>';
echo '<h1>Ledger Repair Tool</h1>';
echo '<style>
    body { font-family: monospace; background: #1a1a2e; color: #e0e0e0; padding: 20px; }
    h1 { color: #4fc3f7; }
    h2 { color: #81c784; }
    .success { color: #a5d6a7; }
    .warning { color: #ffcc80; }
    .error { color: #ef9a9a; }
    .info { color: #90caf9; }
    table { border-collapse: collapse; width: 100%; margin: 10px 0; }
    th { background: #37474f; color: #fff; padding: 8px; text-align: left; }
    td { padding: 6px 8px; border-bottom: 1px solid #333; }
    tr:nth-child(even) td { background: #1e2a30; }
</style>';

try {
    $db = ConnectionManager::get('default');
    $conn = $db->getDriver()->getConnection();

    // -------------------------------------------------------
    // Step 1: Fetch ALL transactions without a group assigned
    // -------------------------------------------------------
    $stmt = $conn->prepare('SELECT * FROM transactions WHERE (transaction_group IS NULL OR transaction_group = "") ORDER BY date ASC, id ASC');
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $total = count($rows);
    echo "<p class='info'>Found <strong>{$total}</strong> transactions without a transaction_group.</p>";

    if ($total === 0) {
        echo "<p class='success'>✅ All transactions are already paired. Ledger integrity looks good!</p>";
        echo '</body></html>';
        exit;
    }

    // -------------------------------------------------------
    // Step 2: Index rows by date + amount + currency for fast pairing
    // -------------------------------------------------------
    $paired = [];
    $index = [];
    
    foreach ($rows as $row) {
        $key = $row['date'] . '|' . number_format((float)$row['amount'], 2, '.', '') . '|' . $row['currency'];
        $index[$key][] = $row;
    }

    $pairedCount = 0;
    $orphanedCount = 0;
    $updateStmt = $conn->prepare('UPDATE transactions SET transaction_group = ? WHERE id IN (?, ?)');

    // -------------------------------------------------------
    // Step 3: For each date+amount+currency bucket, try to pair
    // a Debit (type=2) with a Credit (type=1)
    // -------------------------------------------------------
    $details = [];
    foreach ($index as $key => $group) {
        $debits  = array_values(array_filter($group, fn($r) => in_array((string)$r['type'], ['2', 'debit'])));
        $credits = array_values(array_filter($group, fn($r) => in_array((string)$r['type'], ['1', 'credit'])));
        
        $pairCount = min(count($debits), count($credits));
        
        for ($i = 0; $i < $pairCount; $i++) {
            $uuid = Text::uuid();
            $debitId = $debits[$i]['id'];
            $creditId = $credits[$i]['id'];
            $updateStmt->execute([$uuid, $debitId, $creditId]);
            $pairedCount++;
            $details[] = [
                'status' => 'paired',
                'debit_id'  => $debitId,
                'credit_id' => $creditId,
                'amount'    => $debits[$i]['amount'],
                'currency'  => $debits[$i]['currency'],
                'date'      => $debits[$i]['date'],
                'group_uuid' => substr($uuid, 0, 8) . '...',
            ];
        }
        
        // Mark survivors as orphaned (no match found)
        $leftoverDebits  = array_slice($debits, $pairCount);
        $leftoverCredits = array_slice($credits, $pairCount);
        foreach (array_merge($leftoverDebits, $leftoverCredits) as $orphan) {
            $orphanedCount++;
            $details[] = [
                'status'    => 'orphaned',
                'debit_id'  => $orphan['type'] == '2' ? $orphan['id'] : '-',
                'credit_id' => $orphan['type'] == '1' ? $orphan['id'] : '-',
                'amount'    => $orphan['amount'],
                'currency'  => $orphan['currency'],
                'date'      => $orphan['date'],
                'group_uuid' => 'N/A — ORPHAN',
            ];
        }
    }

    // -------------------------------------------------------
    // Step 4: Report
    // -------------------------------------------------------
    echo "<h2>Results</h2>";
    echo "<p class='success'>✅ <strong>{$pairedCount}</strong> pairs successfully linked with a shared UUID.</p>";
    if ($orphanedCount > 0) {
        echo "<p class='warning'>⚠️ <strong>{$orphanedCount}</strong> orphaned transactions could NOT be paired. ";
        echo "They have been left WITHOUT a transaction_group. Review them and manually delete if needed.</p>";
    } else {
        echo "<p class='success'>✅ No orphaned transactions detected! The ledger should now balance.</p>";
    }

    echo "<h2>Detail Log</h2>";
    echo "<table><tr><th>Status</th><th>Debit ID</th><th>Credit ID</th><th>Date</th><th>Amount</th><th>Currency</th><th>Group UUID</th></tr>";
    foreach ($details as $d) {
        $cls = $d['status'] === 'paired' ? 'success' : 'warning';
        echo "<tr class='{$cls}'>";
        echo "<td><strong>{$d['status']}</strong></td>";
        echo "<td>{$d['debit_id']}</td>";
        echo "<td>{$d['credit_id']}</td>";
        echo "<td>{$d['date']}</td>";
        echo "<td>{$d['amount']}</td>";
        echo "<td>{$d['currency']}</td>";
        echo "<td style='font-size:0.85em;color:#b0bec5'>{$d['group_uuid']}</td>";
        echo "</tr>";
    }
    echo "</table>";

    echo "<hr><p class='info'>Repair script completed. You can now delete this file or restrict access to it.</p>";

} catch (\Exception $e) {
    echo "<p class='error'>❌ Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<pre class='error'>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}

echo '</body></html>';
