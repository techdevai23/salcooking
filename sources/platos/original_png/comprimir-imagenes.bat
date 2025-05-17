@echo off
setlocal enabledelayedexpansion

REM Crear carpeta para originales si no existe
if not exist original_png (
    mkdir original_png
)

echo 🔄 Moviendo imágenes desde id1.png hasta id100.png a carpeta original_png...

for %%f in (id*.png) do (
    set "filename=%%~nf"
    set "num=!filename:~2!"
    REM Validar si es un número del 1 al 100
    for /f "tokens=* delims=0" %%n in ("!num!") do (
        set /a test=%%n
        if !test! GEQ 1 if !test! LEQ 100 (
            move "%%f" original_png\ >nul
            echo ✅ Movido: %%f
        )
    )
)

cd original_png

echo 🎯 Comprimiendo imágenes con calidad alta y sin dithering...

for %%f in (*.png) do (
    pngquant --quality=80-95 --speed 1 --floyd=0 --ext -compressed.png --force "%%f"
)

echo 🔁 Renombrando y devolviendo archivos comprimidos...

for %%f in (*-compressed.png) do (
    set "name=%%~nf"
    set "name=!name:-compressed=!"
    move "%%f" "..\!name!.png" >nul
    echo 💾 Guardado como: !name!.png
)

cd ..
echo 🎉 ¡Proceso completado! Archivos comprimidos están en esta carpeta. Originales están en original_png\

pause
