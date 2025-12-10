<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Inicio</title>
    
    <link rel="icon" href="{{ asset('img/icono.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body class="font-sans antialiased h-full bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300">

    <div x-data="{ 
            sidebarOpen: window.innerWidth >= 1024, 
            toggleTheme() {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                }
            }
         }" 
         class="flex h-screen overflow-hidden">

        <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-[#202424] text-white transition-transform duration-300 transform shadow-xl flex flex-col"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            
            <div class="flex items-center justify-center bg-[#202424] shadow-md shrink-0">
                 
            </div>

            <nav class="flex-1 px-2 py-4 space-y-2 overflow-y-auto">
                <a href="{{ route('inicio') }}" 
                   class="flex items-center px-4 py-3 rounded-md transition-colors {{ request()->routeIs('inicio') ? 'bg-sky-700 text-white' : 'text-gray-400 hover:bg-gray-700 hover:text-white' }}">
                    <i class="fas fa-home w-6 text-center mr-3"></i>
                    Inicio
                </a>

                @if(auth()->user()->esAdmin())
                <a href="#" class="flex items-center px-4 py-3 text-gray-400 hover:bg-gray-700 hover:text-white rounded-md transition-colors">
                    <i class="fa-solid fa-user-tie w-6 text-center mr-3"></i>
                    Empleados
                </a>
                @endif

                <a href="{{ route('alumnos.index') }}" class="flex items-center px-4 py-3 text-gray-400 hover:bg-gray-700 hover:text-white rounded-md transition-colors">
                    <i class="fas fa-users w-6 text-center mr-3"></i>
                    Alumnos
                </a>

                <a href="#" class="flex items-center px-4 py-3 text-gray-400 hover:bg-gray-700 hover:text-white rounded-md transition-colors">
                    <i class="fas fa-money-bill-wave w-6 text-center mr-3"></i>
                    Pagos
                </a>

                <a href="#" class="flex items-center px-4 py-3 text-gray-400 hover:bg-gray-700 hover:text-white rounded-md transition-colors">
                    <i class="fas fa-calendar-alt w-6 text-center mr-3"></i>
                    Agenda
                </a>

                <button @click="toggleTheme()" class="w-full flex items-center px-4 py-3 text-gray-400 hover:bg-gray-700 hover:text-yellow-400 rounded-md transition-colors cursor-pointer">
                    <i class="fas fa-adjust w-6 text-center mr-3"></i>
                    Cambiar tema
                </button>

                <form method="POST" action="{{ route('logout') }}" class="mt-8 border-t border-gray-700 pt-4">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-3 text-red-400 hover:bg-red-900/30 hover:text-red-300 rounded-md transition-colors">
                        <i class="fas fa-sign-out-alt w-6 text-center mr-3"></i>
                        Cerrar sesión
                    </button>
                </form>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden relative transition-all duration-300"
             :class="(sidebarOpen && window.innerWidth >= 1024) ? 'lg:ml-64' : ''">
            
            <header class="flex items-center justify-between px-6 py-4 bg-white dark:bg-slate-800 border-b border-gray-200 dark:border-gray-700 transition-colors duration-300">
                
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 dark:text-gray-200 focus:outline-none p-2 rounded-md hover:bg-gray-100 dark:hover:bg-slate-700">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
                
                <div class="flex justify-center">
                    <img src="{{ asset('img/Logo_rectangular.jpg') }}" 
                         alt="Start & Go" 
                         class="h-12 w-auto dark:hidden"> 
                    
                    <img src="{{ asset('img/Logo_rectangular_oscuro.png') }}" 
                         alt="Start & Go Dark" 
                         class="h-12 w-auto hidden dark:block"> 
                </div>

                <div class="flex items-center">
                    <a href="{{ route('alumnos.index') }}" class="text-yellow-500 hover:text-yellow-600 text-xl">
                        <i class="fas fa-lightbulb"></i>
                    </a>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 dark:bg-gray-900">
                <div x-show="sidebarOpen && window.innerWidth < 1024" 
                     @click="sidebarOpen = false" 
                     class="fixed inset-0 z-40 bg-black opacity-50 lg:hidden"
                     >
                </div>
                
                    @if (session('status') === 'verification-link-sent')
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative m-4">
            <strong class="font-bold">¡Bienvenido!</strong> Has iniciado sesión correctamente.
        </div>
    @endif

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
    
    <footer class="bg-slate-900 text-gray-400 text-center py-6 mt-auto">
        <p>&copy; 2025 Start & Go. Todos los derechos reservados.</p>
    </footer>
            </main>
        </div>
    </div>
</body>
</html>