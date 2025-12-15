@extends('layouts.app')

@section('content')
<div class="container-fluid p-4 min-h-[calc(100vh-80px)]">
    
    <div class="welcome mb-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200">Sistema de Ayuda</h2>
        </div>

        {{-- Introducción --}}
        <div class="bg-[#fff] dark:bg-gray-800 rounded-lg shadow-lg p-6 mb-6 border border-gray-200 dark:border-gray-700">
            <h3 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">¿Cómo usar el sistema?</h3>
            <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                <strong>Start & Go</strong> es un sistema diseñado para optimizar la operación y administración 
                de la escuela de manejo con una interfaz intuitiva y funcionalidades robustas que permiten tener 
                control total sobre los procesos clave del centro educativo, garantizando eficiencia, seguridad 
                y una mejor experiencia de servicio.
            </p>
        </div>

        {{-- FAQ Administradores --}}
        <div class="bg-[#fff] dark:bg-gray-800 rounded-lg shadow-lg mb-6 border border-gray-200 dark:border-gray-700" x-data="{ openQuestion: null }">
            <div class="bg-gradient-to-r from-sky-500 to-sky-600 rounded-t-lg px-6 py-4">
                <h3 class="text-2xl font-bold text-white flex items-center">
                    <i class="fas fa-user-shield mr-3"></i>
                    Preguntas Frecuentes (Administradores)
                </h3>
            </div>
            <div class="p-6">
                
                {{-- Pregunta 1 --}}
                <div class="mb-3 border border-gray-200 dark:border-gray-600 rounded-lg overflow-hidden">
                    <button @click="openQuestion = openQuestion === 1 ? null : 1" 
                            class="w-full text-left px-6 py-4 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors flex justify-between items-center">
                        <span class="font-semibold text-gray-800 dark:text-gray-200">
                            ¿Cómo puedo llevar un control eficiente del personal que labora?
                        </span>
                        <i class="fas fa-chevron-down transition-transform duration-300" 
                           :class="openQuestion === 1 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openQuestion === 1" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 transform translate-y-0"
                         x-transition:leave-end="opacity-0 transform -translate-y-2"
                         class="px-6 py-4 bg-[#fff] dark:bg-gray-800 border-t border-gray-200 dark:border-gray-600">
                        <p class="text-gray-600 dark:text-gray-400 mb-3">
                            Para gestionar correctamente a los empleados de la empresa, es necesario iniciar sesión con un usuario con privilegios de administrador. Una vez dentro del sistema, dirígete al apartado de <strong class="text-sky-600 dark:text-sky-400">"Empleados"</strong> desde el menú principal. Dentro podrás:
                        </p>
                        <ul class="space-y-2 text-gray-600 dark:text-gray-400">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                Registrar nuevos empleados
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                Editar datos existentes
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                Eliminar empleados que han dejado de laborar
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Pregunta 2 --}}
                <div class="mb-3 border border-gray-200 dark:border-gray-600 rounded-lg overflow-hidden">
                    <button @click="openQuestion = openQuestion === 2 ? null : 2" 
                            class="w-full text-left px-6 py-4 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors flex justify-between items-center">
                        <span class="font-semibold text-gray-800 dark:text-gray-200">
                            ¿Es posible modificar los registros una vez creados?
                        </span>
                        <i class="fas fa-chevron-down transition-transform duration-300" 
                           :class="openQuestion === 2 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openQuestion === 2" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         class="px-6 py-4 bg-[#fff] dark:bg-gray-800 border-t border-gray-200 dark:border-gray-600">
                        <p class="text-gray-600 dark:text-gray-400">
                            Sí, es posible realizar modificaciones en todos los registros del sistema. Para hacerlo, debes seleccionar el registro que deseas actualizar, hacer clic en el botón de editar (ícono de lápiz amarillo), realizar los cambios necesarios y luego presionar guardar cambios.
                        </p>
                    </div>
                </div>

                {{-- Pregunta 3 --}}
                <div class="mb-3 border border-gray-200 dark:border-gray-600 rounded-lg overflow-hidden">
                    <button @click="openQuestion = openQuestion === 3 ? null : 3" 
                            class="w-full text-left px-6 py-4 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors flex justify-between items-center">
                        <span class="font-semibold text-gray-800 dark:text-gray-200">
                            ¿La interfaz del sistema luce diferente al usarlo en navegadores distintos?
                        </span>
                        <i class="fas fa-chevron-down transition-transform duration-300" 
                           :class="openQuestion === 3 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openQuestion === 3" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         class="px-6 py-4 bg-[#fff] dark:bg-gray-800 border-t border-gray-200 dark:border-gray-600">
                        <p class="text-gray-600 dark:text-gray-400">
                            El sistema está diseñado para ser responsivo y funcionar correctamente en todo tipo de dispositivos y navegadores. Sin embargo, recomendamos utilizar Google Chrome para garantizar una mejor experiencia de uso.
                        </p>
                    </div>
                </div>

                {{-- Pregunta 4 --}}
                <div class="mb-3 border border-gray-200 dark:border-gray-600 rounded-lg overflow-hidden">
                    <button @click="openQuestion = openQuestion === 4 ? null : 4" 
                            class="w-full text-left px-6 py-4 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors flex justify-between items-center">
                        <span class="font-semibold text-gray-800 dark:text-gray-200">
                            ¿Cómo funciona la búsqueda en las tablas?
                        </span>
                        <i class="fas fa-chevron-down transition-transform duration-300" 
                           :class="openQuestion === 4 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openQuestion === 4" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         class="px-6 py-4 bg-[#fff] dark:bg-gray-800 border-t border-gray-200 dark:border-gray-600">
                        <p class="text-gray-600 dark:text-gray-400">
                            La búsqueda en las tablas funciona filtrando en tiempo real los datos que coinciden con las palabras ingresadas en el campo de búsqueda ubicado en la parte superior de cada tabla.
                        </p>
                    </div>
                </div>

                {{-- Pregunta 5 --}}
                <div class="mb-3 border border-gray-200 dark:border-gray-600 rounded-lg overflow-hidden">
                    <button @click="openQuestion = openQuestion === 5 ? null : 5" 
                            class="w-full text-left px-6 py-4 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors flex justify-between items-center">
                        <span class="font-semibold text-gray-800 dark:text-gray-200">
                            ¿Cómo genero un archivo de los estados de cuenta?
                        </span>
                        <i class="fas fa-chevron-down transition-transform duration-300" 
                           :class="openQuestion === 5 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openQuestion === 5" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         class="px-6 py-4 bg-[#fff] dark:bg-gray-800 border-t border-gray-200 dark:border-gray-600">
                        <p class="text-gray-600 dark:text-gray-400">
                            Para generar un archivo con los estados de cuenta, debes ingresar a la sección de reportes, seleccionar el mes del que deseas obtener el documento y hacer clic en el botón de generar reporte.
                        </p>
                    </div>
                </div>

                {{-- Pregunta 6 --}}
                <div class="mb-3 border border-gray-200 dark:border-gray-600 rounded-lg overflow-hidden">
                    <button @click="openQuestion = openQuestion === 6 ? null : 6" 
                            class="w-full text-left px-6 py-4 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors flex justify-between items-center">
                        <span class="font-semibold text-gray-800 dark:text-gray-200">
                            ¿Cómo gestiono los pagos de los alumnos?
                        </span>
                        <i class="fas fa-chevron-down transition-transform duration-300" 
                           :class="openQuestion === 6 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openQuestion === 6" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         class="px-6 py-4 bg-[#fff] dark:bg-gray-800 border-t border-gray-200 dark:border-gray-600">
                        <p class="text-gray-600 dark:text-gray-400 mb-3">
                            Accede al módulo de <strong class="text-sky-600 dark:text-sky-400">"Pagos"</strong> desde el menú principal. Aquí podrás:
                        </p>
                        <ul class="space-y-2 text-gray-600 dark:text-gray-400">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                Registrar nuevos pagos de alumnos
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                Consultar el historial de pagos
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                Editar información de pagos existentes
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                Marcar pagos como reembolsados si es necesario
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Pregunta 7 --}}
                <div class="mb-3 border border-gray-200 dark:border-gray-600 rounded-lg overflow-hidden">
                    <button @click="openQuestion = openQuestion === 7 ? null : 7" 
                            class="w-full text-left px-6 py-4 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors flex justify-between items-center">
                        <span class="font-semibold text-gray-800 dark:text-gray-200">
                            ¿Cómo programo las clases y exámenes?
                        </span>
                        <i class="fas fa-chevron-down transition-transform duration-300" 
                           :class="openQuestion === 7 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openQuestion === 7" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         class="px-6 py-4 bg-[#fff] dark:bg-gray-800 border-t border-gray-200 dark:border-gray-600">
                        <p class="text-gray-600 dark:text-gray-400 mb-3">
                            Utiliza el módulo de <strong class="text-sky-600 dark:text-sky-400">"Agenda"</strong> para:
                        </p>
                        <ul class="space-y-2 text-gray-600 dark:text-gray-400">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                Crear nuevas citas para lecciones o exámenes
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                Asignar instructores y alumnos
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                Registrar resultados de exámenes (teóricos y prácticos)
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                Llevar control de kilómetros recorridos
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                Agregar notas importantes sobre cada sesión
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

        {{-- FAQ Recepcionistas --}}
        <div class="bg-[#fff] dark:bg-gray-800 rounded-lg shadow-lg mb-6 border border-gray-200 dark:border-gray-700" x-data="{ openQuestionRecep: null }">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-t-lg px-6 py-4">
                <h3 class="text-2xl font-bold text-white flex items-center">
                    <i class="fas fa-user-tag mr-3"></i>
                    Preguntas Frecuentes (Recepcionistas)
                </h3>
            </div>
            <div class="p-6">
                
                {{-- Pregunta 101 --}}
                <div class="mb-3 border border-gray-200 dark:border-gray-600 rounded-lg overflow-hidden">
                    <button @click="openQuestionRecep = openQuestionRecep === 101 ? null : 101" 
                            class="w-full text-left px-6 py-4 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors flex justify-between items-center">
                        <span class="font-semibold text-gray-800 dark:text-gray-200">
                            ¿Cómo actualizo el tipo de contratación de un cliente?
                        </span>
                        <i class="fas fa-chevron-down transition-transform duration-300" 
                           :class="openQuestionRecep === 101 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openQuestionRecep === 101" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         class="px-6 py-4 bg-[#fff] dark:bg-gray-800 border-t border-gray-200 dark:border-gray-600">
                        <p class="text-gray-600 dark:text-gray-400">
                            Para actualizar el tipo de contratación, ve al módulo de <strong class="text-purple-600 dark:text-purple-400">"Pagos"</strong>, selecciona el registro del pago correspondiente, haz clic en editar (ícono amarillo), modifica el tipo de contratación y guarda los cambios.
                        </p>
                    </div>
                </div>

                {{-- Pregunta 102 --}}
                <div class="mb-3 border border-gray-200 dark:border-gray-600 rounded-lg overflow-hidden">
                    <button @click="openQuestionRecep = openQuestionRecep === 102 ? null : 102" 
                            class="w-full text-left px-6 py-4 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors flex justify-between items-center">
                        <span class="font-semibold text-gray-800 dark:text-gray-200">
                            ¿Qué hacer cuando un alumno no presenta su examen de manejo?
                        </span>
                        <i class="fas fa-chevron-down transition-transform duration-300" 
                           :class="openQuestionRecep === 102 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openQuestionRecep === 102" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         class="px-6 py-4 bg-[#fff] dark:bg-gray-800 border-t border-gray-200 dark:border-gray-600">
                        <p class="text-gray-600 dark:text-gray-400">
                            Ve al módulo de <strong class="text-purple-600 dark:text-purple-400">"Agenda"</strong>, busca la cita del examen, edita el registro y deja una anotación en el campo de <strong class="text-purple-600 dark:text-purple-400">"Notas"</strong> indicando que el alumno no se presentó. Esto facilita el seguimiento posterior.
                        </p>
                    </div>
                </div>

                {{-- Pregunta 103 --}}
                <div class="mb-3 border border-gray-200 dark:border-gray-600 rounded-lg overflow-hidden">
                    <button @click="openQuestionRecep = openQuestionRecep === 103 ? null : 103" 
                            class="w-full text-left px-6 py-4 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors flex justify-between items-center">
                        <span class="font-semibold text-gray-800 dark:text-gray-200">
                            ¿Cómo registro un nuevo alumno?
                        </span>
                        <i class="fas fa-chevron-down transition-transform duration-300" 
                           :class="openQuestionRecep === 103 ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="openQuestionRecep === 103" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         class="px-6 py-4 bg-[#fff] dark:bg-gray-800 border-t border-gray-200 dark:border-gray-600">
                        <p class="text-gray-600 dark:text-gray-400">
                            Accede al módulo de <strong class="text-purple-600 dark:text-purple-400">"Alumnos"</strong>, haz clic en el botón "Nuevo Alumno", llena todos los campos requeridos (RFC, nombre completo, dirección, permiso de conducir, correo) y guarda el registro.
                        </p>
                    </div>
                </div>

            </div>
        </div>

        {{-- Contacto y Soporte --}}
        <div class="bg-[#fff] dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700">
            <div class="p-6">
                <h3 class="text-2xl font-bold mb-4 text-center text-gray-900 dark:text-gray-100 flex items-center justify-center">
                    <i class="fas fa-headset text-3xl mr-3 text-sky-500"></i>
                    Contacto y Soporte
                </h3>
                <p class="text-center text-gray-600 dark:text-gray-400 mb-6">
                    ¿Tienes dudas o necesitas ayuda? Nuestro equipo de soporte está disponible para asistirte:
                </p>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="text-center p-6 bg-gradient-to-br from-sky-50 to-sky-100 dark:from-gray-700 dark:to-gray-600 rounded-lg hover:shadow-lg transition-shadow">
                        <div class="text-5xl mb-3">⏰</div>
                        <h5 class="font-bold text-gray-900 dark:text-gray-100 mb-2">Horario</h5>
                        <p class="text-gray-600 dark:text-gray-300">Lunes a Viernes<br>9:00 a.m. - 6:00 p.m.</p>
                    </div>
                    <div class="text-center p-6 bg-gradient-to-br from-purple-50 to-purple-100 dark:from-gray-700 dark:to-gray-600 rounded-lg hover:shadow-lg transition-shadow">
                        <div class="text-5xl mb-3">📧</div>
                        <h5 class="font-bold text-gray-900 dark:text-gray-100 mb-2">Email</h5>
                        <p>
                            <a href="mailto:soporte@gmail.com" class="text-purple-600 dark:text-purple-400 hover:underline">soporte@gmail.com</a>
                        </p>
                    </div>
                    <div class="text-center p-6 bg-gradient-to-br from-green-50 to-green-100 dark:from-gray-700 dark:to-gray-600 rounded-lg hover:shadow-lg transition-shadow">
                        <div class="text-5xl mb-3">📱</div>
                        <h5 class="font-bold text-gray-900 dark:text-gray-100 mb-2">Teléfono</h5>
                        <p>
                            <a href="tel:+525512345678" class="text-green-600 dark:text-green-400 hover:underline">55 1234 5678</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection