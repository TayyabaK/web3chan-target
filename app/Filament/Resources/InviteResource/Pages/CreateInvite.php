<?php

declare(strict_types=1);

namespace App\Filament\Resources\InviteResource\Pages;

use App\Filament\Resources\InviteResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInvite extends CreateRecord
{
    protected static string $resource = InviteResource::class;
}
