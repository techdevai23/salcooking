@echo off
setlocal enabledelayedexpansion

REM Verificar si pngquant está instalado
where pngquant >nul 2>&1
if errorlevel 1 (
    echo ❌ Error: pngquant no está instalado o no está en el PATH
    echo Por favor, instala pngquant desde: https://pngquant.org/
    pause
    exit /b 1
)

REM Crear carpeta para originales si no existe
if not exist "original_png" (
    echo 📁 Creando carpeta para originales...
    mkdir "original_png"
)

echo 🔄 Procesando imágenes PNG en la carpeta actual...

REM Contador para imágenes procesadas
set "contador=0"

REM Procesar todas las imágenes PNG en la carpeta actual
for %%f in (*.png) do (
    echo ⏳ Procesando: %%f
    
    REM Obtener el nombre del archivo sin extensión
    set "nombre_archivo=%%~nf"
    
    REM Extraer solo los números del nombre
    set "numero="
    for /f "tokens=* delims=0123456789" %%a in ("!nombre_archivo!") do (
        set "numero=!nombre_archivo:%%a=!"
    )
    
    REM Si no hay números, usar un contador
    if "!numero!"=="" (
        set "numero=!contador!"
    )
    
    REM Crear nuevo nombre en minúsculas con el número
    set "nuevo_nombre=imagen!numero!.png"
    
    REM Mover el original a la carpeta de originales con el nuevo nombre
    move "%%f" "original_png\!nuevo_nombre!" >nul
    if !errorlevel! equ 0 (
        echo ✅ Original guardado como: !nuevo_nombre!
        
        REM Comprimir la imagen
        pngquant --quality=80-95 --speed 1 --floyd=0 --ext .png --force "original_png\!nuevo_nombre!"
        if !errorlevel! equ 0 (
            echo 💾 Imagen comprimida creada: !nuevo_nombre!
            set /a "contador+=1"
        ) else (
            echo ❌ Error al comprimir: !nuevo_nombre!
        )
    ) else (
        echo ❌ Error al mover: %%f
    )
)

echo.
if !contador! gtr 0 (
    echo 🎉 ¡Proceso completado!
    echo ✅ Se procesaron !contador! imágenes
    echo 📁 Los originales están en la carpeta 'original_png'
    echo 📁 Las imágenes comprimidas están en la carpeta actual
) else (
    echo ⚠️ No se encontraron imágenes PNG para procesar
)

pause
