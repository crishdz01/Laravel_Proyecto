@echo off

echo ============================================
echo  SISTEMA DE GESTION DE CREDITOS
echo  Instalacion del proyecto
echo ============================================

echo.
echo Verificando PHP...
php -v
if errorlevel 1 (
    echo.
    echo ERROR: PHP no esta instalado o no esta agregado al PATH.
    pause
    exit /b
)

echo.
echo Verificando Composer...
composer -V
if errorlevel 1 (
    echo.
    echo ERROR: Composer no esta instalado o no esta agregado al PATH.
    pause
    exit /b
)

echo.
echo Instalando dependencias de Laravel...
call composer install

if errorlevel 1 (
    echo.
    echo ERROR: No se pudieron instalar las dependencias.
    pause
    exit /b
)

echo.
echo Verificando archivo .env...

if not exist .env (
    copy .env.example .env
    echo Archivo .env creado.
) else (
    echo El archivo .env ya existe.
)

echo.
echo Generando clave de Laravel...
php artisan key:generate

echo.
echo ============================================
echo  CONFIGURACION DE BASE DE DATOS
echo ============================================
echo.
echo Antes de continuar verifica que:
echo.
echo 1. MySQL este iniciado en XAMPP.
echo 2. Exista una base de datos llamada sistema_creditos.
echo 3. El archivo .env tenga la configuracion correcta:
echo.
echo    DB_CONNECTION=mysql
echo    DB_HOST=127.0.0.1
echo    DB_PORT=3306
echo    DB_DATABASE=sistema_creditos
echo    DB_USERNAME=root
echo    DB_PASSWORD=
echo.
pause

echo.
echo Ejecutando migraciones y creando usuario administrador...
php artisan migrate --seed

if errorlevel 1 (
    echo.
    echo ERROR: Ocurrio un problema al ejecutar las migraciones.
    echo Revisa la configuracion de la base de datos en .env.
    pause
    exit /b
)

echo.
echo Ejecutando pruebas del sistema...
php artisan test

echo.
echo ============================================
echo  INSTALACION COMPLETADA
echo ============================================
echo.
echo Usuario administrador inicial:
echo.
echo Correo: admin@sistema.com
echo Contrasena: 12345678
echo.
echo Para iniciar el sistema ejecuta:
echo.
echo php artisan serve
echo.
echo Luego abre:
echo http://127.0.0.1:8000
echo.
pause