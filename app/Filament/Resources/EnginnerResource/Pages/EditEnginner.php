<?php

namespace App\Filament\Resources\EnginnerResource\Pages;

use App\Filament\Resources\EnginnerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEnginner extends EditRecord
{
    protected static string $resource = EnginnerResource::class;
    protected static ?string $title = 'Editar Projeto';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
            ->label('Deletar'),
        ];
    }
}
