<h1 align="center">LUGIA — Laravel Unificado para la Gestión e Instrucción Automotriz</h1>   

<p align="center"><a href="#" target="_blank"><img src="public/img/Logo_rectangular_oscuro.png" width="400" alt="Logo"></a></p>

<!-- <p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>-->

## Descripción

**LUGIA** es una plataforma web diseñada para una escuela de manejo. Su objetivo es gestionar de forma eficiente las operaciones administrativas de la escuela de manejo _**START & GO**_.

## Requisitos del Sistema

**Software necesario:**
- Laravel 12
- PHP 8.1 en adelante
- MySQL Workbench 8.0 (O DBeaver en Linux)
- Navegador moderno (Chrome, Firefox, Edge)
- Servidor local (IIS sobre Windows recomendado o Apache en Linux)
- Git + GitHub

**Configuraciones necesarias en `php.ini`:**
```ini
extension=php_gd2.dll
extension=php_mbstring.dll
```
> Estas extensiones son necesarias para la generación de PDFs y el manejo correcto de caracteres especiales.

```ini
extension=mysqli
extension=pdo_mysql
```
> Estas extensiones son necesarias para la compatibilidad con MySQL.

**Material de apoyo**
https://youtu.be/gGcejiDVX5I?si=tGU56udGKA9jyJMU

## Tecnologías Utilizadas  

- Laravel (PHP): Backend, conexión a base de datos, sesiones, controladores.  
- JavaScript (JS): Comportamiento dinámico, validaciones y control de la interfaz.  
- HTML: Estructura y contenido del sistema.  
- CSS + Bootstrap: Diseño visual de la interfaz. 
- MySQL: Gestión de la base de datos.  
- IIS (Internet Information Services): Servidor web sobre Windows.

## Para ingresar al contenido de la plataforma

Está plataforma va dirigido a dos usuarios finales: 

Administrador
```JSON
{
    "user": "admin",
    "password": "admin"
}
```

Recepcionista
```JSON
{
    "user": "recepcionista",
    "password": "recepcionista"
}
```

## Tablas de la Base de Datos

- **empleados**: Información del personal operativo y administrativo.
- **clientes**: Datos personales de personas inscritas para cursos.
- **pagos**: Pagos realizados de personas inscritas para cursos.
- **usuarios**: Para nombres de usuarios y contraseñas.
- **contratacion**: Los paquetes de clases que se ofertan.
- **agenda**: Citas, horarios y clases programadas.

## Funcionalidades Principales

- Registro, inicio de sesión y control de acceso por rol.
- Gestión de empleados: agregar, modificar y eliminar personal.
- Administración de autos: asignar vehículos y controlar disponibilidad.
- Registro y seguimiento de clientes (alumnos).
- Agenda: programación y consulta de horarios para las clases.
- Contrataciones: Paquetes ofertados.
- Generación de estados de cuenta en PDF.
- Generación de gráficas de reportes de clases y exámenes.
- Modo claro/oscuro adaptable a preferencias del usuario.
- Sistema de ayuda.

## Ejecutar

1. Clonar el repositorio
```bash
git clone https://github.com/cesarleroy/start-and-go.git
```
2. Navegar a la carpeta
```bash
cd start-and-go
```
3. Crear una copia de del archivo `.env.example`
```bash
cp .env.example .env
```
> o bien si lo prefieres de forma manual desde el explorador de archivos, solamente renombrandolo a `.env`
4. Editar el archivo nuevo ajustando los parámetros del servidor y bd
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=escuela
DB_USERNAME=root
DB_PASSWORD=<tu_contra>
```
> Crear previamente la bd `escuela`
5. Instalar dependencias
```bash
composer install
```
6. Generar la llave de la aplicación
```bash
php artisan key:generate
```
7. Ejecutar migraciones
```bash
php artisan migrate
```
o si ya las tienes listas



8. Correr la app
```bash
php artisan serve
```

> [!IMPORTANT]
> Tambien puedes ejecutar el script de powershell que ya realice lo anterior (a excepcion de los ajusten en los parámetros del servidor en el `.env`)
> Ejecuta primero la siguiente politíca en una nueva terminal de PowerShell en modo Administrador.

```Powershell
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope Process
```

> Ahora si, ejecuta el script
```Powershell
./jarbis_correte_el_server_en_fa.ps1
```


## Autores

- [@Max](https://github.com/PuesMax)
- [@César](https://github.com/cesarleroy)
- [@Osva](https://github.com/Osvadeb)

## Licencia

Este proyecto es de uso educativo bajo los términos del **MIT License**.


