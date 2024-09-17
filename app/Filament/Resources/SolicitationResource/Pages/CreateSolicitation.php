<?php

namespace App\Filament\Resources\SolicitationResource\Pages;

use App\Filament\Resources\SolicitationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSolicitation extends CreateRecord
{
    protected static string $resource = SolicitationResource::class;
    protected static ?string $title = 'Criar Solicitação';
}
