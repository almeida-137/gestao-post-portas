<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SolicitationResource\Pages;
use App\Filament\Resources\SolicitationResource\RelationManagers;
use App\Models\Solicitation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\BulkAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Exports\SolicitationsExport;

class SolicitationResource extends Resource
{
    protected static ?string $model = Solicitation::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationLabel(): string
    {
        return 'Solicitações'; 
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('loja')
                    ->options([
                        'Paulete BSB' => 'Paulete BSB',
                        'Paulete GO' => 'Paulete GO',
                    ])
                    ->required()
                    ->placeholder('Selecionar Loja'),

                Forms\Components\TextInput::make('dataDoPedido')
                    ->type('date')
                    ->required(),

                Forms\Components\TextInput::make('cliente')
                    ->required(),

                Forms\Components\TextInput::make('montador')
                    ->required(),

                // Defina a estrutura de itens
                Forms\Components\Repeater::make('itens')
                    ->schema([
                        Forms\Components\TextInput::make('ambiente')
                            ->required()
                            ->columnSpan(2),

                        Forms\Components\TextInput::make('cod_ambiente')
                            ->required()
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('quantidade')
                            ->type('number')
                            ->required()
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('descricao')
                            ->required()
                            ->columnSpan(2),

                        Forms\Components\TextInput::make('dimensoes.largura')
                            ->type('number')
                            ->required()
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('dimensoes.altura')
                            ->type('number')
                            ->required()
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('dimensoes.profundidade')
                            ->type('number')
                            ->required()
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('cor')
                            ->required()
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('cor_borda')
                            ->required()
                            ->columnSpan(1),

                            Forms\Components\Select::make('filetacao')
                            ->options([
                                '0L 0H',
                                '0L 1H',
                                '0L 2H',
                                '1L 0H',
                                '1L 1H',
                                '1L 2H',
                                '2L 0H',
                                '2L 1H',
                                '2L 2H',
                            ])
                            ->required()
                            ->label('Filetação')
                            ->columnSpan(1)
                            ->placeholder('Selecionar Filetação'),
                            

                        // Forms\Components\TextInput::make('cor_pintura'),
                        // Forms\Components\TextInput::make('cor_borda_pintura'),
                        Forms\Components\TextInput::make('motivo')
                            ->required()
                            ->columnSpan(1),

                        Forms\Components\Textarea::make('obs')
                            ->columnSpan(2),
                        
                        Forms\Components\FileUpload::make('anexos')
                            ->multiple()
                            ->required()
                            ->columnSpan(3)
                            ->enableOpen()  // Permite abrir o arquivo
                            ->enableDownload()  // Permite fazer download do arquivo
                            ->maxSize(10240)
                            ->disk('public'),
                    ])
                    ->columns(3)
                    ->columnSpan('full')
                    ->createItemButtonLabel('Adicionar Item'),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('cliente'),
                Tables\Columns\TextColumn::make('loja'),
                Tables\Columns\TextColumn::make('dataDoPedido'),
                Tables\Columns\TextColumn::make('montador'),
        ])
            ->filters([
                //
            ])
            // ->headerActions([
            //     Tables\Actions\CreateAction::make(),
            // ])
            ->actions([
                // Tables\Actions\Action::make('Detalhes')
                //     ->url(fn ($record) => route('admin.solicitations.show', $record)),
                Tables\Actions\EditAction::make()
                    ->label('Editar'),
                Tables\Actions\DeleteAction::make()
                    ->label('Deletar'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                // ExportBulkAction::make()              
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSolicitations::route('/'),
            'create' => Pages\CreateSolicitation::route('/create'),
            'edit' => Pages\EditSolicitation::route('/{record}/edit'),
            'show' => Pages\ShowSolicitation::route('/{record}'),
        ];
    }
}
