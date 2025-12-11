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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">

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
                <a href="{{ route('empleados.index') }}" class="flex items-center px-4 py-3 text-gray-400 hover:bg-gray-700 hover:text-white rounded-md transition-colors">
                    <i class="fa-solid fa-user-tie w-6 text-center mr-3"></i>
                    Empleados
                </a>
                @endif

                <a href="{{ route('alumnos.index') }}" class="flex items-center px-4 py-3 text-gray-400 hover:bg-gray-700 hover:text-white rounded-md transition-colors">
                    <i class="fas fa-users w-6 text-center mr-3"></i>
                    Alumnos
                </a>

                <a href="{{ route('pagos.index') }}" class="flex items-center px-4 py-3 text-gray-400 hover:bg-gray-700 hover:text-white rounded-md transition-colors">
                    <i class="fas fa-money-bill-wave w-6 text-center mr-3"></i>
                    Pagos
                </a>

                <a href="{{ route('agenda.index') }}" class="flex items-center px-4 py-3 text-gray-400 hover:bg-gray-700 hover:text-white rounded-md transition-colors">
                    <i class="fas fa-calendar-alt w-6 text-center mr-3"></i>
                    Agenda
                </a>

                @if(auth()->user()->esAdmin())
                <a href="{{ route('reportes.index') }}" class="flex items-center px-4 py-3 text-gray-400 hover:bg-gray-700 hover:text-white rounded-md transition-colors">
                    <i class="fas fa-chart-bar w-6 text-center mr-3"></i>
                    Reportes
                </a>
                @endif

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
            
            <header class="flex items-center justify-between px-6 py-4 bg-white dark:bg-red border-b border-gray-200 dark:border-gray-700 transition-colors duration-300">
                
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
                    <a href="/ayuda" class="text-yellow-500 hover:text-yellow-600 text-xl">
                        <i class="fas fa-lightbulb"></i>
                    </a>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 dark:bg-gray-900">
                <div x-show="sidebarOpen && window.innerWidth < 1024" 
                        @click="sidebarOpen = false" 
                        class="fixed inset-0 z-40 bg-black opacity-50 lg:hidden">
                </div>
                
                    @if (session('status') === 'verification-link-sent')
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative m-4">
                            <strong class="font-bold">¡Bienvenido!</strong> Has iniciado sesión correctamente.
                        </div>
                    @endif

                    @yield('content') 
                
                <footer class="bg-slate-900 text-gray-400 text-center py-6 mt-auto">
                    <p>&copy; 2025 Start & Go. Todos los derechos reservados.</p>
                </footer>
          </main>
        </div>
    </div>
  

    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS Bundle (con Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>