<#
.SYNOPSIS
    Script de automatización para Start & Go.
    Instala dependencias, resetea la BD, corre seeders, compila y sirve.
#>

# Configuración para detener el script si ocurre un error
$ErrorActionPreference = "Stop"

Write-Host "==========================================" -ForegroundColor Cyan
Write-Host "      INICIANDO DESPLIEGUE LOCAL          " -ForegroundColor Cyan
Write-Host "==========================================" -ForegroundColor Cyan

# 1. Verificar archivo .env
if (-not (Test-Path ".env")) {
  Write-Host "[1/6] El archivo .env no existe. Creando copia de .env.example..." -ForegroundColor Yellow
  Copy-Item ".env.example" ".env"
  Write-Host "Generando llave de aplicación..."
  php artisan key:generate
}
else {
  Write-Host "[1/6] Archivo .env detectado." -ForegroundColor Green
}

# 2. Instalar Dependencias de Backend (Composer)
Write-Host "`n[2/6] Verificando dependencias de Composer..." -ForegroundColor Yellow
try {
  composer install
}
catch {
  Write-Host "Error al instalar dependencias de Composer." -ForegroundColor Red
  exit
}

# 3. Instalar Dependencias de Frontend (NPM)
Write-Host "`n[3/6] Verificando dependencias de NPM..." -ForegroundColor Yellow
try {
  npm install
}
catch {
  Write-Host "Error al instalar dependencias de NPM." -ForegroundColor Red
  exit
}

# 4. Base de Datos y Seeders
Write-Host "`n[4/6] Ejecutando Migraciones y Seeders..." -ForegroundColor Yellow
Write-Host "      Nota: Se borrarán los datos anteriores." -ForegroundColor DarkGray
try {
  # Usamos el seeder específico que creamos (DatosPruebaSeeder)
  php artisan migrate:fresh;
  php artisan db:seed --class=ContratacionSeeder;
  php artisan db:seed --class=DatosPruebaSeeder;
}
catch {
  Write-Host "Error al ejecutar migraciones." -ForegroundColor Red
  exit
}

# 5. Compilar Assets (Vite)
Write-Host "`n[5/6] Compilando assets para producción..." -ForegroundColor Yellow
try {
  npm run build
}
catch {
  Write-Host "Error al compilar assets." -ForegroundColor Red
  exit
}

# 6. Iniciar Servidor
Write-Host "`n[6/6] Todo listo. Iniciando servidor..." -ForegroundColor Green
Write-Host "      Accede a: http://127.0.0.1:8000" -ForegroundColor Cyan
Write-Host "      (Presiona Ctrl+C para detener)" -ForegroundColor DarkGray
php artisan serve