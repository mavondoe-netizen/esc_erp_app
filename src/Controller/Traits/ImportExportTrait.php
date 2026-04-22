<?php
declare(strict_types=1);

namespace App\Controller\Traits;

use Cake\Utility\Inflector;
use Cake\View\JsonView;

/**
 * ImportExportTrait
 * 
 * Provides global CSV import and template download actions for controllers.
 */
trait ImportExportTrait
{
    /**
     * GET /[controller]/download-template
     * Generates a CSV template based on the table schema.
     */
    public function downloadTemplate()
    {
        $table = $this->fetchTable();
        $columns = $table->getSchema()->columns();

        // Columns to exclude from the template
        $exclude = [
            'id', 'company_id', 'created', 'modified', 
            'created_at', 'updated_at', 'deleted', 'deleted_at',
            'user_id', 'lft', 'rght', 'level'
        ];

        $headers = array_filter($columns, function($col) use ($exclude) {
            return !in_array($col, $exclude);
        });

        // 1. Scrape options from the add.php template if it exists
        $templateOptions = $this->_getOptionsFromTemplate();

        // 2. Generate intelligent sample data based on column names/types/template options
        $sampleData = [];
        foreach ($headers as $col) {
            $colObj = $table->getSchema()->getColumn($col);
            $type = $colObj['type'] ?? 'string';
            
            // Priority 1: Use scraped options from template
            if (!empty($templateOptions[$col])) {
                $sample = implode(' | ', $templateOptions[$col]);
            } else {
                // Priority 2: Standard intelligent defaults
                $sample = 'Sample';
                $lCol = strtolower($col);

                if (str_contains($lCol, 'name')) $sample = 'Sample Name';
                elseif (str_contains($lCol, 'email')) $sample = 'sample@example.com';
                elseif (str_contains($lCol, 'phone')) $sample = '0123456789';
                elseif (str_contains($lCol, 'amount') || str_contains($lCol, 'value') || str_contains($lCol, 'price')) $sample = '10.00';
                elseif (str_contains($lCol, 'date')) $sample = date('Y-m-d');
                elseif (str_contains($lCol, 'description') || str_contains($lCol, 'notes')) $sample = 'Provide a brief description here.';
                elseif (str_contains($lCol, 'type') || str_contains($lCol, 'category')) $sample = 'Standard';
                elseif (str_contains($lCol, 'active') || str_contains($lCol, 'status')) $sample = 'Active';
                elseif (in_array($type, ['integer', 'biginteger'])) $sample = '123';
                elseif (in_array($type, ['decimal', 'float'])) $sample = '0.00';
                elseif ($type === 'boolean') $sample = '1';
                elseif ($type === 'date') $sample = date('Y-m-d');
                elseif ($type === 'datetime') $sample = date('Y-m-d H:i:s');
            }
            
            $sampleData[] = $sample;
        }

        $this->response = $this->response->withType('csv')
            ->withDownload(Inflector::underscore($this->getName()) . '_template.csv');

        $stream = fopen('php://temp', 'w+');
        fputcsv($stream, $headers); // Row 1: Headers
        fputcsv($stream, $sampleData); // Row 2: Sample Data
        rewind($stream);
        $content = stream_get_contents($stream);
        fclose($stream);

        return $this->response->withStringBody($content);
    }

    /**
     * POST /[controller]/import
     * Handles AJAX CSV import of records.
     */
    public function import()
    {
        $this->request->allowMethod(['post']);
        $this->viewBuilder()->setClassName('Json');
        
        $file = $this->request->getUploadedFile('import_file');
        if (!$file || $file->getError() !== UPLOAD_ERR_OK) {
            return $this->renderJson(false, 'Invalid file upload.');
        }

        $companyId = $this->request->getAttribute('company_id');
        
        $table = $this->fetchTable();
        $stream = $file->getStream();
        $stream->rewind();
        
        $handle = fopen($stream->getMetadata('uri'), 'r');
        $headers = fgetcsv($handle);
        
        if (!$headers) {
            fclose($handle);
            return $this->renderJson(false, 'Empty CSV file.');
        }

        $imported = 0;
        $errors = [];
        $rowNum = 1;

        while (($row = fgetcsv($handle)) !== false) {
            $rowNum++;
            if (empty(array_filter($row))) continue;

            $data = array_combine($headers, $row);
            if ($companyId) {
                $data['company_id'] = $companyId;
            }

            $entity = $table->newEntity($data);
            if ($table->save($entity)) {
                $imported++;
            } else {
                $errorMsg = "Row $rowNum: ";
                foreach ($entity->getErrors() as $field => $errs) {
                    $errorMsg .= "$field (" . implode(', ', $errs) . ") ";
                }
                $errors[] = $errorMsg;
            }
        }
        fclose($handle);

        return $this->renderJson(true, "Successfully imported $imported records.", $errors);
    }

    /**
     * Helper to render JSON responses for AJAX calls.
     */
    private function renderJson(bool $success, string $message, array $errors = [])
    {
        $this->set([
            'success' => $success,
            'message' => $message,
            'errors'  => $errors,
        ]);
        $this->viewBuilder()->setOption('serialize', ['success', 'message', 'errors']);
        return $this->render();
    }

    /**
     * Attempts to scrape hardcoded options from the add.php template.
     */
    private function _getOptionsFromTemplate(): array
    {
        $options = [];
        $controllerName = $this->getName();
        // Construct path to the add.php template
        $templatePath = ROOT . DS . 'templates' . DS . $controllerName . DS . 'add.php';

        if (file_exists($templatePath)) {
            $content = file_get_contents($templatePath);
            
            // Regex to match Form->control('field', ['options' => [...]])
            // Matches field name in group 1 and the contents of the options array in group 2
            $pattern = "/control\(\s*['\"](.*?)['\"]\s*,[^\]]*?'options'\s*=>\s*\[(.*?)\]/s";
            
            if (preg_match_all($pattern, $content, $matches)) {
                foreach ($matches[1] as $idx => $fieldName) {
                    $inner = $matches[2][$idx];
                    // Extract unique labels/values from the scraped array string
                    $itemPattern = "/['\"](.*?)['\"]/";
                    if (preg_match_all($itemPattern, $inner, $itemMatches)) {
                        $options[$fieldName] = array_unique($itemMatches[1]);
                    }
                }
            }
        }
        return $options;
    }
}
