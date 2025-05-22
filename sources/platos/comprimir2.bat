@echo off
setlocal enabledelayedexpansion

:: Ruta donde están tus imágenes
set carpeta=A:\xampp\htdocs\salcooking\sources\platos

:: Ruta a pngquant
set pngquant=C:\tools\pngquant\pngquant.exe

:: Ir a la carpeta
cd /d %carpeta%

echo Comprimiendo imágenes PNG a partir de ID 101...

for %%f in (id*.png) do (
    set nombre=%%~nf
    set numero=!nombre:~2!
    set archivo=%%f

    REM Comprobar si el número es mayor o igual a 101
    set /a check=numero
    if !check! GEQ 101 (
        echo Procesando !archivo!...
        "%pngquant%" --ext .png --force 80 -- "!archivo!"
    )
)

echo.
echo Listo. Presiona una tecla para salir...
pause
