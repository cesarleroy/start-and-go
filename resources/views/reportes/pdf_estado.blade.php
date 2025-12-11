<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header img { width: 100px; }
        .header h1 { font-size: 18px; color: #333; margin-top: 10px; text-transform: uppercase; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #0d1b2a; color: white; font-weight: bold; text-align: center; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        
        .total-row td { font-weight: bold; background-color: #e9ecef; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        
        .footer { position: fixed; bottom: 0; left: 0; right: 0; text-align: center; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('img/Logo.jpg') }}" alt="Logo Start & Go">
        <h1>Estado de Cuenta - {{ $mesFormateado }}</h1>
    </div>

    <table>
        <thead>
            <tr>
                <th>Cliente</th>
                <th>RFC</th>
                <th>Fecha Pago</th>
                <th>Forma de Pago</th>
                <th>Reembolso</th>
                <th>Monto</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pagos as $pago)
            <tr>
                <td>
                    {{ $pago->alumno ? $pago->alumno->nombre . ' ' . $pago->alumno->apellido_p . ' ' . $pago->alumno->apellido_m : 'Cliente no encontrado' }}
                </td>
                <td>{{ $pago->rfc_cliente }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') }}</td>
                <td class="text-center">{{ $pago->forma_pago }}</td>
                <td class="text-center">{{ $pago->reembolso ? 'SÍ' : 'NO' }}</td>
                <td class="text-right">${{ number_format($pago->total_pago, 2) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No hay pagos registrados en este mes.</td>
            </tr>
            @endforelse
            
            <tr class="total-row">
                <td colspan="5" class="text-right">TOTAL DEL MES:</td>
                <td class="text-right">${{ number_format($pagos->sum('total_pago'), 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Reporte generado el {{ date('d/m/Y H:i') }} | Start & Go Sistema de Control</p>
    </div>
</body>
</html>