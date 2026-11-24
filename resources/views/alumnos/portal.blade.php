@extends('layouts.app')

@section('content')
    <div class="py-8 bg-slate-950 min-h-screen text-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- ENCABEZADO DE BIENVENIDA --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-[#0f2942] border border-slate-700/70 rounded-2xl p-6 shadow-xl">
                <div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-sky-500/20 text-sky-300 border border-sky-400/30 mb-2">
                        Portal del Alumno · Start & Go
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-bold text-white">
                        Hola, {{ $alumno ? $alumno->nombre_completo : auth()->user()->name }}
                    </h1>
                    @if($alumno)
                        <p class="text-sm text-slate-300 mt-1">
                            RFC: <span class="font-mono text-sky-300">{{ $alumno->rfc }}</span> ·
                            Permiso de conducir:
                            <span class="font-semibold {{ $alumno->permiso === 'SI' ? 'text-emerald-400' : 'text-amber-300' }}">
                                {{ $alumno->permiso }}
                            </span>
                        </p>
                    @endif
                </div>

                @if($contratoActivo && $paqueteActual)
                    <div class="bg-slate-900/80 border border-slate-700 rounded-xl px-5 py-3 text-left md:text-right">
                        <p class="text-xs uppercase tracking-wider text-slate-400">Paquete Contratado</p>
                        <p class="text-xl font-bold text-emerald-400">{{ $paqueteActual->tipo_contratacion }}</p>
                        <p class="text-xs text-slate-400">
                            Inscrito el {{ \Carbon\Carbon::parse($contratoActivo->fecha_pago)->format('d/m/Y') }}
                        </p>
                    </div>
                @endif
            </div>

            {{-- 1. ALERTA / INDICADOR DE TIEMPO CONTRATADO (AGOTADO / POR AGOTAR / ACTIVO) --}}
            @php
                $estilosAlerta = match($alertaTiempo['tipo']) {
                    'agotado' => 'bg-red-950/80 border-red-500 text-red-100',
                    'todo_agendado' => 'bg-amber-950/80 border-amber-500 text-amber-100',
                    'por_agotar' => 'bg-orange-950/80 border-orange-500 text-orange-100',
                    'activo' => 'bg-emerald-950/70 border-emerald-500 text-emerald-100',
                    default => 'bg-slate-800 border-slate-600 text-slate-200',
                };
                $iconoAlerta = match($alertaTiempo['tipo']) {
                    'agotado' => '🚨',
                    'todo_agendado' => '📅',
                    'por_agotar' => '⏳',
                    'activo' => '✅',
                    default => 'ℹ️',
                };
            @endphp

            <div class="border-l-4 rounded-xl p-5 shadow-lg flex items-start gap-4 {{ $estilosAlerta }}">
                <span class="text-2xl leading-none mt-0.5">{{ $iconoAlerta }}</span>
                <div class="flex-1">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <h2 class="text-lg font-bold">{{ $alertaTiempo['titulo'] }}</h2>
                        @if($progreso && $progreso['horas_contratadas'] > 0)
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-black/30">
                                {{ $progreso['horas_restantes_por_tomar'] === 0 ? '0 HORAS DISPONIBLES (AGOTADO)' : $progreso['horas_restantes_por_tomar'] . ' HRS RESTANTES POR TOMAR' }}
                            </span>
                        @endif
                    </div>
                    <p class="text-sm mt-1 opacity-90">{{ $alertaTiempo['mensaje'] }}</p>
                </div>
            </div>

            {{-- 2. PROGRESO DEL ALUMNO (CUÁNTO LLEVA Y CUÁNTO LE FALTA) --}}
            @if($progreso && $contratoActivo)
                <div class="bg-[#0f2942] border border-slate-700/70 rounded-2xl p-6 shadow-xl space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                        <div>
                            <h2 class="text-xl font-bold text-white">Progreso de tu Capacitación</h2>
                            <p class="text-sm text-slate-300">Desglose de horas completadas, sesiones agendadas y saldo pendiente</p>
                        </div>
                        <span class="text-2xl font-extrabold text-emerald-400">
                            {{ $progreso['porcentaje_completado'] }}% completado
                        </span>
                    </div>

                    {{-- Barra de progreso segmentada --}}
                    <div>
                        <div class="w-full h-5 bg-slate-800 rounded-full overflow-hidden flex border border-slate-700">
                            <div class="bg-emerald-500 h-full transition-all duration-500"
                                 style="width: {{ $progreso['porcentaje_completado'] }}%"
                                 title="Horas completadas: {{ $progreso['horas_tomadas'] }}"></div>
                            <div class="bg-sky-500 h-full transition-all duration-500"
                                 style="width: {{ $progreso['porcentaje_agendado'] }}%"
                                 title="Horas ya agendadas próximas: {{ $progreso['horas_agendadas_futuras'] }}"></div>
                        </div>
                        <div class="flex flex-wrap gap-5 mt-2.5 text-xs text-slate-300">
                            <span class="inline-flex items-center gap-1.5">
                                <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                                Completadas: <strong>{{ $progreso['horas_tomadas'] }} hrs</strong>
                            </span>
                            <span class="inline-flex items-center gap-1.5">
                                <span class="w-3 h-3 rounded-full bg-sky-500"></span>
                                Agendadas próximas: <strong>{{ $progreso['horas_agendadas_futuras'] }} hrs</strong>
                            </span>
                            <span class="inline-flex items-center gap-1.5">
                                <span class="w-3 h-3 rounded-full bg-slate-700 border border-slate-500"></span>
                                Sin agendar: <strong>{{ $progreso['horas_sin_agendar'] }} hrs</strong>
                            </span>
                        </div>
                    </div>

                    {{-- Tarjetas métricas KPI --}}
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-slate-900/80 border border-slate-700/80 rounded-xl p-4">
                            <p class="text-xs text-slate-400 uppercase">Horas Completadas</p>
                            <p class="text-2xl font-bold text-emerald-400 mt-1">
                                {{ $progreso['horas_tomadas'] }} <span class="text-sm font-normal text-slate-400">/ {{ $progreso['horas_contratadas'] }} hrs</span>
                            </p>
                        </div>

                        <div class="bg-slate-900/80 border border-slate-700/80 rounded-xl p-4">
                            <p class="text-xs text-slate-400 uppercase">Horas que te Faltan</p>
                            <p class="text-2xl font-bold {{ $progreso['horas_restantes_por_tomar'] > 0 ? 'text-sky-400' : 'text-red-400' }} mt-1">
                                {{ $progreso['horas_restantes_por_tomar'] }} hrs
                            </p>
                            <p class="text-xs text-slate-400 mt-0.5">
                                ({{ $progreso['horas_sin_agendar'] }} sin fecha asignada)
                            </p>
                        </div>

                        <div class="bg-slate-900/80 border border-slate-700/80 rounded-xl p-4">
                            <p class="text-xs text-slate-400 uppercase">Distancia Recorrida</p>
                            <p class="text-2xl font-bold text-white mt-1">{{ $progreso['km_acumulados'] }} km</p>
                            <p class="text-xs text-slate-400 mt-0.5">En sesiones prácticas</p>
                        </div>

                        <div class="bg-slate-900/80 border border-slate-700/80 rounded-xl p-4">
                            <p class="text-xs text-slate-400 uppercase">Examen Final</p>
                            @if($progreso['ultimo_examen'])
                                <p class="text-2xl font-bold {{ $progreso['aprobo_examen'] ? 'text-emerald-400' : 'text-amber-400' }} mt-1">
                                    {{ $progreso['ultimo_examen']->exam_prac ?? 'Pend.' }}/100
                                </p>
                                <p class="text-xs text-slate-400 mt-0.5">
                                    Teórico: {{ $progreso['ultimo_examen']->exam_teo ?? '-' }} · {{ $progreso['aprobo_examen'] ? 'Aprobado' : 'En proceso' }}
                                </p>
                            @else
                                <p class="text-lg font-semibold text-slate-300 mt-1">Sin presentar</p>
                                <p class="text-xs text-slate-400 mt-0.5">Mínimo aprobatorio: 80</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            {{-- 3. CALENDARIO DE DÍAS AGENDADOS Y DETALLE DE SESIONES --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                {{-- Calendario Visual Mensual --}}
                <div class="lg:col-span-7 bg-[#0f2942] border border-slate-700/70 rounded-2xl p-6 shadow-xl" id="calendario-alumno">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-white">Calendario de Clases y Exámenes</h2>
                        <div class="flex items-center gap-2">
                            <button type="button" id="btn-prev-mes" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-sm font-semibold">◀</button>
                            <span id="titulo-mes" class="text-sm font-bold uppercase tracking-wide min-w-[140px] text-center text-sky-300"></span>
                            <button type="button" id="btn-next-mes" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-sm font-semibold">▶</button>
                        </div>
                    </div>

                    <div class="grid grid-cols-7 gap-1 text-center text-xs font-semibold text-slate-400 mb-2">
                        <div>Dom</div><div>Lun</div><div>Mar</div><div>Mié</div><div>Jue</div><div>Vie</div><div>Sáb</div>
                    </div>
                    <div id="grid-dias" class="grid grid-cols-7 gap-1.5"></div>

                    <div class="flex flex-wrap gap-4 mt-4 pt-4 border-t border-slate-700/70 text-xs text-slate-300">
                        <span class="inline-flex items-center gap-1.5"><span class="w-3 h-3 rounded bg-sky-500"></span> Lección Práctica</span>
                        <span class="inline-flex items-center gap-1.5"><span class="w-3 h-3 rounded bg-amber-500"></span> Examen Final</span>
                        <span class="inline-flex items-center gap-1.5"><span class="w-3 h-3 rounded bg-emerald-600/60 border border-emerald-400"></span> Sesión Completada</span>
                    </div>

                    {{-- Detalle del día seleccionado --}}
                    <div id="detalle-dia-box" class="mt-4 bg-slate-900/90 border border-slate-700 rounded-xl p-4 hidden">
                        <h3 id="detalle-dia-titulo" class="text-sm font-bold text-sky-300 mb-2"></h3>
                        <div id="detalle-dia-contenido" class="space-y-2 text-sm"></div>
                    </div>
                </div>

                {{-- Lista Cronológica de Próximas Citas --}}
                <div class="lg:col-span-5 bg-[#0f2942] border border-slate-700/70 rounded-2xl p-6 shadow-xl flex flex-col justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-white mb-1">Próximos Días Agendados</h2>
                        <p class="text-xs text-slate-400 mb-4">Citas confirmadas en agenda operativa</p>

                        @if($proximasCitas->isEmpty())
                            <div class="bg-slate-900/70 border border-slate-700 rounded-xl p-5 text-center text-sm text-slate-300">
                                No tienes citas futuras agendadas por el momento.
                            </div>
                        @else
                            <div class="space-y-3 max-h-[380px] overflow-y-auto pr-1">
                                @foreach($proximasCitas as $cita)
                                    @php $esExamen = mb_strtoupper($cita->actividad) === 'EXAMEN'; @endphp
                                    <div class="bg-slate-900/90 border {{ $esExamen ? 'border-amber-500/50' : 'border-slate-700' }} rounded-xl p-4">
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm font-bold text-white">
                                                {{ \Carbon\Carbon::parse($cita->fecha)->translatedFormat('l d M, Y') }}
                                            </span>
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold {{ $esExamen ? 'bg-amber-500/20 text-amber-300' : 'bg-sky-500/20 text-sky-300' }}">
                                                {{ $cita->actividad }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-emerald-400 font-semibold mt-1">
                                            ⏰ {{ substr((string) $cita->hora, 0, 5) }} hrs · Instructor: {{ trim($cita->instructor_nombre) ?: 'Por asignar' }}
                                        </p>
                                        @if($cita->notas)
                                            <p class="text-xs text-slate-400 mt-1">Nota: {{ $cita->notas }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    @if($historialCitas->isNotEmpty())
                        <div class="mt-4 pt-4 border-t border-slate-700/70">
                            <p class="text-xs font-semibold text-slate-300 mb-2">Últimas sesiones tomadas ({{ $historialCitas->count() }}):</p>
                            <div class="space-y-1.5 max-h-32 overflow-y-auto text-xs text-slate-400">
                                @foreach($historialCitas->take(5) as $past)
                                    <div class="flex justify-between bg-slate-900/50 px-3 py-1.5 rounded">
                                        <span>{{ \Carbon\Carbon::parse($past->fecha)->format('d/m/Y') }} · {{ $past->actividad }}</span>
                                        <span class="text-slate-200">{{ $past->km_recorridos }} km</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- 4. CATÁLOGO DE PAQUETES Y BENEFICIOS (APARTE DEL COSTO) --}}
            <div class="bg-[#0f2942] border border-slate-700/70 rounded-2xl p-6 shadow-xl">
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-white">Paquetes Disponibles y Beneficios</h2>
                    <p class="text-sm text-slate-300">Conoce las horas incluidas y ventajas de cada plan de manejo además de su inversión</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($paquetes as $paquete)
                        @php
                            $esActual = $paqueteActual && $paqueteActual->id === $paquete->id;
                        @endphp
                        <div class="relative rounded-2xl p-6 flex flex-col justify-between border transition {{ $esActual ? 'bg-slate-900 border-emerald-400 ring-2 ring-emerald-400/30' : 'bg-slate-900/75 border-slate-700 hover:border-sky-400/50' }}">
                            @if($esActual)
                                <span class="absolute -top-3 right-4 px-3 py-0.5 rounded-full text-xs font-bold bg-emerald-500 text-slate-950 shadow">
                                    Tu Paquete Actual
                                </span>
                            @endif

                            <div>
                                <div class="flex items-baseline justify-between gap-2">
                                    <h3 class="text-xl font-bold text-white">{{ $paquete->tipo_contratacion }}</h3>
                                    <span class="text-xs font-semibold px-2.5 py-1 rounded-md bg-sky-500/20 text-sky-300">
                                        {{ $paquete->horas_totales }} hrs prácticas
                                    </span>
                                </div>

                                <div class="mt-3 pb-4 border-b border-slate-800">
                                    <span class="text-3xl font-extrabold text-emerald-400">
                                        ${{ number_format($paquete->precio, 2) }}
                                    </span>
                                    <span class="text-xs text-slate-400">MXN · Pago único</span>
                                </div>

                                <p class="text-xs uppercase tracking-wider text-slate-400 font-semibold mt-4 mb-2.5">
                                    Beneficios incluidos:
                                </p>
                                <ul class="space-y-2.5 text-sm text-slate-200">
                                    @foreach($paquete->lista_beneficios as $beneficio)
                                        <li class="flex items-start gap-2">
                                            <span class="text-emerald-400 font-bold mt-0.5">✓</span>
                                            <span>{{ $beneficio }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="mt-6 pt-4 border-t border-slate-800 text-xs text-slate-400">
                                @if($esActual)
                                    <span class="text-emerald-300 font-semibold">● Activo en tu expediente actual</span>
                                @else
                                    <span>Disponible para contratación o renovación en recepción.</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    {{-- Script ligero para renderizar el calendario mensual interactivo --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const eventos = @json($eventosCalendario);
            const meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

            // Iniciar en el mes de la próxima cita o el mes actual
            const fechaBase = eventos.length > 0 ? new Date(eventos[eventos.length - 1].fecha + 'T00:00:00') : new Date();
            let anioActual = fechaBase.getFullYear();
            let mesActual = fechaBase.getMonth();

            const tituloMes = document.getElementById('titulo-mes');
            const gridDias = document.getElementById('grid-dias');
            const detalleBox = document.getElementById('detalle-dia-box');
            const detalleTitulo = document.getElementById('detalle-dia-titulo');
            const detalleContenido = document.getElementById('detalle-dia-contenido');

            function renderCalendario() {
                tituloMes.textContent = `${meses[mesActual]} ${anioActual}`;
                gridDias.innerHTML = '';

                const primerDia = new Date(anioActual, mesActual, 1).getDay();
                const diasEnMes = new Date(anioActual, mesActual + 1, 0).getDate();

                for (let i = 0; i < primerDia; i++) {
                    gridDias.innerHTML += `<div class="h-11 rounded-lg bg-slate-900/30"></div>`;
                }

                for (let dia = 1; dia <= diasEnMes; dia++) {
                    const fechaStr = `${anioActual}-${String(mesActual + 1).padStart(2, '0')}-${String(dia).padStart(2, '0')}`;
                    const eventosDia = eventos.filter(e => e.fecha === fechaStr);

                    let clases = 'bg-slate-900/70 text-slate-300 border border-slate-800 hover:border-slate-600';
                    let badge = '';

                    if (eventosDia.length > 0) {
                        const tieneExamen = eventosDia.some(e => e.es_examen);
                        const esPasada = eventosDia.every(e => e.pasada);

                        if (tieneExamen) {
                            clases = 'bg-amber-500/25 text-amber-200 border border-amber-400 font-bold cursor-pointer';
                            badge = '<span class="block text-[10px] leading-none mt-0.5">EXAMEN</span>';
                        } else if (esPasada) {
                            clases = 'bg-emerald-600/25 text-emerald-200 border border-emerald-400/70 font-bold cursor-pointer';
                            badge = '<span class="block text-[10px] leading-none mt-0.5">✓ CLASE</span>';
                        } else {
                            clases = 'bg-sky-500/25 text-sky-200 border border-sky-400 font-bold cursor-pointer';
                            badge = '<span class="block text-[10px] leading-none mt-0.5">CLASE</span>';
                        }
                    }

                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = `h-12 rounded-lg flex flex-col items-center justify-center text-xs transition ${clases}`;
                    btn.innerHTML = `<span>${dia}</span>${badge}`;

                    if (eventosDia.length > 0) {
                        btn.addEventListener('click', () => {
                            detalleBox.classList.remove('hidden');
                            detalleTitulo.textContent = `Sesiones del ${dia} de ${meses[mesActual]} de ${anioActual}`;
                            detalleContenido.innerHTML = eventosDia.map(ev => `
                                <div class="p-2.5 rounded-lg bg-slate-800/80 border border-slate-700">
                                    <div class="flex justify-between font-semibold">
                                        <span class="${ev.es_examen ? 'text-amber-300' : 'text-sky-300'}">${ev.actividad} · ${ev.hora} hrs</span>
                                        <span class="text-xs text-slate-400">${ev.pasada ? 'Completada' : 'Programada'}</span>
                                    </div>
                                    <p class="text-xs text-slate-300 mt-1">Instructor: ${ev.instructor}</p>
                                    <p class="text-xs text-slate-400">Notas: ${ev.notas}</p>
                                    ${ev.es_examen && ev.exam_prac !== null ? `<p class="text-xs text-emerald-300 mt-1">Calificación Teórica: ${ev.exam_teo ?? '-'} | Práctica: ${ev.exam_prac}/100</p>` : ''}
                                </div>
                            `).join('');
                        });
                    }

                    gridDias.appendChild(btn);
                }
            }

            document.getElementById('btn-prev-mes').addEventListener('click', () => {
                mesActual--;
                if (mesActual < 0) { mesActual = 11; anioActual--; }
                renderCalendario();
            });

            document.getElementById('btn-next-mes').addEventListener('click', () => {
                mesActual++;
                if (mesActual > 11) { mesActual = 0; anioActual++; }
                renderCalendario();
            });

            renderCalendario();
        });
    </script>
@endsection