<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        $fechaInicio = $request->input('fechaInicio', date('Y-m-d', strtotime('-30 days')));
        $fechaFin = $request->input('fechaFin', date('Y-m-d'));

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
    
    public function estadoCuenta(Request $request) {
        
    }
}