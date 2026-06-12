<?php
declare(strict_types=1);

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\LotRepository;
use App\Entity\Lot;
use App\Service\FefoDispatchService;
use Exception;

class StockController {
    private ProductRepository $productRepository;
    private LotRepository $lotRepository;

    public function __construct(ProductRepository $productRepository, LotRepository $lotRepository) {
        $this->productRepository = $productRepository;
        $this->lotRepository = $lotRepository;
    }

    public function entry(): void {
        requireAuth(['ADMINISTRATEUR', 'PREPARATEUR']);
        
        $products = $this->productRepository->findAll();
        $errors = [];
        $success = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = (int)($_POST['product_id'] ?? 0);
            $lotNumber = trim($_POST['lot_number'] ?? '');
            $quantity = (int)($_POST['quantity'] ?? 0);
            $expiryDate = trim($_POST['expiration_date'] ?? '');

            if ($productId <= 0) $errors['product_id'] = "Please select a valid pharmaceutical product.";
            if (empty($lotNumber)) $errors['lot_number'] = "The batch lot identification identifier is mandatory.";
            if ($quantity <= 0) $errors['quantity'] = "Quantity received must be at least 1 single item.";
            
            if (empty($expiryDate)) {
                $errors['expiration_date'] = "Expiration tracking threshold date target must be set.";
            } else {
                $today = new \DateTime('today');
                $selectedDate = new \DateTime($expiryDate);
                if ($selectedDate <= $today) {
                    $errors['expiration_date'] = "The expiration date target parameter must specify a future date limit.";
                }
            }

            if (empty($errors)) {
                $lot = new Lot(null, $productId, $lotNumber, $quantity, $expiryDate);
                if ($this->lotRepository->create($lot)) {
                    $success = true;
                } else {
                    $errors['global'] = "Critical anomaly blocking persistence save operation loops.";
                }
            }
        }

        require __DIR__ . '/../../templates/stock/entry.php';
    }

    public function dispatch(): void {
        requireAuth(['ADMINISTRATEUR', 'PHARMACIEN', 'PREPARATEUR']);

        $products = $this->productRepository->findAll();
        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = (int)($_POST['product_id'] ?? 0);
            $quantity = (int)($_POST['quantity'] ?? 0);

            if ($productId <= 0 || $quantity <= 0) {
                $error = "Please provide valid structural definitions inside execution inputs.";
            } else {
                try {
                    $fefoService = new FefoDispatchService($this->lotRepository);
                    $fefoService->dispatchProduct($productId, $quantity);
                    $success = "FEFO stock reduction allocation dispatched successfully.";
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }
            }
        }

        require __DIR__ . '/../../templates/stock/dispatch.php';
    }
}