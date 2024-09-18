<?php
namespace App\Http\Controllers;

use App\Models\Solicitation;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SolicitationController extends Controller
{
    public function exportAll()
    {
        $solicitations = Solicitation::all(); // Pega todas as solicitações

        $response = new StreamedResponse(function () use ($solicitations) {
            $handle = fopen('php://output', 'w');
            // fputcsv($handle, [
            //     'Caminho',
            //     'Largura',
            //     'Altura',
            //     'Profundidade',
            //     'Chapa',
            //     'Quantidade',
            //     'Repetir',
            //     'Rotaciona',
            //     '-',
            //     '0',
            //     '0',
            //     '0',
            //     'CLIENTE',
            //     'Ambiente',
            //     'Modelo',
            //     'Descricao',
            //     'Tipo',
            //     '.',
            //     'Loja',
            //     'Dimensoes',
            //     'Cor',
            //     '.',
            //     '.',
            //     '.',
            //     '.',
            //     'Identificador',
            //     'Lote',
            //     'Descricao2',
            //     'Borda',
            //     '.',
            //     'CorBorda',
            //     'Caixa',
            //     '-',
            //     'Codigo Ambiente',
            //     'F1',
            //     'F2',
            //     'F3',
            //     'F4',
            //     '-',
            //     '-',
            //     '-',
            //     '-',
            //     '-',
            //     '-',
            //     '-',
            //     '-',
            //     '-'
            // ]);
            
            foreach ($solicitations as $solicitation) {
                foreach ($solicitation->itens as $item) {

                    fputcsv($handle, [
                        'C:\PRODUCAO\corte',
                        $item['dimensoes']['largura'] ?? '.',
                        $item['dimensoes']['altura'] ?? '.',
                        $item['dimensoes']['profundidade'] ?? '.',
                        'chapa',
                        $item['quantidade'] ?? '.',
                        '0',
                        '90',
                        '-',
                        '0',
                        '0',
                        '0',
                        $solicitation->cliente,
                        $item['ambiente'] ?? '.',
                        'modelo',
                        $item['descricao'] ?? '.',
                        'tipo',
                        '.',
                        $solicitation->loja,
                        'dimens',
                        $item['cor'] ?? '.',
                        '.',
                        '.',
                        '.',
                        '.',
                        'Identificador',
                        'Lote',
                        $item['descricao'] ?? '.',
                        'Borda',
                        '.',
                        $item['cor_borda'] ?? '.',
                        'Box',
                        '-',
                        $item['cod_ambiente'] ?? '.',
                        'Filetacao', //tratar e dividir entre as colunas
                        'Filetacao', //tratar e dividir entre as colunas
                        'Filetacao', //tratar e dividir entre as colunas
                        'Filetacao', //tratar e dividir entre as colunas
                        '-',
                        '-',
                        '-',
                        '-',
                        '-',
                        '-',
                        '-',
                        '-',
                        '-'
                    ]);
                }
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="solicitations.csv"');

        return $response;
    }

    public function show(Solicitation $record)
    {
        return view('filament.resources.solicitation-resource.pages.show-solicitation', [
            'record' => $record,
        ]);
    }
        
}
