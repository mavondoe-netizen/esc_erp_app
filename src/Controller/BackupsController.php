<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Backups Controller
 *
 * Manages MySQL database backups via mysqldump.
 */
class BackupsController extends AppController
{
    /** @var string Backup storage directory */
    private string $backupDir;

    public function initialize(): void
    {
        parent::initialize();
        $this->backupDir = ROOT . DS . 'backups' . DS;
        if (!is_dir($this->backupDir)) {
            mkdir($this->backupDir, 0755, true);
        }
    }

    /**
     * List existing backups.
     *
     * @return void
     */
    public function index()
    {
        $files = glob($this->backupDir . '*.sql') ?: [];
        $backups = [];
        foreach ($files as $f) {
            $backups[] = [
                'name'     => basename($f),
                'size'     => round(filesize($f) / (1024 * 1024), 2),
                'created'  => date('Y-m-d H:i:s', filemtime($f)),
                'modified' => filemtime($f),
            ];
        }
        usort($backups, fn($a, $b) => $b['modified'] <=> $a['modified']);
        $this->set(compact('backups'));
    }

    /**
     * Create a new database backup.
     *
     * @return \Cake\Http\Response|null
     */
    public function create()
    {
        $this->request->allowMethod(['post']);

        $config   = \Cake\Datasource\ConnectionManager::getConfig('default');
        $dbHost   = $config['host'] ?? 'localhost';
        $dbUser   = $config['username'] ?? 'root';
        $dbPass   = $config['password'] ?? '';
        $dbName   = $config['database'] ?? '';
        $filename = 'backup_' . date('Y-m-d_His') . '.sql';
        $filepath = $this->backupDir . $filename;

        // Path to windows XAMPP mysqldump
        $mysqldump = 'c:\xampp\mysql\bin\mysqldump.exe';
        if (!file_exists($mysqldump)) {
            $mysqldump = 'mysqldump'; // Fallback to PATH if not XAMPP array
        }

        $cmd = sprintf(
            '%s --host=%s --user=%s --password=%s %s > %s 2>&1',
            escapeshellarg($mysqldump),
            escapeshellarg($dbHost),
            escapeshellarg($dbUser),
            escapeshellarg($dbPass),
            escapeshellarg($dbName),
            escapeshellarg($filepath)
        );

        exec($cmd, $output, $returnCode);

        if ($returnCode === 0 && file_exists($filepath)) {
            $this->Flash->success("Backup created: $filename");
        } else {
            $this->Flash->error('Backup failed. Check server permissions and mysqldump availability.');
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Download a backup file.
     *
     * @param string $filename Filename to download.
     * @return \Cake\Http\Response|null
     */
    public function download(string $filename)
    {
        $filepath = $this->backupDir . basename($filename);
        if (!file_exists($filepath)) {
            throw new \Cake\Http\Exception\NotFoundException('Backup file not found.');
        }

        return $this->response
            ->withFile($filepath, ['download' => true, 'name' => basename($filename)]);
    }

    /**
     * Delete a backup file.
     *
     * @param string $filename Filename to delete.
     * @return \Cake\Http\Response|null
     */
    public function delete(string $filename)
    {
        $this->request->allowMethod(['post', 'delete']);
        $filepath = $this->backupDir . basename($filename);
        if (file_exists($filepath)) {
            unlink($filepath);
            $this->Flash->success('Backup deleted.');
        } else {
            $this->Flash->error('Backup file not found.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
