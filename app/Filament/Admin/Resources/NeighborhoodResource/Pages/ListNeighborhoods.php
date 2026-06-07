<?php

namespace App\Filament\Admin\Resources\NeighborhoodResource\Pages;

use App\Filament\Admin\Resources\NeighborhoodResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNeighborhoods extends ListRecords
{
    protected static string $resource = NeighborhoodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
