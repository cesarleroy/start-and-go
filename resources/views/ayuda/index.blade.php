@extends('layouts.app')

@section('content')
<div class="container-fluid p-4 min-h-[calc(100vh-80px)]">
    
    <div class="welcome mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Sistema de Ayuda</h2>
        </div>

        {{-- Introducción --}}
        <div class="card shadow border-0 mb-4">
            <div class="card-body p-4">
                <h3 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">¿Cómo usar el sistema?</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    <strong>Start & Go</strong> es un sistema diseñado para optimizar la operación y administración 
                    de la escuela de manejo con una interfaz intuitiva y funcionalidades robustas que permiten tener 
                    control total sobre los procesos clave del centro educativo, garantizando eficiencia, seguridad 
                    y una mejor experiencia de servicio.
                </p>
            </div>
        </div>

        {{-- FAQ Administradores --}}
        <div class="card shadow border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h3 class="text-2xl font-bold mb-0 text-gray-900 dark:text-gray-100">
                    Preguntas Frecuentes (Administradores)
                </h3>
            </div>
            <div class="card-body p-4">
                <div class="accordion" id="accordionAdmin">
                    
                    {{-- Pregunta 1 --}}
                    <div class="accordion-item border rounded mb-2">
                        <h2 class="accordion-header" id="heading1">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#pregunta1" aria-expanded="false" 
                                    aria-controls="pregunta1">
                                ¿Cómo puedo llevar un control eficiente del personal que labora?
                            </button>
                        </h2>
                        <div id="pregunta1" class="accordion-collapse collapse" 
                             aria-labelledby="heading1" data-bs-parent="#accordionAdmin">
                            <div class="accordion-body">
                                Para gestionar correctamente a los empleados de la empresa, es necesario iniciar sesión con un usuario con privilegios de administrador. Una vez dentro del sistema, dirígete al apartado de <strong>"Empleados"</strong> desde el menú principal. Dentro podrás:
                                <ul class="mt-2">
                                    <li>Registrar nuevos empleados</li>
                                    <li>Editar datos existentes</li>
                                    <li>Eliminar empleados que han dejado de laborar</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- Pregunta 2 --}}
                    <div class="accordion-item border rounded mb-2">
                        <h2 class="accordion-header" id="heading2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#pregunta2" aria-expanded="false" 
                                    aria-controls="pregunta2">
                                ¿Es posible modificar los registros una vez creados?
                            </button>
                        </h2>
                        <div id="pregunta2" class="accordion-collapse collapse" 
                             aria-labelledby="heading2" data-bs-parent="#accordionAdmin">
                            <div class="accordion-body">
                                Sí, es posible realizar modificaciones en todos los registros del sistema. Para hacerlo, debes seleccionar el registro que deseas actualizar, hacer clic en el botón de editar (ícono de lápiz amarillo), realizar los cambios necesarios y luego presionar guardar cambios.
                            </div>
                        </div>
                    </div>

                    {{-- Pregunta 3 --}}
                    <div class="accordion-item border rounded mb-2">
                        <h2 class="accordion-header" id="heading3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#pregunta3" aria-expanded="false" 
                                    aria-controls="pregunta3">
                                ¿La interfaz del sistema luce diferente al usarlo en navegadores distintos?
                            </button>
                        </h2>
                        <div id="pregunta3" class="accordion-collapse collapse" 
                             aria-labelledby="heading3" data-bs-parent="#accordionAdmin">
                            <div class="accordion-body">
                                El sistema está diseñado para ser responsivo y funcionar correctamente en todo tipo de dispositivos y navegadores. Sin embargo, recomendamos utilizar Google Chrome para garantizar una mejor experiencia de uso.
                            </div>
                        </div>
                    </div>

                    {{-- Pregunta 4 --}}
                    <div class="accordion-item border rounded mb-2">
                        <h2 class="accordion-header" id="heading4">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#pregunta4" aria-expanded="false" 
                                    aria-controls="pregunta4">
                                ¿Cómo funciona la búsqueda en las tablas?
                            </button>
                        </h2>
                        <div id="pregunta4" class="accordion-collapse collapse" 
                             aria-labelledby="heading4" data-bs-parent="#accordionAdmin">
                            <div class="accordion-body">
                                La búsqueda en las tablas funciona filtrando en tiempo real los datos que coinciden con las palabras ingresadas en el campo de búsqueda ubicado en la parte superior de cada tabla.
                            </div>
                        </div>
                    </div>

                    {{-- Pregunta 5 --}}
                    <div class="accordion-item border rounded mb-2">
                        <h2 class="accordion-header" id="heading5">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#pregunta5" aria-expanded="false" 
                                    aria-controls="pregunta5">
                                ¿Cómo genero un archivo de los estados de cuenta?
                            </button>
                        </h2>
                        <div id="pregunta5" class="accordion-collapse collapse" 
                             aria-labelledby="heading5" data-bs-parent="#accordionAdmin">
                            <div class="accordion-body">
                                Para generar un archivo con los estados de cuenta, debes ingresar a la sección de reportes, seleccionar el mes del que deseas obtener el documento y hacer clic en el botón de generar reporte.
                            </div>
                        </div>
                    </div>

                    {{-- Pregunta 6 --}}
                    <div class="accordion-item border rounded mb-2">
                        <h2 class="accordion-header" id="heading6">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#pregunta6" aria-expanded="false" 
                                    aria-controls="pregunta6">
                                ¿Cómo gestiono los pagos de los alumnos?
                            </button>
                        </h2>
                        <div id="pregunta6" class="accordion-collapse collapse" 
                             aria-labelledby="heading6" data-bs-parent="#accordionAdmin">
                            <div class="accordion-body">
                                Accede al módulo de <strong>"Pagos"</strong> desde el menú principal. Aquí podrás:
                                <ul class="mt-2">
                                    <li>Registrar nuevos pagos de alumnos</li>
                                    <li>Consultar el historial de pagos</li>
                                    <li>Editar información de pagos existentes</li>
                                    <li>Marcar pagos como reembolsados si es necesario</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- Pregunta 7 --}}
                    <div class="accordion-item border rounded mb-2">
                        <h2 class="accordion-header" id="heading7">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#pregunta7" aria-expanded="false" 
                                    aria-controls="pregunta7">
                                ¿Cómo programo las clases y exámenes?
                            </button>
                        </h2>
                        <div id="pregunta7" class="accordion-collapse collapse" 
                             aria-labelledby="heading7" data-bs-parent="#accordionAdmin">
                            <div class="accordion-body">
                                Utiliza el módulo de <strong>"Agenda"</strong> para:
                                <ul class="mt-2">
                                    <li>Crear nuevas citas para lecciones o exámenes</li>
                                    <li>Asignar instructores y alumnos</li>
                                    <li>Registrar resultados de exámenes (teóricos y prácticos)</li>
                                    <li>Llevar control de kilómetros recorridos</li>
                                    <li>Agregar notas importantes sobre cada sesión</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- FAQ Recepcionistas --}}
        <div class="card shadow border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h3 class="text-2xl font-bold mb-0 text-gray-900 dark:text-gray-100">
                    Preguntas Frecuentes (Recepcionistas)
                </h3>
            </div>
            <div class="card-body p-4">
                <div class="accordion" id="accordionRecep">
                    
                    {{-- Pregunta 101 --}}
                    <div class="accordion-item border rounded mb-2">
                        <h2 class="accordion-header" id="heading101">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#pregunta101" aria-expanded="false" 
                                    aria-controls="pregunta101">
                                ¿Cómo actualizo el tipo de contratación de un cliente?
                            </button>
                        </h2>
                        <div id="pregunta101" class="accordion-collapse collapse" 
                             aria-labelledby="heading101" data-bs-parent="#accordionRecep">
                            <div class="accordion-body">
                                Para actualizar el tipo de contratación, ve al módulo de <strong>"Pagos"</strong>, selecciona el registro del pago correspondiente, haz clic en editar (ícono amarillo), modifica el tipo de contratación y guarda los cambios.
                            </div>
                        </div>
                    </div>

                    {{-- Pregunta 102 --}}
                    <div class="accordion-item border rounded mb-2">
                        <h2 class="accordion-header" id="heading102">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#pregunta102" aria-expanded="false" 
                                    aria-controls="pregunta102">
                                ¿Qué hacer cuando un alumno no presenta su examen de manejo?
                            </button>
                        </h2>
                        <div id="pregunta102" class="accordion-collapse collapse" 
                             aria-labelledby="heading102" data-bs-parent="#accordionRecep">
                            <div class="accordion-body">
                                Ve al módulo de <strong>"Agenda"</strong>, busca la cita del examen, edita el registro y deja una anotación en el campo de <strong>"Notas"</strong> indicando que el alumno no se presentó. Esto facilita el seguimiento posterior.
                            </div>
                        </div>
                    </div>

                    {{-- Pregunta 103 --}}
                    <div class="accordion-item border rounded mb-2">
                        <h2 class="accordion-header" id="heading103">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#pregunta103" aria-expanded="false" 
                                    aria-controls="pregunta103">
                                ¿Cómo registro un nuevo alumno?
                            </button>
                        </h2>
                        <div id="pregunta103" class="accordion-collapse collapse" 
                             aria-labelledby="heading103" data-bs-parent="#accordionRecep">
                            <div class="accordion-body">
                                Accede al módulo de <strong>"Alumnos"</strong>, haz clic en el botón "Nuevo Alumno", llena todos los campos requeridos (RFC, nombre completo, dirección, permiso de conducir, correo) y guarda el registro.
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Contacto y Soporte --}}
        <div class="card shadow border-0">
            <div class="card-body p-4">
                <h3 class="text-2xl font-bold mb-4 text-center text-gray-900 dark:text-gray-100">
                    📞 Contacto y Soporte
                </h3>
                <p class="text-center text-gray-600 dark:text-gray-400 mb-4">
                    ¿Tienes dudas o necesitas ayuda? Nuestro equipo de soporte está disponible para asistirte:
                </p>
                
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="text-center p-4 bg-light rounded">
                            <div class="text-4xl mb-3">⏰</div>
                            <h5 class="fw-bold text-gray-900">Horario</h5>
                            <p class="text-gray-600 mb-0">Lunes a Viernes<br>9:00 a.m. - 6:00 p.m.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-4 bg-light rounded">
                            <div class="text-4xl mb-3">📧</div>
                            <h5 class="fw-bold text-gray-900">Email</h5>
                            <p class="mb-0">
                                <a href="mailto:soporte@gmail.com" class="text-primary text-decoration-none">soporte@gmail.com</a>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-4 bg-light rounded">
                            <div class="text-4xl mb-3">📱</div>
                            <h5 class="fw-bold text-gray-900">Teléfono</h5>
                            <p class="mb-0">
                                <a href="tel:+525512345678" class="text-primary text-decoration-none">55 1234 5678</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection