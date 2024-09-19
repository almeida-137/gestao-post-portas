<?php
namespace App\Http\Controllers;

use App\Models\Solicitation;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SolicitationController extends Controller
{
    public function exportAll()
    {
        $solicitations = Solicitation::where('status', 'Enviado')->get(); // pegas as com status enviado

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Cabeçalhos
        // $sheet->fromArray([
        //     'Caminho', 'Largura', 'Altura', 'Profundidade', 'Chapa', 'Quantidade', 
        //     'Repetir', 'Rotaciona', '-', '0', '0', '0', 'CLIENTE', 'Ambiente', 'Modelo', 
        //     'Descricao', 'Tipo', '.', 'Loja', 'Dimensoes', 'Cor', '.', '.', '.', '.', 
        //     'Identificador', 'Lote', 'Descricao2', 'Borda', '.', 'CorBorda', 'Caixa', '-', 
        //     'Codigo Ambiente', 'F1', 'F2', 'F3', 'F4', '-', '-', '-', '-', '-', '-', '-', '-', '-'
        // ], NULL, 'A1');

        $row = 1; // Inicia na primeira linha, se quiser cabeçalho muda pra dois

        // Preenchimento das linhas
        foreach ($solicitations as $solicitation) {
            // dd($solicitation);
            foreach ($solicitation->itens as $item) {
                $dimensoes = $item['dimensoes']['largura'] . 'x' . $item['dimensoes']['altura'] . 'x' . $item['dimensoes']['profundidade'];
                $desc_dim = $item['descricao'] . ' - ' . $dimensoes;
                $filetar = $item['cor_borda'] . ' - ' . $item['filetacao'];

                $sheet->fromArray([
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
                    $desc_dim,
                    'tipo',
                    '.',
                    $solicitation->loja,
                    $dimensoes,
                    $item['cor'] ?? '.',
                    '.',
                    '.',
                    '.',
                    '.',
                    'Identificador',
                    'Lote',
                    $desc_dim,
                    $filetar,
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
                ], NULL, 'A' . $row);

                $row++;
            }
        }

        // Gera o arquivo XLSX
        $writer = new Xlsx($spreadsheet);

        // Envia o arquivo como resposta para download
        $response = new StreamedResponse(function() use ($writer) {
            $writer->save('php://output');
        });

        // Define o cabeçalho HTTP
        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment; filename="solicitations.xlsx"');

        return $response;
    }

    public function show(Solicitation $record)
    {
        return view('filament.resources.solicitation-resource.pages.show-solicitation', [
            'record' => $record,
        ]);
    }
}


//###################################EXPORT-CSX##################################
//###############################################################################

// namespace App\Http\Controllers;

// use App\Models\Solicitation;
// use Illuminate\Http\Request;
// use Symfony\Component\HttpFoundation\StreamedResponse;

// class SolicitationController extends Controller
// {
//     public function exportAll()
//     {
//         $solicitations = Solicitation::all(); // Pega todas as solicitações

//         $response = new StreamedResponse(function () use ($solicitations) {
//             $handle = fopen('php://output', 'w');
//             // fputcsv($handle, [
//             //     'Caminho',
//             //     'Largura',
//             //     'Altura',
//             //     'Profundidade',
//             //     'Chapa',
//             //     'Quantidade',
//             //     'Repetir',
//             //     'Rotaciona',
//             //     '-',
//             //     '0',
//             //     '0',
//             //     '0',
//             //     'CLIENTE',
//             //     'Ambiente',
//             //     'Modelo',
//             //     'Descricao',
//             //     'Tipo',
//             //     '.',
//             //     'Loja',
//             //     'Dimensoes',
//             //     'Cor',
//             //     '.',
//             //     '.',
//             //     '.',
//             //     '.',
//             //     'Identificador',
//             //     'Lote',
//             //     'Descricao2',
//             //     'Borda',
//             //     '.',
//             //     'CorBorda',
//             //     'Caixa',
//             //     '-',
//             //     'Codigo Ambiente',
//             //     'F1',
//             //     'F2',
//             //     'F3',
//             //     'F4',
//             //     '-',
//             //     '-',
//             //     '-',
//             //     '-',
//             //     '-',
//             //     '-',
//             //     '-',
//             //     '-',
//             //     '-'
//             // ]);
            
//             foreach ($solicitations as $solicitation) {
//                 foreach ($solicitation->itens as $item) {
//                     $dimensoes = $item['dimensoes']['altura'] . 'x' . $item['dimensoes']['largura'] . 'x' . $item['dimensoes']['profundidade'];
//                     $desc_dim = $item['descricao'] . '-' . $dimensoes;
//                     fputcsv($handle, [
//                         'C:\PRODUCAO\corte',
//                         $item['dimensoes']['largura'] ?? '.',
//                         $item['dimensoes']['altura'] ?? '.',
//                         $item['dimensoes']['profundidade'] ?? '.',
//                         'chapa',
//                         $item['quantidade'] ?? '.',
//                         '0',
//                         '90',
//                         '-',
//                         '0',
//                         '0',
//                         '0',
//                         $solicitation->cliente,
//                         $item['ambiente'] ?? '.',
//                         'modelo',
//                         $desc_dim,
//                         'tipo',
//                         '.',
//                         $solicitation->loja,
//                         $dimensoes,
//                         $item['cor'] ?? '.',
//                         '.',
//                         '.',
//                         '.',
//                         '.',
//                         'Identificador',
//                         'Lote',
//                         $desc_dim,
//                         'Borda',
//                         '.',
//                         $item['cor_borda'] ?? '.',
//                         'Box',
//                         '-',
//                         $item['cod_ambiente'] ?? '.',
//                         'Filetacao', //tratar e dividir entre as colunas
//                         'Filetacao', //tratar e dividir entre as colunas
//                         'Filetacao', //tratar e dividir entre as colunas
//                         'Filetacao', //tratar e dividir entre as colunas
//                         '-',
//                         '-',
//                         '-',
//                         '-',
//                         '-',
//                         '-',
//                         '-',
//                         '-',
//                         '-'
//                     ]);
//                 }
//             }

//             fclose($handle);
//         });

//         $response->headers->set('Content-Type', 'text/csv');
//         $response->headers->set('Content-Disposition', 'attachment; filename="solicitations.csv"');

//         return $response;
//     }

//     public function show(Solicitation $record)
//     {
//         return view('filament.resources.solicitation-resource.pages.show-solicitation', [
//             'record' => $record,
//         ]);
//     }
        
// }
