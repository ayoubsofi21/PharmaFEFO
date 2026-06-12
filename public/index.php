<?php

declare(strict_types=1);
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

session_start();

// Change this:
require_once __DIR__ . '/../config/database.php';

// The autoloader won't find Config\Database because it only handles App\
// But since you require_once it manually, that's fine — just make sure
// the file path is correct:
// var_dump(file_exists(__DIR__ . '/../config/database.php')); // add this to test
require_once __DIR__ . '/../src/Middleware/AuthMiddleware.php';


spl_autoload_register(function ($class) {
    // Handle App\ namespace
    if (strncmp('App\\', $class, 4) === 0) {
        $relative = substr($class, 4);
        $file = __DIR__ . '/../src/' . str_replace('\\', '/', $relative) . '.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }

    // Handle Config\ namespace  
    if (strncmp('Config\\', $class, 7) === 0) {
        $relative = substr($class, 7);
        $file = __DIR__ . '/../config/' . str_replace('\\', '/', $relative) . '.php';
        if (file_exists($file)) {
            require_once $file;
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

$db = Database::getConnection();

$userRepository = new UserRepository($db);
$productRepository = new ProductRepository($db);
$lotRepository = new LotRepository($db);

$route = $_GET['route'] ?? 'dashboard';
// TEMPORARY DEBUG - remove after fixing
// echo "<pre>";
// echo "Base dir: " . realpath(__DIR__ . '/../src/') . "\n";
// echo "AuthController exists: " . (file_exists(__DIR__ . '/../src/Controller/AuthController.php') ? 'YES' : 'NO') . "\n";
// echo "Database.php exists: " . (file_exists(__DIR__ . '/../config/database.php') ? 'YES' : 'NO') . "\n";
// echo "</pre>";
switch ($route) {
    case 'login':
        (new AuthController($userRepository))->login();
        break;

    case 'logout':
        (new AuthController($userRepository))->logout();
        break;

    case 'dashboard':
        (new DashboardController($productRepository, $lotRepository))->index();
        break;
    // Add to your switch statement:
    case 'stock_entry':
        (new StockController($productRepository, $lotRepository))->entry();
        break;

    case 'stock_dispatch':
        (new StockController($productRepository, $lotRepository))->dispatch();
        break;

    case 'loss_report':
        (new DashboardController($productRepository, $lotRepository))->lossReport();
        break;
    case 'register':
        (new AuthController($userRepository))->register();
        break;  
    default:
        http_response_code(404);
        echo "404";
}