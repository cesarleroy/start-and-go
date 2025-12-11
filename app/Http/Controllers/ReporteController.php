<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pago;
use Spipu\Html2Pdf\Html2Pdf; // Importamos la librería
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Carbon\Carbon;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        // ... (Tu código actual del index se queda igual)
        $fechaInicio = $request->input('fechaInicio', date('Y-m-d', strtotime('-30 days')));
        $fechaFin = $request->input('fechaFin', date('Y-m-d'));

        // ... (Tus consultas actuales) ...
        $clasesPorDia = DB::table('agenda')
            ->select('fecha', DB::raw('count(*) as total'))
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        $resultadosExamenes = DB::table('agenda')
            ->select(DB::raw("
                SUM(CASE WHEN exam_teo >= 70 THEN 1 ELSE 0 END) as aprobados_teo,
                SUM(CASE WHEN exam_teo < 70 THEN 1 ELSE 0 END) as reprobados_teo,
                SUM(CASE WHEN exam_prac >= 70 THEN 1 ELSE 0 END) as aprobados_prac,
                SUM(CASE WHEN exam_prac < 70 THEN 1 ELSE 0 END) as reprobados_prac
            "))
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->first();

        $instructores = DB::table('agenda')
            ->select('rfc_emp', DB::raw('count(*) as total'))
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->groupBy('rfc_emp')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return view('reportes.index', compact('fechaInicio', 'fechaFin', 'clasesPorDia', 'resultadosExamenes', 'instructores'));
    }

    public function estadoCuenta(Request $request)
    {
        // 1. Obtener el mes seleccionado (formato YYYY-MM)
        $mes = $request->input('mes', date('Y-m'));
        
        // Calcular inicio y fin de mes
        $fechaInicio = Carbon::parse($mes . '-01')->startOfMonth();
        $fechaFin = Carbon::parse($mes . '-01')->endOfMonth();

        // 2. Obtener los pagos con los datos del alumno
        $pagos = Pago::with('alumno')
            ->whereBetween('fecha_pago', [$fechaInicio, $fechaFin])
            ->orderBy('fecha_pago', 'asc')
            ->get();

        // 3. Formatear el nombre del mes para el título
        Carbon::setLocale('es');
        $mesFormateado = ucfirst($fechaInicio->translatedFormat('F Y')); // Ej: "Junio 2025"

        // 4. Renderizar la vista a HTML
        $html = view('reportes.pdf_estado', compact('pagos', 'mesFormateado'))->render();

        // 5. Generar PDF
        try {
            $html2pdf = new Html2Pdf('P', 'A4', 'es');
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($html);
            $html2pdf->output("Estado_Cuenta_$mes.pdf");
        } catch (Html2PdfException $e) {
            $html2pdf->clean();
            return redirect()->back()->with('error', 'Error al generar PDF: ' . $e->getMessage());
        }
    }
}