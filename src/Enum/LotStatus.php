<?php
declare(strict_types=1);

namespace App\Enum;

use DateTime;

enum LotStatus: string {
    case GREEN = 'GREEN';
    case ORANGE = 'ORANGE';
    case RED = 'RED';
    case EXPIRED = 'EXPIRED';

    public static function fromExpirationDate(string $expirationDate): self {
        $today = new DateTime('today');
        $expiry = new DateTime($expirationDate);
        
        if ($expiry < $today) {
            return self::EXPIRED;
        }

        $days = (int)$today->diff($expiry)->format('%r%a');

        if ($days < 30) {
            return self::RED;
        } elseif ($days < 90) {
            return self::ORANGE;
        } else {
            return self::GREEN;
        }
    }

    public function getBadgeClass(): string {
        return match($this) {
            self::GREEN => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
            self::ORANGE => 'bg-amber-50 text-amber-700 border border-amber-200',
            self::RED => 'bg-red-50 text-red-700 border border-red-200',
            self::EXPIRED => 'bg-gray-100 text-gray-600 border border-gray-300',
        };
    }
}