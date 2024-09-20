<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\View;
use App\Models\Solicitation;

class PDFController extends Controller
{
    public function generatePDF($id)
    {
        // Buscar a solicitação pelo ID
        $solicitation = Solicitation::findOrFail($id);
        // $logo_url = asset('images/custom_logo.png');
        // Carregar o template e passar os dados da solicitação
        $html = View::make('pdf.solicitation', [
            'solicitation' => $solicitation,
            // 'logo_url' => $logo_url,
        ])->render();

        // Inicializar DOMPDF
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new Dompdf($options);

        // Carregar o HTML no DOMPDF
        $dompdf->loadHtml($html);

        // Definir o tamanho e orientação da página
        $dompdf->setPaper('A4', 'portrait');

        // Renderizar o PDF
        $dompdf->render();

        // Enviar o PDF para o navegador
        return $dompdf->stream("solicitation_{$id}.pdf", ["Attachment" => true]);
    }
}
