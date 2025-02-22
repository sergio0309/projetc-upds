<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Tributario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #fff;
        }

        .report-container {
            width: 100%;
            max-width: 595px; /* Ancho de media hoja A4 (210mm / 2 = 105mm = 595px aprox) */
            height: 380px;  /* Altura de media hoja A4 (297mm / 2 = 148.5mm = 420px aprox) */
            border: 1px solid #000;
            padding: 10px;
            box-sizing: border-box;
            text-align: center;
            margin: 0 auto;
        }

        .header {
            background: #c0e5a3;
            padding: 5px;
            font-weight: bold;
            font-size: 16px;
        }

        .section {
            background: #d7e3fc;
            padding: 5px;
            margin-top: 5px;
        }

        .total {
            background: #f0f0f0;
            font-weight: bold;
            padding: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        td, th {
            border: 1px solid #000;
            padding: 5px;
        }

        td:first-child {
            text-align: left; /* Alinea la primera columna (descripción) a la izquierda */
        }

        td:not(:first-child) {
            text-align: right; /* Alinea el resto de las celdas a la derecha */
        }

        .note {
            font-style: italic;
            font-size: 12px;
            text-align: center;
            margin-top: 5px;
        }

        @media print {
            body {
                padding: 0;
                margin: 0;
            }

            .report-container {
                width: 100%;
                height: 100%;
                max-width: none;
                max-height: none;
                page-break-before: always;
            }
        }

        /* Para asegurar que el contenido de la celda no se divida */
        .single-line {
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <div class="report-container">
        <div class="header">
            {{ $statement->serviceRecord->client->user->first_name }}
            {{ $statement->serviceRecord->client->user->last_name }}
        </div>
        <table>
            <tr>
                <td>Ventas</td>
                @if ($statement->discounts)
                <td>{{ round($statement->discounts * (1 / 0.13)) }}</td>
                @else
                <td>0</td>
                @endif
                <td>{{ $statement->sales }}</td>
            </tr>
            <tr>
                <td>Compras</td>
                <td>0</td>
                <td>{{ $statement->recorded_purchases }}</td>
            </tr>
            <tr>
                <td>Crédito IVA</td>
                <td>{{ $statement->previous_balance}}</td>
                <td>0</td>
            </tr>
            <tr>
                <td>IUE a IT</td>
                <td>0</td>
                <td>0</td>
            </tr>
            <tr>
                <td>IVA a Pagar</td>
                <td>0</td>
                <td>0</td>
            </tr>
            <tr>
                <td>IT a Pagar</td>
                <td>0</td>
                <td>{{ $statement->real_IT }}</td>
            </tr>
            <tr>
                <td>Balance Anual IUE (1000 Bs)</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>IDF</td>
                <td>0</td>
                <td>0</td>
            </tr>
        </table>

        <div class="section">
            <table>
                <tr>
                    <td>IMPUESTO</td>
                    <<td>{{ \Carbon\Carbon::parse($statement->date)->locale('es')->translatedFormat('F') }}</td>
                    <td>0</td> <!-- Fórmula de cálculo -->
                </tr>
            </table>
        </div>

        {{-- <table>
            <tr>
                <td>Servicio JPM Consultores</td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td>Otros (Saldo Anterior)</td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td>Balance Anual (1000Bs)</td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td class="single-line">Fundaempresa (100 Bs)</td>
                <td colspan="2"></td>
            </tr>
        </table>

        <div class="total">Total Deuda 7804051011 - 845</div> --}}

        <div class="note">En el momento del pago exige tu <b>REPORTE TRIBUTARIO</b> actualizado. <br>Atte. JPM Consultores</div>
    </div>
</body>
</html>
