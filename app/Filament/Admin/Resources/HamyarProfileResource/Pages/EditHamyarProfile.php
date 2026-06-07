<?php

namespace App\Filament\Admin\Resources\HamyarProfileResource\Pages;

use App\Filament\Admin\Resources\HamyarProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHamyarProfile extends EditRecord
{
    protected static string $resource = HamyarProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
