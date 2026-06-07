<?php

namespace App\Filament\Admin\Resources\HamyarProfileResource\Pages;

use App\Filament\Admin\Resources\HamyarProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHamyarProfiles extends ListRecords
{
    protected static string $resource = HamyarProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
