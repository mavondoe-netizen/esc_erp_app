<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\ConnectionManager;
use Cake\Http\Exception\NotFoundException;
use Cake\Event\EventInterface;

/**
 * Backups Controller
 *
 * Handles database backup generation, listing, downloading, and deletion.
 */
class BackupsController extends AppController
{
    private $backupPath;

    public function initialize(): void
    {
        parent::initialize();
        $this->backupPath = TMP . 'backups' . DS;
    }

    /**
     * Index method: Lists all available SQL backups
     */
    public function index()
    {
        if (!is_dir($this->backupPath)) {
            mkdir($this->backupPath, 0755, true);
        }

        $files = array_filter(scandir($this->backupPath), function($f) {
            return $f !== '.' && $f !== '..' && str_ends_with(strtolower($f), '.sql');
        });

        $backups = [];
        foreach ($files as $file) {
            $filePath = $this->backupPath . $file;
            $backups[] = [
                'name' => $file,
                'size' => number_format(filesize($filePath) / 1024 / 1024, 2) . ' MB',
                'created' => date("Y-m-d H:i:s", filemtime($filePath))
            ];
        }

        // Sort by date descending
        usort($backups, function($a, $b) {
            return $b['created'] <=> $a['created'];
        });

        $this->set(compact('backups'));
    }

    /**
     * Create method: Triggers a mysqldump process
     */
    public function create()
    {
        $conn = ConnectionManager::get('default');
        $conf = $conn->config();

        $database = $conf['database'];
        $user = $conf['username'];
        $pass = $conf['password'] ?? '';
        $host = $conf['host'];

        $filename = 'backup_' . $database . '_' . date('Y-m-d_His') . '.sql';
        $outputPath = $this->backupPath . $filename;

        // Path to mysqldump in XAMPP
        $mysqldumpPath = 'C:\\xampp\\mysql\\bin\\mysqldump.exe';
        
        // Build the command
        // Note: Password must not have a space after -p
        $passArg = $pass !== '' ? '-p' . escapeshellarg($pass) : '';
        
        $command = sprintf(
            '"%s" -h %s -u %s %s %s > "%s" 2>&1',
            $mysqldumpPath,
            $host,
            $user,
            $passArg,
            escapeshellarg($database),
            $outputPath
        );

        exec($command, $output, $returnVar);

        if ($returnVar === 0) {
            $this->Flash->success(__("Backup '{0}' created successfully.", $filename));
        } else {
            // Log output for debugging
            $errorMsg = implode(" ", $output);
            $this->Flash->error(__("Error creating backup. Ensure mysqldump is accessible. {0}", $errorMsg));
            // Cleanup failed file if it exists
            if (file_exists($outputPath)) unlink($outputPath);
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Download method: Securely serves the SQL file
     */
    public function download($filename)
    {
        // Security check: ensure no directory traversal
        $filename = basename($filename);
        $filePath = $this->backupPath . $filename;

        if (!file_exists($filePath)) {
            throw new NotFoundException(__('Backup file not found.'));
        }

        return $this->response->withFile($filePath, [
            'download' => true,
            'name' => $filename
        ]);
    }

    /**
     * Delete method: Removes a backup file
     */
    public function delete($filename)
    {
        $this->request->allowMethod(['post', 'delete']);
        
        $filename = basename($filename);
        $filePath = $this->backupPath . $filename;

        if (file_exists($filePath)) {
            unlink($filePath);
            $this->Flash->success(__("Backup '{0}' deleted.", $filename));
        } else {
            $this->Flash->error(__("Backup '{0}' not found.", $filename));
        }

        return $this->redirect(['action' => 'index']);
    }
}
