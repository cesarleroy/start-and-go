<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Sistema de Ayuda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Mensaje de bienvenida --}}
            @if($mostrarBienvenida)
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">¡Bienvenido, {{ htmlspecialchars($usuario->name) }}!</strong>
                <span class="block sm:inline"> Has iniciado sesión correctamente.</span>
            </div>
            @endif

            {{-- Introducción --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-4">¿Cómo usar el sistema?</h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        <strong>Start & Go</strong> es un sistema diseñado para optimizar la operación y administración 
                        de la escuela de manejo con una interfaz intuitiva y funcionalidades robustas que permiten tener 
                        control total sobre los procesos clave del centro educativo, garantizando eficiencia, seguridad 
                        y una mejor experiencia de servicio.
                    </p>
                </div>
            </div>

            {{-- FAQ Administradores --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">
                        Preguntas Frecuentes (Administradores)
                    </h3>
                    
                    <div class="space-y-4">
                        {{-- Pregunta 1 --}}
                        <details class="group">
                            <summary class="flex justify-between items-center font-medium cursor-pointer list-none p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">
                                <span class="text-gray-900 dark:text-gray-100">¿Cómo puedo llevar un control eficiente del personal que labora?</span>
                                <span class="transition group-open:rotate-180">
                                    <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24">
                                        <path d="M6 9l6 6 6-6"></path>
                                    </svg>
                                </span>
                            </summary>
                            <div class="text-gray-600 dark:text-gray-400 mt-3 p-4">
                                Para gestionar correctamente a los empleados de la empresa, es necesario iniciar sesión con un usuario con privilegios de administrador. Una vez dentro del sistema, dirígete al apartado de <strong>"Empleados"</strong> desde el menú principal. Dentro podrás:
                                <ul class="list-disc ml-6 mt-2">
                                    <li>Registrar nuevos empleados</li>
                                    <li>Editar datos existentes</li>
                                    <li>Eliminar empleados que han dejado de laborar</li>
                                </ul>
                            </div>
                        </details>

                        {{-- Pregunta 2 --}}
                        <details class="group">
                            <summary class="flex justify-between items-center font-medium cursor-pointer list-none p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">
                                <span class="text-gray-900 dark:text-gray-100">¿Es posible modificar los registros una vez creados?</span>
                                <span class="transition group-open:rotate-180">
                                    <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24">
                                        <path d="M6 9l6 6 6-6"></path>
                                    </svg>
                                </span>
                            </summary>
                            <div class="text-gray-600 dark:text-gray-400 mt-3 p-4">
                                Sí, es posible realizar modificaciones en todos los registros del sistema. Para hacerlo, debes seleccionar el registro que deseas actualizar, hacer clic en el botón de editar, realizar los cambios necesarios y luego presionar guardar cambios.
                            </div>
                        </details>

                        {{-- Pregunta 3 --}}
                        <details class="group">
                            <summary class="flex justify-between items-center font-medium cursor-pointer list-none p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">
                                <span class="text-gray-900 dark:text-gray-100">¿La interfaz del sistema luce diferente al usarlo en navegadores distintos?</span>
                                <span class="transition group-open:rotate-180">
                                    <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24">
                                        <path d="M6 9l6 6 6-6"></path>
                                    </svg>
                                </span>
                            </summary>
                            <div class="text-gray-600 dark:text-gray-400 mt-3 p-4">
                                El sistema está diseñado para ser responsivo y funcionar correctamente en todo tipo de dispositivos y navegadores. Sin embargo, recomendamos utilizar Google Chrome para garantizar una mejor experiencia de uso.
                            </div>
                        </details>

                        {{-- Pregunta 4 --}}
                        <details class="group">
                            <summary class="flex justify-between items-center font-medium cursor-pointer list-none p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">
                                <span class="text-gray-900 dark:text-gray-100">¿Cómo funciona la búsqueda en las tablas?</span>
                                <span class="transition group-open:rotate-180">
                                    <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24">
                                        <path d="M6 9l6 6 6-6"></path>
                                    </svg>
                                </span>
                            </summary>
                            <div class="text-gray-600 dark:text-gray-400 mt-3 p-4">
                                La búsqueda en las tablas funciona filtrando en tiempo real los datos que coinciden con las palabras ingresadas en el campo de búsqueda.
                            </div>
                        </details>

                        {{-- Pregunta 5 --}}
                        <details class="group">
                            <summary class="flex justify-between items-center font-medium cursor-pointer list-none p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">
                                <span class="text-gray-900 dark:text-gray-100">¿Cómo genero un archivo de los estados de cuenta?</span>
                                <span class="transition group-open:rotate-180">
                                    <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24">
                                        <path d="M6 9l6 6 6-6"></path>
                                    </svg>
                                </span>
                            </summary>
                            <div class="text-gray-600 dark:text-gray-400 mt-3 p-4">
                                Para generar un archivo con los estados de cuenta, debes ingresar a la sección de reportes, seleccionar el mes del que deseas obtener el documento y hacer clic en el botón de generar reporte.
                            </div>
                        </details>
                    </div>
                </div>
            </div>

            {{-- FAQ Recepcionistas --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">
                        Preguntas Frecuentes (Recepcionistas)
                    </h3>
                    
                    <div class="space-y-4">
                        {{-- Pregunta 101 --}}
                        <details class="group">
                            <summary class="flex justify-between items-center font-medium cursor-pointer list-none p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">
                                <span class="text-gray-900 dark:text-gray-100">¿Cómo actualizo el tipo de contratación de un cliente?</span>
                                <span class="transition group-open:rotate-180">
                                    <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24">
                                        <path d="M6 9l6 6 6-6"></path>
                                    </svg>
                                </span>
                            </summary>
                            <div class="text-gray-600 dark:text-gray-400 mt-3 p-4">
                                Para actualizar el tipo de contratación, selecciona la fila del registro correspondiente, haz clic en editar, ingresa la nueva información y guarda los cambios.
                            </div>
                        </details>

                        {{-- Pregunta 102 --}}
                        <details class="group">
                            <summary class="flex justify-between items-center font-medium cursor-pointer list-none p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">
                                <span class="text-gray-900 dark:text-gray-100">¿Qué hacer cuando un alumno no presenta su examen de manejo?</span>
                                <span class="transition group-open:rotate-180">
                                    <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24">
                                        <path d="M6 9l6 6 6-6"></path>
                                    </svg>
                                </span>
                            </summary>
                            <div class="text-gray-600 dark:text-gray-400 mt-3 p-4">
                                Actualiza el registro del cliente indicando que no se presentó al examen. Se recomienda dejar una anotación en el campo de notas para facilitar el seguimiento.
                            </div>
                        </details>
                    </div>
                </div>
            </div>

            {{-- Contacto y Soporte --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-2xl font-bold mb-4 text-center text-gray-900 dark:text-gray-100">
                        📞 Contacto y Soporte
                    </h3>
                    <p class="text-center text-gray-600 dark:text-gray-400 mb-4">
                        ¿Tienes dudas o necesitas ayuda? Nuestro equipo de soporte está disponible para asistirte:
                    </p>
                    
                    <div class="grid md:grid-cols-3 gap-4 text-center">
                        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="text-2xl mb-2">⏰</div>
                            <strong class="text-gray-900 dark:text-gray-100">Horario</strong>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Lunes a Viernes<br>9:00 a.m. - 6:00 p.m.</p>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="text-2xl mb-2">📧</div>
                            <strong class="text-gray-900 dark:text-gray-100">Email</strong>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">
                                <a href="mailto:soporte@startandgo.com" class="text-blue-600 hover:underline">soporte@gmail.com</a>
                            </p>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="text-2xl mb-2">📱</div>
                            <strong class="text-gray-900 dark:text-gray-100">Teléfono</strong>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">
                                <a href="tel:+525512345678" class="text-blue-600 hover:underline">55 1234 5678</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>