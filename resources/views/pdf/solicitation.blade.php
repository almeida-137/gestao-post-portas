{{-- resources/views/pdf/solicitation.blade.php --}}
<!DOCTYPE html>
<html>

<head>
    <title>Solicitação #{{ $solicitation->id }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin-left: 5%;
        }

        h1 {
            color: #007bff;
        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
        }

        table {
            width: 100%;
        }

        th {
            padding: 5px;
        }

        th.ant {
            border-left: 0;
            border-right: 0;
            border-top: 0;
            border-bottom: 0;
        }

        .logo {
            width: 65%;
        }

        h3 {
            color: red;
        }

        .itens-table {
            font-size: 14px;
        }

        .itens {
            text-align: center;
            font-size: 10px;
        }

        .page-break {
            page-break-after: always;
        }

        .anexo-container {
            margin-top: 40px;
            text-align: center;
            clear: both; /* Garante que a div de anexos fique abaixo da tabela */
        }

        .anexo {
            display: inline-block;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .anexo img {
            max-width: 250px;
            max-height: 250px;
        }
        td {
            max-width: 100px; /* Ajuste este valor conforme necessário */
            word-wrap: break-word;
            overflow-wrap: break-word;
            white-space: normal; /* Certifique-se de que o texto possa quebrar */
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <th class='ant'>
                <img class='logo' src="{{ $logo_url }}" alt="Logo">
            </th>
        </tr>
        <tr>
            <th>Pedido Fábrica</th>
        </tr>
        <tr>
            <td>Data do Pedido: {{ \Carbon\Carbon::parse($solicitation->dataDoPedido)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td>Cliente: {{ $solicitation->cliente }}</td>
        </tr>
        <tr>
            <td>Montador: {{ $solicitation->montador }}</td>
        </tr>
        <tr>
            <td>Loja: {{ $solicitation->loja }}</td>
        </tr>
    </table>

    <h3>PEÇAS:</h3>
    @foreach($solicitation->itens as $index => $peca)
        <table class='itens-table'>
            <tr>
                <th>Ambiente</th>
                <th>Quantidade</th>
                <th>Descrição</th>
                <th>Dimensões</th>
                <th>Cor</th>
                <th>Cor Borda</th>
                <th>Observação</th>
                <th>Motivo</th>
            </tr>
            <tr>
                <td class='itens'>{{ $peca['ambiente'] }}</td>
                <td class='itens'>{{ $peca['quantidade'] }}</td>
                <td class='itens'>{{ $peca['descricao'] }}</td>
                <td class='itens'>{{ $peca['dimensoes']['largura'] }}x{{ $peca['dimensoes']['altura'] }}x{{ $peca['dimensoes']['profundidade'] }}</td>
                <td class='itens'>{{ $peca['cor'] }}</td>
                <td class='itens'>{{ $peca['cor_borda'] }} - {{$peca['filetacao']}}</td>
                <td class='itens'>{{ $peca['obs'] }}</td>
                <td class='itens'>{{ $peca['motivo'] }}</td>
            </tr>
        </table>

        <!-- Verifique e exiba os anexos, se forem PNG -->
        @if(isset($peca['anexos']) && is_array($peca['anexos']))
            <div class="anexo-container">
                @foreach($peca['anexos'] as $anexo)
                    @if (in_array(pathinfo($anexo, PATHINFO_EXTENSION), $extensoes_imagens))
                        <div class="anexo">
                            <img src="{{ asset('storage/' . $anexo) }}" alt="Anexo do Item">
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
        
        <!-- @if ($index < count($solicitation->itens) - 1)
            <div class="page-break"></div>
        @endif -->
    @endforeach
</body>

</html>
