<?php

declare(strict_types=1);

namespace App\Enums\User;

enum FinanceType: string
{
    case Wallet = 'wallet';
    case Donation = 'donation';
    case Tip = 'tip';
}
