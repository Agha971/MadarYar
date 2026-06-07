<?php

namespace App\Filament\Admin\Resources\HamyarTicketResource\Pages;

use App\Filament\Admin\Resources\HamyarTicketResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHamyarTickets extends ListRecords
{
    protected static string $resource = HamyarTicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
