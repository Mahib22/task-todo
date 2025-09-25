<?php

namespace App\Filament\Resources\UserPositions\Pages;

use App\Filament\Resources\UserPositions\UserPositionResource;
use pxlrbt\FilamentActivityLog\Pages\ListActivities;

class ListUserPositionActivities extends ListActivities
{
    protected static string $resource = UserPositionResource::class;
}
