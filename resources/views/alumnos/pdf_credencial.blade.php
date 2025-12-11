<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { margin: 0; padding: 0; font-family: sans-serif; }
        .tarjeta {
            width: 88mm; height: 55mm;
            position: relative;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
        }
        .header {
            background-color: #0d1b2a;
            height: 15mm;
            width: 100%;
            position: absolute; top: 0; left: 0;
        }
        .logo {
            position: absolute; top: 2mm; left: 2mm;
            width: 10mm;
        }
        .titulo {
            position: absolute; top: 4mm; left: 15mm;
            color: #fff; font-weight: bold; font-size: 10pt;
            text-transform: uppercase;
        }
        .foto-marco {
            position: absolute; top: 18mm; left: 3mm;
            width: 22mm; height: 28mm;
            border: 1px solid #ccc;
            background-color: #eee;
        }
        .foto {
            width: 100%; height: 100%; object-fit: cover;
        }
        .datos {
            position: absolute; top: 18mm; left: 28mm;
            width: 58mm;
        }
        .dato-label { font-size: 6pt; color: #666; margin-top: 2px; }
        .dato-valor { font-size: 8pt; font-weight: bold; color: #000; }
    </style>
</head>
<body>
    <div class="tarjeta">
        <div class="header">
            <img src="{{ public_path('img/icono.png') }}" class="logo">
            <div class="titulo">Escuela de Manejo</div>
        </div>

        <div class="foto-marco">
            <img src="{{ $rutaFotoReal }}" class="foto">
        </div>

        <div class="datos">
            <div class="dato-label">ALUMNO</div>
            <div class="dato-valor" style="font-size: 9pt; color:#0d1b2a;">
                {{ strtoupper($alumno->nombre . ' ' . $alumno->apellido_p) }}
            </div>

            <table style="width: 100%; margin-top: 3px;">
                <tr>
                    <td style="width: 50%">
                        <div class="dato-label">RFC</div>
                        <div class="dato-valor">{{ $alumno->rfc }}</div>
                    </td>
                    <td style="width: 50%">
                        <div class="dato-label">PERMISO</div>
                        <div class="dato-valor">{{ $alumno->permiso }}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="dato-label">VIGENCIA</div>
                        <div class="dato-valor">{{ date('Y') }} - {{ date('Y', strtotime('+1 year')) }}</div>
                    </td>
                </tr>
                <tr>
                  @php
                      $iniciales = strtoupper(substr($alumno->apellido_p, 0, 1) . substr($alumno->apellido_m ?? 'X', 0, 1) . substr($alumno->nombre, 0, 1));
                      $fecha = \Carbon\Carbon::parse($alumno->fecha_nac)->format('ymd');
                      $matricula = $iniciales . $fecha . rand(10000, 99999);
                    @endphp
                    <td>
                        <div class="dato-label">NO. ALUMNO</div>
                        <div class="dato-valor">{{ $matricula }}</div>
                    </td>
                    
                </tr>
            </table>
        </div>
    </div>
</body>
</html>