<?php
declare(strict_types=1);

namespace App\Service;

use App\Repository\LotRepository;
use Exception;

class FefoDispatchService {
    private LotRepository $lotRepository;

    public function __construct(LotRepository $lotRepository) {
        $this->lotRepository = $lotRepository;
    }

    public function dispatchProduct(int $productId, int $requestedQuantity): void {
        if ($requestedQuantity <= 0) {
            throw new Exception("Requested quantity must be greater than zero.");
        }

        // 1. Search all available lots sorted by nearest expiration date ascending
        $availableLots = $this->lotRepository->findAvailableLotsForProduct($productId);
        
        $totalAvailable = array_reduce($availableLots, fn($sum, $lot) => $sum + $lot->getQuantity(), 0);
        if ($totalAvailable < $requestedQuantity) {
            throw new Exception("Insufficient active stock. Only {$totalAvailable} units available.");
        }

        $remainingToDispatch = $requestedQuantity;

        foreach ($availableLots as $lot) {
            if ($remainingToDispatch <= 0) break;

            $lotQty = $lot->getQuantity();
            if ($lotQty >= $remainingToDispatch) {
                // This lot can fulfill the remaining amount completely
                $lot->setQuantity($lotQty - $remainingToDispatch);
                $remainingToDispatch = 0;
            } else {
                // Empty out this lot completely and move to the next oldest lot
                $remainingToDispatch -= $lotQty;
                $lot->setQuantity(0);
            }

            // Save state immediately
            $this->lotRepository->update($lot);
        }
    }
}