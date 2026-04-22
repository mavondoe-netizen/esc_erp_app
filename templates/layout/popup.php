<?php
/**
 * Simple layout for popup iframes (removes navbar/sidebar, keeps styling)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Record</title>
    <?= $this->Html->css(['premium']) ?>
    <style>
        body { padding: 20px; background: #fff; min-height: 100vh; }
        main.main { padding: 0 !important; margin: 0 !important; width: 100% !important; max-width: 100% !important; }
        .row { margin: 0; }
        .column { width: 100%; max-width: 100%; flex: 0 0 100%; }
        aside.column { display: none !important; } /* Hide any sidebars */
    </style>
</head>
<body>
    <main class="main">
        <div class="container">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>
</body>
</html>
