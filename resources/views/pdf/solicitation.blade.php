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
            width: 650px;
        }

        th {
            padding: 15px;
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
            font-size: 12px;
        }

        .page-break {
            page-break-after: always; /* Garante que haverá uma quebra de página após cada item */
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
    </table>

    <h3>PEÇAS:</h3>
    @foreach($solicitation->itens as $peca)
        <table class='itens-table'>
            <tr>
                <th>Quantidade</th>
                <th>Dimensões</th>
                <th>Cor</th>
                <th>Cor Borda</th>
                <th>Observação</th>
                <th>Motivo</th>
            </tr>
            <tr>
                <td class='itens'>{{ $peca['quantidade'] }}</td>
                <td class='itens'>{{ $peca['dimensoes']['largura'] }}x{{ $peca['dimensoes']['altura'] }}x{{ $peca['dimensoes']['profundidade'] }}</td>
                <td class='itens'>{{ $peca['cor'] }}</td>
                <td class='itens'>{{ $peca['cor_borda'] }}</td>
                <td class='itens'>{{ $peca['obs'] }}</td>
                <td class='itens'>{{ $peca['motivo'] }}</td>
            </tr>
        </table>
        <div class="page-break"></div> <!-- Adiciona a quebra de página aqui -->
    @endforeach
</body>

</html>
