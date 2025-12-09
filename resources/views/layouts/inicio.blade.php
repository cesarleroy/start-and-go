<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="flex justify-between items-center px-4 py-3">
        <div class="logo-container w-48 transition-all duration-300">
            <img src="{{ asset('img/Logo_rectangular.jpg') }}" class="block dark:hidden" alt="Logo Claro">
            <img src="{{ asset('img/Logo_rectangular_oscuro.png') }}" class="hidden dark:block" alt="Logo Oscuro">
        </div>

        <button @click="open = ! open" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 p-2 rounded">
            <i class="fas fa-bars text-2xl"></i>
        </button>
    </div>
</nav>

<aside :class="{'translate-x-0': open, '-translate-x-full': ! open}" class="fixed inset-y-0 left-0 w-64 bg-white dark:bg-gray-900 shadow-lg transform transition-transform duration-300 ease-in-out z-50 mt-16">
    <ul class="flex flex-col py-4 space-y-1">
        
        <li>
            <a href="{{ route('inicio') }}" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 {{ request()->routeIs('inicio') ? 'bg-blue-50 border-l-4 border-blue-500' : '' }}">
                <i class=\"fas fa-home w-6 text-center mr-2\"></i> Inicio
            </a>
        </li>

        @if(auth()->user()->esAdmin())
            <li>
                <a href="{{ route('empleados.index') }}" class="flex items-center px-4 py-2 ...">
                    <i class="fas fa-user-tie w-6 text-center mr-2"></i> Empleados
                </a>
            </li>
        @endif

        <li class="mt-auto border-t dark:border-gray-700 pt-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-center px-4 py-2 text-red-600 hover:bg-red-50">
                    <i class="fas fa-sign-out-alt w-6 text-center mr-2"></i> Cerrar Sesión
                </a>
            </form>
        </li>
    </ul>
</aside>