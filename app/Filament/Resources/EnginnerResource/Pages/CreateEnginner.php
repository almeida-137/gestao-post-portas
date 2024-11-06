<?php

namespace App\Filament\Resources\EnginnerResource\Pages;

use App\Filament\Resources\EnginnerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEnginner extends CreateRecord
{
    protected static string $resource = EnginnerResource::class;
    protected static ?string $title = 'Criar Projeto';
}
