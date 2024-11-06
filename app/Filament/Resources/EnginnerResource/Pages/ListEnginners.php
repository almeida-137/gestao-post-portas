<?php

namespace App\Filament\Resources\EnginnerResource\Pages;

use App\Filament\Resources\EnginnerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEnginners extends ListRecords
{
    protected static string $resource = EnginnerResource::class;
    protected static ?string $title = 'Listagem de Projetos';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Adicionar Projeto'),
        ];
    }
}
