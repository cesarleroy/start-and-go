@extends('layouts.app')

@section('content')
    <div class="relative w-full h-[400px] md:h-[500px]">
        <img src="{{ asset('img/clase1.jpg') }}" 
             alt="Clase de manejo" 
             class="absolute inset-0 w-full h-full object-cover">
        
        <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-black/30 to-transparent"></div>

        <div class="absolute inset-0 flex flex-col justify-center items-end px-10 md:px-20 text-white text-right">
            <h1 class="text-4xl md:text-6xl font-bold mb-4 drop-shadow-lg">Start & Go</h1>
            <p class="text-xl md:text-2xl font-light mb-2 drop-shadow-md">
                Tu camino seguro comienza aquí
            </p>
            <p class="text-base md:text-lg opacity-90 drop-shadow-sm">
                La escuela de manejo que te prepara para la vida.
            </p>
        </div>
    </div>

    <div class="py-12 px-6 md:px-20 text-center bg-white dark:bg-slate-800 transition-colors duration-300">
        <h2 class="text-3xl font-bold text-slate-800 dark:text-white mb-6">¿Quiénes somos?</h2>
        <p class="text-gray-600 dark:text-gray-300 max-w-4xl mx-auto mb-6 leading-relaxed text-lg">
            Somos una escuela de manejo comprometida con tu seguridad y aprendizaje, contamos con instructores certificados, vehículos modernos y programas personalizados para que obtengas tu licencia con confianza.
        </p>
        <p class="text-gray-600 dark:text-gray-300 max-w-4xl mx-auto mb-16 font-medium">
            Nuestro objetivo es ayudarte a convertirte en un conductor responsable y seguro en cualquier situación vial.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            
            <div class="p-6 bg-gray-50 dark:bg-slate-700 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                <div class="text-sky-600 dark:text-sky-400 mb-4">
                    <i class="fas fa-car fa-3x"></i>
                </div>
                <h4 class="text-xl font-bold text-slate-800 dark:text-white mb-3">Misión</h4>
                <p class="text-gray-600 dark:text-gray-300">
                    Formar conductores responsables y seguros mediante enseñanza personalizada, ética y profesionalismo.
                </p>
            </div>

            <div class="p-6 bg-gray-50 dark:bg-slate-700 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                <div class="text-sky-600 dark:text-sky-400 mb-4">
                    <i class="fas fa-road fa-3x"></i>
                </div>
                <h4 class="text-xl font-bold text-slate-800 dark:text-white mb-3">Visión</h4>
                <p class="text-gray-600 dark:text-gray-300">
                    Ser la escuela de manejo líder a nivel regional, reconocida por la excelencia en formación vial y calidad humana.
                </p>
            </div>

            <div class="p-6 bg-gray-50 dark:bg-slate-700 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                <div class="text-sky-600 dark:text-sky-400 mb-4">
                    <i class="fas fa-certificate fa-3x"></i>
                </div>
                <h4 class="text-xl font-bold text-slate-800 dark:text-white mb-3">Valores de la Empresa</h4>
                <ul class="text-left inline-block text-gray-600 dark:text-gray-300 list-disc list-inside">
                    <li>Responsabilidad</li>
                    <li>Compromiso</li>
                    <li>Paciencia</li>
                    <li>Respeto</li>
                    <li>Excelencia</li>
                </ul>
            </div>
        </div>
    </div>
@endsection