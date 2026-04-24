<?php
$cakeDescription = 'Eras App - Login';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    
    <?= $this->Html->meta('icon') ?>
    
    <!-- Premium Design System -->
    <?= $this->Html->css(['premium']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    
    <style>
        .login-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: var(--color-bg-base);
        }
        .login-box {
            width: 100%;
            max-width: 400px;
            padding: 2.5rem;
            background: var(--color-bg-surface);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--color-border);
        }
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-header h2 {
            color: var(--color-primary);
            margin: 0;
            font-size: 1.75rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <h2>ESCerp</h2>
                <p style="color: var(--color-text-muted); font-size: 0.875rem;">
                    <?= ($this->request->getParam('action') === 'register') ? 'Create your account' : 'Sign in to your account' ?>
                </p>
            </div>
            
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
            
            <div style="text-align: center; margin-top: 1.5rem; font-size: 0.875rem;">
                <small>&copy; <?= date('Y') ?> Eras App. All rights reserved.</small>
            </div>
        </div>
    </div>
</body>
</html>
