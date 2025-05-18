@echo off
setlocal enabledelayedexpansion

REM Rutas
set PNGQUANT=pngquant.exe

REM Crear carpeta para originales si no existe
if not exist original_png (
    mkdir original_png
)

echo 🔄 Moviendo imágenes desde id1.png hasta id100.png...

for %%f in (id*.png) do (
    set "filename=%%~nf"
    set "num=!filename:~2!"
    for /f "tokens=* delims=0" %%n in ("!num!") do (
        set /a test=%%n
        if !test! GEQ 1 if !test! LEQ 100 (
            move "%%f" original_png\ >nul
            echo ✅ Movido: %%f
        )
    )
)

cd original_png || exit /b

echo 🎯 Iniciando compresión con %PNGQUANT%...

if not exist %PNGQUANT% (
    echo ❌ ERROR: No se encuentra pngquant.exe en esta carpeta.
    pause
    exit /b
)

for %%f in (*.png) do (
    echo 🛠️ Procesando: %%f
    %PNGQUANT% --quality=80-95 --speed 1 --floyd=0 --ext -compressed.png --force "%%f"
    if exist "%%~nf-compressed.png" (
        echo 💾 Comprimido: %%~nf-compressed.png
    ) else (
        echo ⚠️ Fallo al comprimir: %%f
    )
)

echo 🔁 Renombrando y devolviendo archivos comprimidos...

for %%f in (*-compressed.png) do (
    set "name=%%~nf"
    set "name=!name:-compressed=!"
    move "%%f" "..\!name!.png" >nul
    echo 📦 Guardado como: !name!.png
)

cd ..
echo 🎉 ¡Completado! Archivos optimizados están aquí. Originales en original_png\

pause
