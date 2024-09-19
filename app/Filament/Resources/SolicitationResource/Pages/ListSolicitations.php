<?php

namespace App\Filament\Resources\SolicitationResource\Pages;

use App\Filament\Resources\SolicitationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSolicitations extends ListRecords
{
    protected static string $resource = SolicitationResource::class;
    protected static ?string $title = 'Listagem de Solicitações';
    protected ?string $maxContentWidth = 'full';
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Adicionar Solicitação'),
            Actions\Action::make('exportarTodas')
                ->label('Exportar Todas')
                ->action(function () {
                    return redirect()->route('solicitations.export-all');
                })
                ->color('success'),
        ];
    }
}
