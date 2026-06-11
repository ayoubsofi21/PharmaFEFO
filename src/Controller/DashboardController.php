<?php
declare(strict_types=1);

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Repository\LotRepository;

class DashboardController {
    private ProductRepository $productRepository;
    private LotRepository $lotRepository;

    public function __construct(ProductRepository $productRepository, LotRepository $lotRepository) {
        $this->productRepository = $productRepository;
        $this->lotRepository = $lotRepository;
    }

    public function index(): void {
        requireAuth();

        $stats = [
            'total_products' => $this->productRepository->countAll(),
            'total_lots'     => $this->lotRepository->countActiveLots(),
            'expiring_90'    => $this->lotRepository->countExpiringInDays(90),
            'expired'        => $this->lotRepository->countExpired()
        ];

        $criticalLots = $this->lotRepository->findCriticalLots();
        $warningLots  = $this->lotRepository->findWarningLots();
        $productRepo  = $this->productRepository; // passed down contextually to pull relative entities

        require __DIR__ . '/../../templates/dashboard/index.php';
    }

    public function lossReport(): void {
        requireAuth(['Admin', 'Pharmacist']);

        $expiredLots = $this->lotRepository->findExpiredLots();
        $productRepository = $this->productRepository;

        $monthlyLoss = 0.0;
        $expiredCount = count($expiredLots);

        $reportData = [];
        foreach ($expiredLots as $lot) {
            $product = $productRepository->findById($lot->getProductId());
            $pName = $product ? $product->getName() : 'Unknown Product';
            $uPrice = $product ? $product->getUnitPrice() : 0.00;
            $lostValue = $lot->getQuantity() * $uPrice;
            $monthlyLoss += $lostValue;

            $reportData[] = [
                'product_name' => $pName,
                'lot_number'   => $lot->getLotNumber(),
                'expiry_date'  => $lot->getExpirationDate(),
                'quantity'     => $lot->getQuantity(),
                'lost_value'   => $lostValue
            ];
        }

        require __DIR__ . '/../../templates/report/loss_report.php';
    }
}