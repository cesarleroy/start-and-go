<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatosPruebaSeeder extends Seeder
{
    public function run(): void
    {
        // 1. EMPLEADOS (Mapeo de tu SQL original a Laravel)
        $empleados = [
            ['rfc' => 'GARC900101HDF', 'nombre' => 'ANA', 'apellido_p' => 'GARCÍA', 'apellido_m' => 'LOPEZ', 'puesto' => 'INSTRUCTORA', 'turno' => 'MATUTINO', 'descansos' => 'LUNES,MARTES', 'sexo' => 'FEMENINO', 'fecha_nac' => '1990-01-01', 'tel_personal' => 5541234567, 'calle' => 'MIGUEL HIDALGO', 'numero' => 12, 'colonia' => 'DEL VALLE', 'alcaldia' => 'BENITO JUÁREZ'],
            ['rfc' => 'LOPE920304MDF', 'nombre' => 'LUIS', 'apellido_p' => 'LOPEZ', 'apellido_m' => 'MORALES', 'puesto' => 'ADMINISTRADOR', 'turno' => 'MATUTINO', 'descansos' => 'SÁBADO,DOMINGO', 'sexo' => 'MASCULINO', 'fecha_nac' => '1992-03-04', 'tel_personal' => 5512345678, 'calle' => 'INSURGENTES SUR', 'numero' => 245, 'colonia' => 'NÁPOLES', 'alcaldia' => 'BENITO JUÁREZ'],
            ['rfc' => 'FERJ850715HDF', 'nombre' => 'JUAN', 'apellido_p' => 'FERNANDEZ', 'apellido_m' => 'RODRIGUEZ', 'puesto' => 'RECEPCIONISTA', 'turno' => 'MATUTINO', 'descansos' => 'SÁBADO,LUNES', 'sexo' => 'MASCULINO', 'fecha_nac' => '1985-07-15', 'tel_personal' => 5556677889, 'calle' => 'CENTENARIO', 'numero' => 33, 'colonia' => 'ROMA NORTE', 'alcaldia' => 'CUAUHTÉMOC'],
            ['rfc' => 'VELM870610HDF', 'nombre' => 'MARIO', 'apellido_p' => 'VELAZQUEZ', 'apellido_m' => 'MARTINEZ', 'puesto' => 'INSTRUCTOR', 'turno' => 'MATUTINO', 'descansos' => 'MIÉRCOLES,VIERNES', 'sexo' => 'MASCULINO', 'fecha_nac' => '1987-06-10', 'tel_personal' => 5578912345, 'calle' => 'TACUBA', 'numero' => 77, 'colonia' => 'SAN RAFAEL', 'alcaldia' => 'CUAUHTÉMOC'],
            ['rfc' => 'REYG940420HDF', 'nombre' => 'GABRIEL', 'apellido_p' => 'REYES', 'apellido_m' => 'GUTIÉRREZ', 'puesto' => 'INSTRUCTOR', 'turno' => 'MATUTINO', 'descansos' => 'SÁBADO,DOMINGO', 'sexo' => 'MASCULINO', 'fecha_nac' => '1994-04-20', 'tel_personal' => 5522233344, 'calle' => 'FRAY SERVANDO', 'numero' => 88, 'colonia' => 'OBRERA', 'alcaldia' => 'CUAUHTÉMOC'],
            ['rfc' => 'SALM860927MDF', 'nombre' => 'MONICA', 'apellido_p' => 'SALAZAR', 'apellido_m' => 'MORA', 'puesto' => 'INSTRUCTORA', 'turno' => 'VESPERTINO', 'descansos' => 'VIERNES,SÁBADO', 'sexo' => 'FEMENINO', 'fecha_nac' => '1986-09-27', 'tel_personal' => 5533344455, 'calle' => 'EJE CENTRAL', 'numero' => 333, 'colonia' => 'CENTRO', 'alcaldia' => 'CUAUHTÉMOC'],
            ['rfc' => 'LOZR970708HDF', 'nombre' => 'RAFAEL', 'apellido_p' => 'LOZANO', 'apellido_m' => 'RIVERA', 'puesto' => 'INSTRUCTOR', 'turno' => 'VESPERTINO', 'descansos' => 'MARTES,JUEVES', 'sexo' => 'MASCULINO', 'fecha_nac' => '1997-07-08', 'tel_personal' => 5544455566, 'calle' => 'PATRIOTISMO', 'numero' => 11, 'colonia' => 'ESPARTACO', 'alcaldia' => 'COYOACÁN'],
            ['rfc' => 'MOSE030526A50', 'nombre' => 'ERICK', 'apellido_p' => 'MONROY', 'apellido_m' => 'SANTANA', 'puesto' => 'SUPERVISOR', 'turno' => 'MATUTINO', 'descansos' => 'SÁBADO,DOMINGO', 'sexo' => 'MASCULINO', 'fecha_nac' => '2003-05-26', 'tel_personal' => 5540608099, 'calle' => 'LAS FLORES', 'numero' => 9, 'colonia' => 'PASCUAL', 'alcaldia' => 'IZTACALCO'],
            ['rfc' => 'RAMC880908MDF', 'nombre' => 'CLAUDIA', 'apellido_p' => 'RAMIREZ', 'apellido_m' => 'CASTILLO', 'puesto' => 'RECEPCIONISTA', 'turno' => 'VESPERTINO', 'descansos' => 'MARTES,DOMINGO', 'sexo' => 'FEMENINO', 'fecha_nac' => '1988-09-08', 'tel_personal' => 5567891234, 'calle' => 'DIVISIÓN DEL NORTE', 'numero' => 140, 'colonia' => 'PORTALES', 'alcaldia' => 'BENITO JUÁREZ'],
            ['rfc' => 'ORTA930505MDF', 'nombre' => 'TERESA', 'apellido_p' => 'ORTEGA', 'apellido_m' => 'AGUILAR', 'puesto' => 'LIMPIEZA', 'turno' => 'VESPERTINO', 'descansos' => 'SÁBADO, MIÉRCOLES', 'sexo' => 'FEMENINO', 'fecha_nac' => '1993-05-05', 'tel_personal' => 5589123456, 'calle' => 'ZARAGOZA', 'numero' => 180, 'colonia' => 'MOCTEZUMA', 'alcaldia' => 'VENUSTIANO CARRANZA'],
            ['rfc' => 'CRUZ930409HDF', 'nombre' => 'DAVID', 'apellido_p' => 'CRUZ', 'apellido_m' => 'MARTÍNEZ', 'puesto' => 'LIMPIEZA', 'turno' => 'MATUTINO', 'descansos' => 'LUNES,DOMINGO', 'sexo' => 'MASCULINO', 'fecha_nac' => '1993-04-09', 'tel_personal' => 5534567890, 'calle' => 'AV. OCEANÍA', 'numero' => 72, 'colonia' => 'MOCTEZUMA', 'alcaldia' => 'VENUSTIANO CARRANZA'],
        ];
        
        // Agregar timestamps
        foreach($empleados as &$emp) { $emp['created_at'] = now(); $emp['updated_at'] = now(); }
        DB::table('empleados')->insertOrIgnore($empleados);

        // 2. ALUMNOS
        $alumnos = [
            ['rfc' => 'JUAP910101HDF', 'nombre' => 'JUAN', 'apellido_p' => 'PÉREZ', 'apellido_m' => 'ALVAREZ', 'fecha_nac' => '1991-01-01', 'calle' => 'REFORMA', 'numero' => '100', 'colonia' => 'CENTRO', 'alcaldia' => 'CUAUHTÉMOC', 'permiso' => 'SI', 'observaciones' => 'ANSIEDAD GENERALIZADA', 'correo' => 'jperez@hotmail.com'],
            ['rfc' => 'MARG920202MDF', 'nombre' => 'MARÍA', 'apellido_p' => 'GÓMEZ', 'apellido_m' => 'RAMÍREZ', 'fecha_nac' => '1992-02-02', 'calle' => 'INSURGENTES', 'numero' => '200', 'colonia' => 'DEL VALLE', 'alcaldia' => 'BENITO JUÁREZ', 'permiso' => 'SI', 'observaciones' => 'LESIÓN EN BRAZO DERECHO', 'correo' => 'mgomez@gmail.com'],
            ['rfc' => 'LUIC930303HDF', 'nombre' => 'LUIS', 'apellido_p' => 'CANO', 'apellido_m' => 'SANTOS', 'fecha_nac' => '1993-03-03', 'calle' => 'MIGUEL HIDALGO', 'numero' => '35', 'colonia' => 'POLANCO', 'alcaldia' => 'MIGUEL HIDALGO', 'permiso' => 'EN TRÁMITE', 'observaciones' => 'LESIÓN DE RODILLA IZQUIERDA', 'correo' => 'lcano@outlook.com'],
            ['rfc' => 'SAND940404MDF', 'nombre' => 'SANDRA', 'apellido_p' => 'MARTÍNEZ', 'apellido_m' => 'LARA', 'fecha_nac' => '1994-04-04', 'calle' => 'DIVISIÓN DEL NORTE', 'numero' => '80', 'colonia' => 'PORTALES', 'alcaldia' => 'BENITO JUÁREZ', 'permiso' => 'NO', 'observaciones' => 'DIABETES', 'correo' => 'smartinez@yahoo.com'],
            ['rfc' => 'CARF950505HDF', 'nombre' => 'CARLOS', 'apellido_p' => 'FLORES', 'apellido_m' => 'MEJÍA', 'fecha_nac' => '1995-05-05', 'calle' => 'ZARAGOZA', 'numero' => '150', 'colonia' => 'MOCTEZUMA', 'alcaldia' => 'VENUSTIANO CARRANZA', 'permiso' => 'SI', 'observaciones' => 'ANSIEDAD', 'correo' => 'cflores@hotmail.com'],
            ['rfc' => 'ANEL960606MDF', 'nombre' => 'ANA', 'apellido_p' => 'LEÓN', 'apellido_m' => 'SILVA', 'fecha_nac' => '1996-06-06', 'calle' => 'AV. UNIVERSIDAD', 'numero' => '77', 'colonia' => 'COPILCO', 'alcaldia' => 'COYOACÁN', 'permiso' => 'SI', 'observaciones' => 'VÉRTIGO LEVE', 'correo' => 'aleon@gmail.com'],
            ['rfc' => 'JORR970707HDF', 'nombre' => 'JORGE', 'apellido_p' => 'ROJAS', 'apellido_m' => 'REYES', 'fecha_nac' => '1997-07-07', 'calle' => 'PATRIOTISMO', 'numero' => '99', 'colonia' => 'NÁPOLES', 'alcaldia' => 'BENITO JUÁREZ', 'permiso' => 'SI', 'observaciones' => 'HIPERTENSIÓN CONTROLADA', 'correo' => 'jrojas@outlook.com'],
            ['rfc' => 'LUIM980808MDF', 'nombre' => 'LUISA', 'apellido_p' => 'MENDOZA', 'apellido_m' => 'TORRES', 'fecha_nac' => '1998-08-08', 'calle' => 'TLALPAN', 'numero' => '55', 'colonia' => 'LA JOYA', 'alcaldia' => 'TLALPAN', 'permiso' => 'EN TRÁMITE', 'observaciones' => 'VISTA REDUCIDA (USA LENTES)', 'correo' => 'lmendoza@gmail.com'],
            ['rfc' => 'RAFM990909HDF', 'nombre' => 'RAFAEL', 'apellido_p' => 'MORA', 'apellido_m' => 'CASTRO', 'fecha_nac' => '1999-09-09', 'calle' => 'EJE CENTRAL', 'numero' => '120', 'colonia' => 'OBRERA', 'alcaldia' => 'CUAUHTÉMOC', 'permiso' => 'SI', 'observaciones' => NULL, 'correo' => 'rmora@hotmail.com'],
            ['rfc' => 'VERC000101MDF', 'nombre' => 'VERÓNICA', 'apellido_p' => 'CARRILLO', 'apellido_m' => 'NAVARRO', 'fecha_nac' => '2000-01-01', 'calle' => 'CENTENARIO', 'numero' => '67', 'colonia' => 'SAN RAFAEL', 'alcaldia' => 'CUAUHTÉMOC', 'permiso' => 'SI', 'observaciones' => 'EPILEPSIA LEVE (CONTROLADA)', 'correo' => 'vcarrillo@yahoo.com'],
            ['rfc' => 'OSCJ010202HDF', 'nombre' => 'OSCAR', 'apellido_p' => 'JUÁREZ', 'apellido_m' => 'VALDÉS', 'fecha_nac' => '2001-02-02', 'calle' => 'CUITLAHUAC', 'numero' => '45', 'colonia' => 'TACUBA', 'alcaldia' => 'MIGUEL HIDALGO', 'permiso' => 'NO', 'observaciones' => 'DIABETES', 'correo' => 'ojuarez@outlook.com'],
        ];
        
        foreach($alumnos as &$al) { $al['created_at'] = now(); $al['updated_at'] = now(); }
        DB::table('alumnos')->insertOrIgnore($alumnos);

        // 3. PAGOS
        $pagos = [
            ['rfc_cliente' => 'JUAP910101HDF', 'fecha_pago' => '2025-06-01', 'tipo_contratacion' => 'BÁSICO', 'total_pago' => 2000, 'forma_pago' => 'EFECTIVO', 'reembolso' => false],
            ['rfc_cliente' => 'MARG920202MDF', 'fecha_pago' => '2025-06-05', 'tipo_contratacion' => 'PREMIUM', 'total_pago' => 5000, 'forma_pago' => 'TRANSFERENCIA', 'reembolso' => false],
            ['rfc_cliente' => 'LUIC930303HDF', 'fecha_pago' => '2025-06-10', 'tipo_contratacion' => 'INTERMEDIO', 'total_pago' => 3500, 'forma_pago' => 'DEBITO', 'reembolso' => true], // Nota: ENUM corregido DÉBITO -> DEBITO si tu BD lo requiere
            ['rfc_cliente' => 'SAND940404MDF', 'fecha_pago' => '2025-06-12', 'tipo_contratacion' => 'PREMIUM', 'total_pago' => 5000, 'forma_pago' => 'EFECTIVO', 'reembolso' => false],
            ['rfc_cliente' => 'CARF950505HDF', 'fecha_pago' => '2025-06-15', 'tipo_contratacion' => 'BÁSICO', 'total_pago' => 2000, 'forma_pago' => 'TRANSFERENCIA', 'reembolso' => false],
            ['rfc_cliente' => 'ANEL960606MDF', 'fecha_pago' => '2025-06-18', 'tipo_contratacion' => 'INTERMEDIO', 'total_pago' => 3500, 'forma_pago' => 'CRÉDITO', 'reembolso' => true],
            ['rfc_cliente' => 'JORR970707HDF', 'fecha_pago' => '2025-06-20', 'tipo_contratacion' => 'PREMIUM', 'total_pago' => 5000, 'forma_pago' => 'TRANSFERENCIA', 'reembolso' => false],
            ['rfc_cliente' => 'LUIM980808MDF', 'fecha_pago' => '2025-06-22', 'tipo_contratacion' => 'BÁSICO', 'total_pago' => 2000, 'forma_pago' => 'EFECTIVO', 'reembolso' => true],
            ['rfc_cliente' => 'RAFM990909HDF', 'fecha_pago' => '2025-06-25', 'tipo_contratacion' => 'INTERMEDIO', 'total_pago' => 3500, 'forma_pago' => 'CRÉDITO', 'reembolso' => false],
            ['rfc_cliente' => 'VERC000101MDF', 'fecha_pago' => '2025-06-28', 'tipo_contratacion' => 'PREMIUM', 'total_pago' => 5000, 'forma_pago' => 'TRANSFERENCIA', 'reembolso' => false],
            ['rfc_cliente' => 'OSCJ010202HDF', 'fecha_pago' => '2025-06-30', 'tipo_contratacion' => 'BÁSICO', 'total_pago' => 2000, 'forma_pago' => 'EFECTIVO', 'reembolso' => false],
        ];

        foreach($pagos as &$pago) { $pago['created_at'] = now(); $pago['updated_at'] = now(); }
        DB::table('pagos')->insertOrIgnore($pagos);

        // 4. AGENDA
        $agenda = [
            ['rfc_emp' => 'VELM870610HDF', 'fecha' => '2025-06-10', 'hora' => '08:00:00', 'rfc_cliente' => 'JUAP910101HDF', 'fecha_pago' => '2025-06-01', 'actividad' => 'LECCIÓN', 'km_recorridos' => 10, 'notas' => 'Buen avance', 'exam_teo' => NULL, 'exam_prac' => NULL, 'notas_resultado' => NULL],
            ['rfc_emp' => 'VELM870610HDF', 'fecha' => '2025-06-11', 'hora' => '08:00:00', 'rfc_cliente' => 'MARG920202MDF', 'fecha_pago' => '2025-06-05', 'actividad' => 'EXAMEN', 'km_recorridos' => 15, 'notas' => NULL, 'exam_teo' => 85, 'exam_prac' => 90, 'notas_resultado' => 'Aprobado'],
            ['rfc_emp' => 'REYG940420HDF', 'fecha' => '2025-06-12', 'hora' => '09:00:00', 'rfc_cliente' => 'LUIC930303HDF', 'fecha_pago' => '2025-06-10', 'actividad' => 'LECCIÓN', 'km_recorridos' => 12, 'notas' => 'Trabajar curvas', 'exam_teo' => NULL, 'exam_prac' => NULL, 'notas_resultado' => NULL],
            ['rfc_emp' => 'SALM860927MDF', 'fecha' => '2025-06-12', 'hora' => '15:00:00', 'rfc_cliente' => 'SAND940404MDF', 'fecha_pago' => '2025-06-12', 'actividad' => 'EXAMEN', 'km_recorridos' => 8, 'notas' => 'Dolor en brazo', 'exam_teo' => 90, 'exam_prac' => 75, 'notas_resultado' => 'Aprobado'],
            ['rfc_emp' => 'LOZR970708HDF', 'fecha' => '2025-06-13', 'hora' => '12:00:00', 'rfc_cliente' => 'CARF950505HDF', 'fecha_pago' => '2025-06-15', 'actividad' => 'LECCIÓN', 'km_recorridos' => 20, 'notas' => 'Buen ritmo', 'exam_teo' => NULL, 'exam_prac' => NULL, 'notas_resultado' => NULL],
            ['rfc_emp' => 'SALM860927MDF', 'fecha' => '2025-06-11', 'hora' => '11:00:00', 'rfc_cliente' => 'JUAP910101HDF', 'fecha_pago' => '2025-06-01', 'actividad' => 'LECCIÓN', 'km_recorridos' => 5, 'notas' => 'Ataque de ansiedad', 'exam_teo' => NULL, 'exam_prac' => NULL, 'notas_resultado' => NULL],
            ['rfc_emp' => 'REYG940420HDF', 'fecha' => '2025-06-11', 'hora' => '11:00:00', 'rfc_cliente' => 'JUAP910101HDF', 'fecha_pago' => '2025-06-01', 'actividad' => 'LECCIÓN', 'km_recorridos' => 5, 'notas' => 'Ataque de ansiedad', 'exam_teo' => NULL, 'exam_prac' => NULL, 'notas_resultado' => NULL], // NOTA: Este choca en hora con el anterior si no validamos duplicidad de alumno
            ['rfc_emp' => 'LOZR970708HDF', 'fecha' => '2025-06-13', 'hora' => '16:00:00', 'rfc_cliente' => 'CARF950505HDF', 'fecha_pago' => '2025-06-15', 'actividad' => 'LECCIÓN', 'km_recorridos' => 20, 'notas' => 'Buen ritmo', 'exam_teo' => 50, 'exam_prac' => 35, 'notas_resultado' => 'Reprobado'],
            ['rfc_emp' => 'SALM860927MDF', 'fecha' => '2025-06-13', 'hora' => '16:00:00', 'rfc_cliente' => 'RAFM990909HDF', 'fecha_pago' => '2025-06-25', 'actividad' => 'LECCIÓN', 'km_recorridos' => 20, 'notas' => 'Buen ritmo', 'exam_teo' => NULL, 'exam_prac' => NULL, 'notas_resultado' => NULL],
            ['rfc_emp' => 'VELM870610HDF', 'fecha' => '2025-06-11', 'hora' => '11:00:00', 'rfc_cliente' => 'OSCJ010202HDF', 'fecha_pago' => '2025-06-30', 'actividad' => 'LECCIÓN', 'km_recorridos' => 5, 'notas' => 'Buen avance', 'exam_teo' => NULL, 'exam_prac' => NULL, 'notas_resultado' => NULL],
        ];

        foreach($agenda as &$a) { $a['created_at'] = now(); $a['updated_at'] = now(); }
        // Usamos insertOrIgnore para evitar errores por duplicados si corres el seeder varias veces
        DB::table('agenda')->insertOrIgnore($agenda);
    }
}