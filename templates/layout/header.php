<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PharmaFEFO - Medical Inventory Engine</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased min-h-screen flex flex-col">

<nav class="bg-gray-900 text-white sticky top-0 z-50 shadow-sm">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-14">
            <div class="flex items-center">
                <a class="flex items-center text-lg font-bold tracking-tight text-white" href="index.php?route=dashboard">
                    <i class="fa-solid fa-prescription-bottle-medical mr-2 text-blue-500"></i>PharmaFEFO
                </a>
            </div>
            <div class="flex items-center space-x-4">
                <?php if(isset($_SESSION['user_username'])): ?>
                    <span class="text-xs text-gray-400">Role: <strong class="text-gray-200"><?= htmlspecialchars($_SESSION['user_role']) ?></strong></span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-600 text-white">
                        <i class="fa-solid fa-user mr-1.5"></i> <?= htmlspecialchars($_SESSION['user_username']) ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<div class="flex flex-1 max-w-full mx-auto w-full">
    <aside class="w-64 bg-white border-r border-gray-200 min-h-[calc(100vh-3.5rem)] hidden md:block p-4 flex-shrink-0">
        <nav class="space-y-1">
            <?php $current_route = $_GET['route'] ?? 'dashboard'; ?>
            
            <a class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors <?= $current_route === 'dashboard' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' ?>" href="index.php?route=dashboard">
                <i class="fa-solid fa-chart-pie mr-3 w-5 text-center"></i> Dashboard
            </a>
            
            <a class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors <?= $current_route === 'products' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' ?>" href="index.php?route=products">
                <i class="fa-solid fa-pills mr-3 w-5 text-center"></i> Products
            </a>
            
            <a class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors <?= $current_route === 'lots' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' ?>" href="index.php?route=lots">
                <i class="fa-solid fa-boxes-stacked mr-3 w-5 text-center"></i> Lots
            </a>
            
            <a class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors <?= $current_route === 'stock_entry' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' ?>" href="index.php?route=stock_entry">
                <i class="fa-solid fa-circle-plus mr-3 w-5 text-center text-emerald-600"></i> Stock Entry
            </a>
            
            <a class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors <?= $current_route === 'stock_dispatch' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' ?>" href="index.php?route=stock_dispatch">
                <i class="fa-solid fa-truck-ramp-box mr-3 w-5 text-center text-blue-600"></i> Stock Dispatch
            </a>
            
            <a class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors <?= $current_route === 'loss_report' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' ?>" href="index.php?route=loss_report">
                <i class="fa-solid fa-file-invoice-dollar mr-3 w-5 text-center text-red-600"></i> Reports
            </a>
            
            <a class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors <?= $current_route === 'users' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' ?>" href="index.php?route=users">
                <i class="fa-solid fa-users mr-3 w-5 text-center"></i> Users
            </a>
            
            <div class="pt-4 mt-4 border-t border-gray-200">
                <a class="flex items-center px-3 py-2.5 text-sm font-medium text-red-600 rounded-lg hover:bg-red-50 transition-colors" href="index.php?route=logout">
                    <i class="fa-solid fa-right-from-bracket mr-3 w-5 text-center"></i> Logout
                </a>
            </div>
        </nav>
    </aside>
    
    <main class="flex-1 min-w-0 p-6 md:p-8 overflow-y-auto">