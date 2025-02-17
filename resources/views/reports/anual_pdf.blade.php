<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ventas y Compras</title>
    <style>
        @page {
            size: 400mm 200mm; /* A4 en orientación vertical */
            margin: 10mm;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
            color: #333;
        }

        .container {
            width: 90%;
            max-width: 1500px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 2px solid #4CAF50;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #4CAF50;
        }

        .header p {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
        }

        /* Estilos para la sección de información */
        .info {
            font-size: 16px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .info p {
            margin: 0;
        }

        /* Ajuste para la tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px auto;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .totals {
            font-weight: bold;
            background-color: #e0f7fa;
        }

        .right-align {
            text-align: right;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 2px solid #4CAF50;
            font-size: 12px;
            color: #666;
        }

        .footer p {
            margin: 5px 0;
        }

        .logo {
            width: 100px;
            margin-bottom: 10px;
        }

        .info {
            display: flex; /* Hace que los elementos se alineen en fila */
            font-size: 18px; /* Tamaño de la fuente */
            gap: 20px; /* Espacio entre los elementos */
            align-items: center; /* Alinea los elementos verticalmente */
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Encabezado -->
        <div class="header">
            <img src="https://via.placeholder.com/100x50?text=Logo+Empresa" alt="Logo" class="logo">
            <h1>Reporte Anual</h1>
            <p>Generado el: {{ \Carbon\Carbon::now()->locale('es')->translatedFormat('l, j F Y') }}</p>
        </div>

        <!-- Información de Usuario -->
        <div class="info">
            <p><strong>NOMBRE:</strong> {{ $client->user->last_name }} {{ $client->user->first_name }}</p>
            <p><strong>CI:</strong> {{ $client->user->ci }} {{ $client->user->complement_ci }}</p>
            <p><strong>NIT:</strong> {{ $client->user->nit ? $client->user->nit : 'N/A' }}</p>
        </div>
        <!-- Tabla de Datos -->
        <table>
            <thead>
                <tr>
                    <th>Mes</th>
                    <th>Ventas</th>
                    <th>Descuentos</th>
                    <th>Compras</th>
                    <th>Compras Grabadas</th>
                    <th>Saldo Anterior</th>
                    <th>Actualización</th>
                    <th>Saldo Actual</th>
                    <th>IVA Calculado</th>
                    <th>IVA Real</th>
                    <th>Comp del IUE</th>
                    <th>IT Calculado</th>
                    <th>IT Real</th>
                    <th>IUE</th>
                </tr>
            </thead>
            <tbody>
                @forelse($filteredServiceRecord as $record)
                    <tr>
                        <td>{{ ucwords(\Carbon\Carbon::parse($record->date)->locale('es')->translatedFormat('F')) }}</td>
                        <td class="right-align">{{ optional($record->statement)->sales ?? 'N/A' }}</td>
                        <td class="right-align">{{ optional($record->statement)->discounts ?? 'N/A' }}</td>
                        <td class="right-align">{{ optional($record->statement)->purchases ?? 'N/A' }}</td>
                        <td class="right-align">{{ optional($record->statement)->recorded_purchases ?? 'N/A' }}</td>
                        <td class="right-align">{{ optional($record->statement)->previous_balance ?? 'N/A' }}</td>
                        <td class="right-align">{{ optional($record->statement)->update ?? 'N/A' }}</td>
                        <td class="right-align">{{ optional($record->statement)->current_balance ?? 'N/A' }}</td>
                        <td class="right-align">{{ optional($record->statement)->calculated_IVA ?? 'N/A' }}</td>
                        <td class="right-align">{{ optional($record->statement)->real_IVA ?? 'N/A' }}</td>
                        <td class="right-align">{{ optional($record->statement)->comp_IUE ?? 'N/A' }}</td>
                        <td class="right-align">{{ optional($record->statement)->calculated_IT ?? 'N/A' }}</td>
                        <td class="right-align">{{ optional($record->statement)->real_IT ?? 'N/A' }}</td>
                        <td class="right-align">{{ optional($record->statement)->IUE ?? 0 }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="13" class="text-center">No se encontraron registros de servicio para este cliente.</td>
                    </tr>
                @endforelse
                <tr class="totals">
                    <td>Total</td>
                    <td class="right-align">{{ number_format($totals['sales'], 2) }}</td>
                    <td class="right-align">{{ number_format($totals['discounts'], 2) }}</td>
                    <td class="right-align">{{ number_format($totals['purchases'], 2) }}</td>
                    <td class="right-align">{{ number_format($totals['recorded_purchases'], 2) }}</td>
                    <td class="right-align">{{ number_format($totals['previous_balance'], 2) }}</td>
                    <td class="right-align">{{ number_format($totals['update'], 2) }}</td>
                    <td class="right-align">{{ number_format($totals['current_balance'], 2) }}</td>
                    <td class="right-align">{{ number_format($totals['calculated_IVA'], 2) }}</td>
                    <td class="right-align">{{ number_format($totals['real_IVA'], 2) }}</td>
                    <td class="right-align">{{ number_format($totals['comp_IUE'], 2) }}</td>
                    <td class="right-align">{{ number_format($totals['calculated_IT'], 2) }}</td>
                    <td class="right-align">{{ number_format($totals['real_IT'], 2) }}</td>
                    <td class="right-align">{{ number_format($totals['IUE'], 2) }}</td>
                </tr>

            </tbody>
        </table>

        <!-- Pie de Página -->
        <div class="footer">
            <p>Reporte generado automáticamente por el sistema.</p>
            <p>Página 1 de 1</p>
        </div>
    </div>
</body>
</html>
