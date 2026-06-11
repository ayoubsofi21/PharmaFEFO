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
            self::GREEN => 'bg-success text-white',
            self::ORANGE => 'bg-warning text-dark',
            self::RED => 'bg-danger text-white',
            self::EXPIRED => 'bg-secondary text-white',
        };
    }
}