<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EnginnerResource\Pages;
use App\Models\Enginner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\BulkAction;
use Filament\Pages\Actions\ButtonAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
class EnginnerResource extends Resource
{
    public static function canViewAny(): bool
    {
        // Permite a visualização do recurso somente para usuários do tipo 'administrador'
        return Auth::user()->type === 'administrador';
    }
    protected static ?string $model = Enginner::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Engenharia';
    protected static ?int $navigationSort = 2;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('cliente')
                    ->label('Cliente')
                    ->required(),
                
                Forms\Components\DatePicker::make('dataEng')
                    ->label('Data Engenharia')
                    ->required(),
                
                Forms\Components\DatePicker::make('dataPcp')
                    ->label('Data PCP')
                    ->nullable(),
                
                Forms\Components\DatePicker::make('dataFinalizacao')
                    ->label('Data Finalização')
                    ->nullable(),
                
                Forms\Components\Select::make('status')
                    ->options([
                        'Em Produção' => 'Em Produção',
                        'Concluído' => 'Concluído',
                    ])
                    ->label('Status')
                    ->hidden(fn ($livewire) => $livewire instanceof Pages\CreateSolicitation)
                    ->placeholder('Alterar Status')
                    ->default('Enviado')
                    ->columnSpan(['sm' => 1, 'md' => 2]),
                
                Forms\Components\Repeater::make('itens')
                    ->label('Itens')
                    ->schema([
                        Forms\Components\TextInput::make('nome')
                            ->label('Nome do Item')
                            ->required(),
                        Forms\Components\TextInput::make('quantidade')
                            ->label('Quantidade')
                            ->numeric(),
                        Forms\Components\FileUpload::make('anexos')
                            ->multiple()
                            ->columnSpan(['sm' => 1, 'md' => 3])
                            ->enableOpen()
                            ->enableDownload()
                            ->maxSize(10240)
                            ->disk('public'),
                    ])
                    ->nullable()
                    ->createItemButtonLabel('Adicionar Item')
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cliente')
                    ->label('Cliente')
                    ->sortable()
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('dataEng')
                    ->label('Data Engenharia')
                    ->date('d/m/Y')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('dataPcp')
                    ->label('Data PCP')
                    ->date('d/m/Y')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('dataFinalizacao')
                    ->label('Data Finalização')
                    ->date('d/m/Y')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->searchable(),
                
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Em Produção' => 'Em Produção',
                        'Concluído' => 'Concluído',
                    ]),
                Tables\Filters\Filter::make('dataEng')
                    ->form([
                        Forms\Components\DatePicker::make('data_inicial')
                            ->label('Data Inicial'),
                        Forms\Components\DatePicker::make('data_final')
                            ->label('Data Final'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['data_inicial'], fn ($query) => $query->whereDate('dataEng', '>=', $data['data_inicial']))
                            ->when($data['data_final'], fn ($query) => $query->whereDate('dataEng', '<=', $data['data_final']));
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Editar')
                    ->visible(fn () => auth()->user()->type === 'interno' || auth()->user()->type === 'administrador'),

                Tables\Actions\DeleteAction::make()
                    ->label('Deletar')
                    ->visible(fn () => auth()->user()->type === 'interno' || auth()->user()->type === 'administrador')
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->visible(fn () => auth()->user()->type === 'interno' || auth()->user()->type === 'administrador'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Adicionar relacionamentos aqui, se necessário
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEnginners::route('/'),
            'create' => Pages\CreateEnginner::route('/create'),
            'edit' => Pages\EditEnginner::route('/{record}/edit'),
        ];
    }
}
