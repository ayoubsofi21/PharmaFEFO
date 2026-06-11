<?php
declare(strict_types=1);

// Load the database configuration file
require_once __DIR__ . '/../config/database.php';

// PSR-4 Style Manual Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../src/';
    $len = strlen($prefix);
    
    if (strncmp($prefix, $class, $len) === 0) {
        $relative_class = substr($class, $len);
        $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

use Config\Database;
use App\Repository\UserRepository;
use App\Repository\ProductRepository;
use App\Repository\LotRepository;
use App\Controller\AuthController;
use App\Controller\DashboardController;
use App\Controller\StockController;

// Grab our plain static PDO connection
$db = Database::getConnection();

// Instantiate Repositories
$userRepository = new UserRepository($db);
$productRepository = new ProductRepository($db);
$lotRepository = new LotRepository($db);

// Route Resolution
$route = $_GET['route'] ?? 'dashboard';

switch ($route) {
    case 'login':
        $controller = new AuthController($userRepository);
        $controller->login();
        break;

    case 'logout':
        $controller = new AuthController($userRepository);
        $controller->logout();
        break;

    case 'dashboard':
        $controller = new DashboardController($productRepository, $lotRepository);
        $controller->index();
        break;

    case 'stock_entry':
        $controller = new StockController($productRepository, $lotRepository);
        $controller->entry();
        break;

    case 'stock_dispatch':
        $controller = new StockController($productRepository, $lotRepository);
        $controller->dispatch();
        break;

    case 'loss_report':
        $controller = new DashboardController($productRepository, $lotRepository);
        $controller->lossReport();
        break;

    default:
        header("HTTP/1.0 404 Not Found");
        echo "404 - Page Not Found";
        break;
}