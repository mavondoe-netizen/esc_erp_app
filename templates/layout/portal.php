<?php
/**
 * @var \App\View\AppView $this
 */
$identity = $this->request->getAttribute('identity');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ESC Employee Portal — <?= $this->fetch('title') ?></title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css(['premium']) ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
    <?= $this->Html->meta('csrfToken', $this->request->getAttribute('csrfToken')) ?>
    <?= $this->fetch('css') ?>
    <style>
        :root {
            --portal-primary: #2563eb;
            --portal-accent: #0ea5e9;
            --portal-bg: #f0f4f8;
            --portal-sidebar: #1e293b;
            --portal-sidebar-text: #cbd5e1;
            --portal-sidebar-active: #2563eb;
            --portal-card: #ffffff;
            --portal-text: #1e293b;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', 'Segoe UI', sans-serif; background: var(--portal-bg); color: var(--portal-text); min-height: 100vh; display: flex; flex-direction: column; }

        /* Top bar */
        .portal-topbar {
            background: linear-gradient(135deg, var(--portal-primary), var(--portal-accent));
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            height: 58px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .portal-topbar .brand {
            font-size: 1.2rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }
        .portal-topbar .brand span.badge-portal {
            background: rgba(255,255,255,0.2);
            font-size: 0.65rem;
            padding: 2px 8px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }
        .portal-topbar .nav-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .portal-topbar .user-badge {
            background: rgba(255,255,255,0.15);
            border-radius: 50px;
            padding: 5px 14px;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .portal-topbar a { color: white; text-decoration: none; }
        .portal-topbar .logout-btn {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.3);
            padding: 5px 14px;
            border-radius: 6px;
            font-size: 0.85rem;
            cursor: pointer;
            transition: background 0.2s;
        }
        .portal-topbar .logout-btn:hover { background: rgba(255,255,255,0.3); }

        /* Body Layout */
        .portal-body { display: flex; flex: 1; min-height: calc(100vh - 58px); }

        /* Sidebar */
        .portal-sidebar {
            width: 230px;
            background: var(--portal-sidebar);
            padding: 1.5rem 0;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
        }
        .portal-sidebar .section-label {
            font-size: 0.68rem;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #64748b;
            font-weight: 700;
            padding: 1rem 1.25rem 0.4rem;
        }
        .portal-sidebar a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.7rem 1.25rem;
            color: var(--portal-sidebar-text);
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 500;
            border-radius: 0 30px 30px 0;
            margin-right: 0.75rem;
            transition: all 0.2s;
        }
        .portal-sidebar a:hover, .portal-sidebar a.active {
            background: var(--portal-sidebar-active);
            color: white;
        }
        .portal-sidebar a i { width: 18px; text-align: center; font-size: 0.9rem; }

        /* Main content area */
        .portal-main {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
        }
        .portal-main h2 { font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem; color: var(--portal-text); }

        /* Cards */
        .portal-card {
            background: var(--portal-card);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 1px 4px rgba(0,0,0,0.07);
            margin-bottom: 1.5rem;
        }
        .portal-card h3 { font-size: 1rem; font-weight: 700; margin-bottom: 1rem; color: #475569; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; }

        /* Stat cards */
        .stat-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
        .stat-card {
            background: var(--portal-card);
            border-radius: 12px;
            padding: 1.25rem 1.5rem;
            box-shadow: 0 1px 4px rgba(0,0,0,0.07);
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .stat-card .icon {
            width: 46px; height: 46px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }
        .stat-card .icon.blue { background: #dbeafe; color: #2563eb; }
        .stat-card .icon.green { background: #dcfce7; color: #16a34a; }
        .stat-card .icon.amber { background: #fef9c3; color: #ca8a04; }
        .stat-card .icon.red { background: #fee2e2; color: #dc2626; }
        .stat-card .label { font-size: 0.78rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .stat-card .value { font-size: 1.5rem; font-weight: 700; }

        /* Table */
        .portal-table { width: 100%; border-collapse: collapse; }
        .portal-table th { background: #f8fafc; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; padding: 10px 12px; text-align: left; border-bottom: 2px solid #e2e8f0; }
        .portal-table td { padding: 10px 12px; border-bottom: 1px solid #f1f5f9; font-size: 0.9rem; }
        .portal-table tr:hover td { background: #f8fafc; }

        /* Badges */
        .badge { display: inline-block; padding: 2px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
        .badge-pending { background: #fef9c3; color: #92400e; }
        .badge-approved { background: #dcfce7; color: #166534; }
        .badge-rejected { background: #fee2e2; color: #991b1b; }

        /* Flash messages */
        .flash-message { padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1rem; font-size: 0.9rem; }
        .flash-success { background: #dcfce7; color: #166534; border-left: 4px solid #16a34a; }
        .flash-error { background: #fee2e2; color: #991b1b; border-left: 4px solid #dc2626; }

        /* Form */
        .portal-form .form-group { margin-bottom: 1rem; }
        .portal-form label { display: block; font-size: 0.85rem; font-weight: 600; color: #475569; margin-bottom: 4px; }
        .portal-form input, .portal-form select, .portal-form textarea {
            width: 100%; padding: 0.6rem 0.9rem; border: 1px solid #e2e8f0; border-radius: 8px;
            font-size: 0.9rem; color: var(--portal-text); background: #f8fafc;
            transition: border-color 0.2s;
        }
        .portal-form input:focus, .portal-form select:focus { outline: none; border-color: var(--portal-primary); background: white; }
        .btn-portal { background: var(--portal-primary); color: white; border: none; padding: 0.65rem 1.5rem; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 0.9rem; transition: background 0.2s; }
        .btn-portal:hover { background: #1d4ed8; }
        .btn-outline { background: transparent; color: var(--portal-primary); border: 1.5px solid var(--portal-primary); padding: 0.65rem 1.5rem; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 0.9rem; transition: all 0.2s; }
        .btn-outline:hover { background: var(--portal-primary); color: white; }

        @media (max-width: 768px) {
            .portal-sidebar { width: 200px; }
            .portal-main { padding: 1.25rem; }
        }
    </style>
</head>
<body>
    <!-- Top Bar -->
    <header class="portal-topbar">
        <div class="brand">
            <i class="fa fa-id-card-clip"></i>
            <span>ESC Employee Portal</span>
            <span class="badge-portal">Self Service</span>
        </div>
        <div class="nav-right">
            <div class="user-badge">
                <i class="fa fa-circle-user"></i>
                <?= h($identity ? $identity->email : 'Employee') ?>
            </div>
            <a href="/users/logout" class="logout-btn"><i class="fa fa-right-from-bracket"></i> Logout</a>
        </div>
    </header>

    <div class="portal-body">
        <!-- Sidebar -->
        <nav class="portal-sidebar">
            <span class="section-label">My Portal</span>
            <a href="/portal/dashboard" <?= $this->request->getParam('action') === 'dashboard' ? 'class="active"' : '' ?>>
                <i class="fa fa-gauge-high"></i> Dashboard
            </a>
            <a href="/portal/payslips" <?= $this->request->getParam('action') === 'payslips' ? 'class="active"' : '' ?>>
                <i class="fa fa-file-invoice-dollar"></i> My Payslips
            </a>

            <span class="section-label">Leave</span>
            <a href="/portal/leave-balances" <?= $this->request->getParam('action') === 'leaveBalances' ? 'class="active"' : '' ?>>
                <i class="fa fa-calendar-check"></i> Leave Balances
            </a>
            <a href="/portal/leave-apply" <?= $this->request->getParam('action') === 'leaveApply' ? 'class="active"' : '' ?>>
                <i class="fa fa-calendar-plus"></i> Apply for Leave
            </a>
            <a href="/portal/leave-history" <?= $this->request->getParam('action') === 'leaveHistory' ? 'class="active"' : '' ?>>
                <i class="fa fa-clock-rotate-left"></i> Leave History
            </a>

            <span class="section-label">Account</span>
            <a href="/portal/profile" <?= $this->request->getParam('action') === 'profile' ? 'class="active"' : '' ?>>
                <i class="fa fa-user"></i> My Profile
            </a>
            <a href="/users/logout">
                <i class="fa fa-right-from-bracket"></i> Sign Out
            </a>
        </nav>

        <!-- Main Content -->
        <main class="portal-main">
            <?php foreach (['error', 'success', 'warning', 'info'] as $type): ?>
                <?php $msg = $this->Flash->render($type); ?>
                <?php if ($msg): ?>
                    <div class="flash-message flash-<?= $type ?>"><?= $msg ?></div>
                <?php endif; ?>
            <?php endforeach; ?>
            <?= $this->fetch('content') ?>
        </main>
    </div>

    <?= $this->fetch('script') ?>
</body>
</html>
