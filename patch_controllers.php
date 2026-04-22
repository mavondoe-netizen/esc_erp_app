<?php
/**
 * Script to automatically patch all Controllers' add() methods to support popup quick add returns.
 */

$dir = __DIR__ . '/src/Controller';
$files = glob($dir . '/*Controller.php');

$totalPatched = 0;

foreach ($files as $file) {
    if (!is_file($file)) continue;
    $content = file_get_contents($file);
    $original = $content;

    // We must find the standard CakePHP bake block:
    // if ($this->{Table}->save(${entity})) {
    //     $this->Flash->success( ... )
    //     return $this->redirect(['action' => 'index']);
    // }
    
    // Use regex to locate: if ($this->[Model]->save($[var])) { \s+ $this->Flash->success(
    $pattern = '/if\s*\(\$this->([A-Za-z0-9_]+)->save\(\$([a-zA-Z0-9_]+)\)\)\s*\{\s*\$this->Flash->success\(/sP';
    
    $content = preg_replace_callback($pattern, function($matches) {
        $table = $matches[1];
        $entity = $matches[2];
        
        return "if (\$this->$table->save(\$$entity)) {
                if (\$this->request->getQuery('popup')) {
                    \$this->set('popupResult', [
                        'id' => \${$entity}->id,
                        'name' => isset(\${$entity}->name) ? \${$entity}->name : (isset(\${$entity}->title) ? \${$entity}->title : (isset(\${$entity}->reference) ? \${$entity}->reference : 'New Item'))
                    ]);
                    \$this->viewBuilder()->disableAutoLayout();
                    return \$this->render('/Element/popup_success');
                }
                \$this->Flash->success(";
    }, $content);
    
    // Next, at the bottom of the add function, we must append:
    // if ($this->request->getQuery('popup')) { $this->viewBuilder()->setLayout('popup'); }
    // It's usually right before the end of the method:
    // $this->set(compact('x', 'y'));
    // } (end of add method)
    // For safety, let's inject it into the generic `beforeRender` method? No, we will append it dynamically by looking for `public function add()` and its internal `set(compact(`.
    
    // A simpler replacement:
    $pattern2 = '/(\$this->set\(compact\([^)]+\)\);)\s*\}/sP';
    
    // We only want to inject this inside `public function add()` or `public function edit()`.
    // It's safer to just let the Layout itself auto-switch! Actually, `AppController.php` is perfect for this.
    // Instead of patching set(compact) everywhere, we can just hook beforeRender globally!
    
    if ($content !== $original) {
        file_put_contents($file, $content);
        $totalPatched++;
        echo "Patched: " . basename($file) . "\n";
    }
}

echo "\nTotal Controller methods patched: $totalPatched\n";

// Now automatically modify AppController to handle the Layout change instead of editing every controller
$appCtrlFile = __DIR__ . '/src/Controller/AppController.php';
$appCtrlPattern = '/public function beforeRender\(.*\)\s*\{/';
$appContent = file_get_contents($appCtrlFile);

if (strpos($appContent, "setLayout('popup')") === false) {
    preg_match($appCtrlPattern, $appContent, $matches);
    if (!empty($matches)) {
        $inject = $matches[0] . "\n        if (\$this->request->getQuery('popup')) {\n            \$this->viewBuilder()->setLayout('popup');\n        }\n";
        $appContent = str_replace($matches[0], $inject, $appContent);
        file_put_contents($appCtrlFile, $appContent);
        echo "Patched: AppController.php to apply 'popup' layout globally.\n";
    }
}

