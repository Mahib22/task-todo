<?php

namespace App\Filament\Resources\UserPositions\Pages;

use App\Filament\Resources\UserPositions\UserPositionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageUserPositions extends ManageRecords
{
    protected static string $resource = UserPositionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
