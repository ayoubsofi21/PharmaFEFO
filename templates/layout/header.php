<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PharmaFEFO - Medical Inventory Engine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar-brand { font-weight: 700; color: #0d6efd; }
        .sidebar { background: #ffffff; min-height: calc(100vh - 56px); box-shadow: 2px 0 5px rgba(0,0,0,0.05); }
        .sidebar .nav-link { color: #495057; font-weight: 500; padding: 0.8rem 1rem; border-radius: 0.375rem; margin-bottom: 0.2rem; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: #e9ecef; color: #0d6efd; }
        .card { border: none; border-radius: 0.75rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02); }
        .card-counter { border-left: 4px solid #0d6efd; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand text-white" href="/index.php?route=dashboard"><i class="fa-solid fa-prescription-bottle-medical me-2 text-primary"></i>PharmaFEFO</a>
        <div class="d-flex align-items-center text-white">
            <?php if(isset($_SESSION['user_username'])): ?>
                <span class="me-3 small text-muted">Role: <strong class="text-light"><?= htmlspecialchars($_SESSION['user_role']) ?></strong></span>
                <span class="badge bg-primary text-white p-2"><i class="fa-solid fa-user me-1"></i> <?= htmlspecialchars($_SESSION['user_username']) ?></span>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse p-3">
            <div class="position-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?= ($_GET['route'] ?? '') === 'dashboard' ? 'active' : '' ?>" href="/index.php?route=dashboard">
                            <i class="fa-solid fa-chart-pie me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa-solid fa-pills me-2"></i> Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa-solid fa-boxes-stacked me-2"></i> Lots</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($_GET['route'] ?? '') === 'stock_entry' ? 'active' : '' ?>" href="/index.php?route=stock_entry">
                            <i class="fa-solid fa-circle-plus me-2 text-success"></i> Stock Entry
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($_GET['route'] ?? '') === 'stock_dispatch' ? 'active' : '' ?>" href="/index.php?route=stock_dispatch">
                            <i class="fa-solid fa-truck-ramp-box me-2 text-primary"></i> Stock Dispatch
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($_GET['route'] ?? '') === 'loss_report' ? 'active' : '' ?>" href="/index.php?route=loss_report">
                            <i class="fa-solid fa-file-invoice-dollar me-2 text-danger"></i> Reports
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa-solid fa-users me-2"></i> Users</a>
                    </li>
                    <li class="nav-item mt-4">
                        <hr>
                        <a class="nav-link text-danger" href="/index.php?route=logout">
                            <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-4">