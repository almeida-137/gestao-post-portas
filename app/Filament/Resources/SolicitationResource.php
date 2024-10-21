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
use App\Http\Controllers\PDFController;
use Filament\Pages\Actions\ButtonAction;

class SolicitationResource extends Resource
{
    protected static ?string $model = Solicitation::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Solicitações';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('loja')
                    ->options([
                        'Paulete BSB' => 'Paulete BSB',
                        'Paulete GO' => 'Paulete GO',
                        'AvSoares' => 'AvSoares',
                    ])
                    ->required()
                    ->placeholder('Selecionar Loja'),

                Forms\Components\TextInput::make('dataDoPedido')
                    ->type('date')
                    ->required()
                     ->default(now()->format('Y-m-d')),

                Forms\Components\TextInput::make('cliente')
                    ->required(),

                Forms\Components\TextInput::make('montador')
                    ->required(),
                    Forms\Components\Select::make('status')
                    ->options([
                        'Enviado' => 'Enviado',
                        'Em Produção' => 'Em Produção',
                        'Produção 3CAD' => 'Produção 3CAD',
                        'Pedido Vitralle' => 'Pedido Vitralle',
                        'Concluído' => 'Concluído',
                    ])
                    ->label('Status')
                    ->hidden(fn ($livewire) => $livewire instanceof Pages\CreateSolicitation) // Ocultar na criação
                    ->placeholder('Alterar Status') // Placeholder para quando nenhum valor for selecionado
                    ->default('Enviado'), // Define o valor padrão ao criar

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
                                '0L 0H' => '0L 0H',
                                '0L 1H' => '0L 1H',
                                '0L 2H' => '0L 2H',
                                '1L 0H' => '1L 0H',
                                '1L 1H' => '1L 1H',
                                '1L 2H' => '1L 2H',
                                '2L 0H' => '2L 0H',
                                '2L 1H' => '2L 1H',
                                '2L 2H' => '2L 2H',
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
                            // ->required()
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
            
            Tables\Columns\TextColumn::make('id')
                ->searchable(),
            Tables\Columns\TextColumn::make('cliente')
                ->searchable(),
            Tables\Columns\TextColumn::make('loja')
                ->searchable(),
            Tables\Columns\TextColumn::make('dataDoPedido')
                ->sortable() // Permite ordenar
                ->label('Data')
                ->date(), // Formata como data
            Tables\Columns\TextColumn::make('montador'),
            Tables\Columns\TextColumn::make('status')
                ->searchable(),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('status')
                ->options([
                    'Enviado' => 'Enviado',
                    'Em Produção' => 'Em Produção',
                    'Produção 3CAD' => 'Produção 3CAD',
                    'Pedido Vitralle' => 'Pedido Vitralle',
                    'Concluído' => 'Concluído',
                ]),
            Tables\Filters\SelectFilter::make('loja')
                ->options([
                    'Paulete BSB' => 'Paulete BSB',
                    'Paulete GO' => 'Paulete GO',
                ]),
            Tables\Filters\Filter::make('dataDoPedido')
                ->form([
                    Forms\Components\DatePicker::make('data_inicial')
                        ->label('Data Inicial'),
                    Forms\Components\DatePicker::make('data_final')
                        ->label('Data Final'),
                ])
                ->query(function (Builder $query, array $data) {
                    return $query
                        ->when($data['data_inicial'], fn ($query) => $query->whereDate('dataDoPedido', '>=', $data['data_inicial']))
                        ->when($data['data_final'], fn ($query) => $query->whereDate('dataDoPedido', '<=', $data['data_final']));
                }),
        ])
            // ->headerActions([
            //     Tables\Actions\CreateAction::make(),
            // ])
            ->actions([
                Tables\Actions\Action::make('generatePDF')
                ->label('PDF')
                ->action(function ($record) {
                    // Redireciona para a rota que gera o PDF, passando o ID da solicitação
                    return redirect()->action([PDFController::class, 'generatePDF'], ['id' => $record->id]);
                })
                ->color('primary')
                ->visible(fn () => auth()->user()->type === 'interno'),
                // Tables\Actions\Action::make('Detalhes')
                //     ->url(fn ($record) => route('admin.solicitations.show', $record)),
                Tables\Actions\EditAction::make()
                    ->label('Editar')
                    ->visible(fn () => auth()->user()->type === 'interno'), 
                Tables\Actions\DeleteAction::make()
                    ->label('Deletar')
                    ->visible(fn () => auth()->user()->type === 'interno')
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->visible(fn () => auth()->user()->type === 'interno'), 
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
        ];
    }
}
