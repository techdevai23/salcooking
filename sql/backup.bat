@echo off
setlocal enabledelayedexpansion

REM Configuración de rutas y variables
set "XAMPP_PATH=A:\xampp"
set "FECHA=%DATE:~6,4%-%DATE:~3,2%-%DATE:~0,2%_%TIME:~0,2%%TIME:~3,2%%TIME:~6,2%"
set "FECHA=%FECHA: =0%"

REM Rutas de destino
set "DEST1=E:\Proyecto-TFG\BD"
set "DEST2=C:\Users\Osso\Documents\cursos-actuales\2-DAW\Proyecto-TFG\BD"
set "LOG_FILE=%DEST1%\backup_log.txt"

REM Crear directorios si no existen
if not exist "%DEST1%" mkdir "%DEST1%"
if not exist "%DEST2%" mkdir "%DEST2%"

REM Iniciar registro de log
echo ======================================== >> "%LOG_FILE%"
echo Iniciando backup - %date% %time% >> "%LOG_FILE%"

REM Backup de la base de datos salcooking
echo Realizando backup de la base de datos salcooking... >> "%LOG_FILE%"
"%XAMPP_PATH%\mysql\bin\mysqldump.exe" -u admin -posso salcooking > "%DEST1%\salcooking_backup_%FECHA%.sql" 2>> "%LOG_FILE%"

if %errorlevel% equ 0 (
    echo Backup de salcooking completado exitosamente >> "%LOG_FILE%"
    copy "%DEST1%\salcooking_backup_%FECHA%.sql" "%DEST2%" >> "%LOG_FILE%" 2>&1
) else (
    echo ERROR: Fallo en el backup de salcooking >> "%LOG_FILE%"
    echo Código de error: %errorlevel% >> "%LOG_FILE%"
)

REM Backup de usuarios y privilegios
echo Realizando backup de usuarios y privilegios... >> "%LOG_FILE%"
"%XAMPP_PATH%\mysql\bin\mysqldump.exe" -u admin -posso mysql user > "%DEST1%\mysql_users_backup_%FECHA%.sql" 2>> "%LOG_FILE%"

if %errorlevel% equ 0 (
    echo Backup de usuarios completado exitosamente >> "%LOG_FILE%"
    copy "%DEST1%\mysql_users_backup_%FECHA%.sql" "%DEST2%" >> "%LOG_FILE%" 2>&1
) else (
    echo ERROR: Fallo en el backup de usuarios >> "%LOG_FILE%"
    echo Código de error: %errorlevel% >> "%LOG_FILE%"
)

REM Comprimir backups
echo Comprimiendo backups... >> "%LOG_FILE%"
powershell Compress-Archive -Path "%DEST1%\salcooking_backup_%FECHA%.sql" -DestinationPath "%DEST1%\salcooking_backup_%FECHA%.zip" -Force
powershell Compress-Archive -Path "%DEST1%\mysql_users_backup_%FECHA%.sql" -DestinationPath "%DEST1%\mysql_users_backup_%FECHA%.zip" -Force

REM Eliminar archivos .sql originales después de comprimir
del "%DEST1%\salcooking_backup_%FECHA%.sql"
del "%DEST1%\mysql_users_backup_%FECHA%.sql"

REM Limpiar backups antiguos (mantener últimos 7)
echo Limpiando backups antiguos... >> "%LOG_FILE%"
for /f "skip=7 delims=" %%F in ('dir /b /o-d "%DEST1%\salcooking_backup_*.zip"') do del "%DEST1%\%%F"
for /f "skip=7 delims=" %%F in ('dir /b /o-d "%DEST1%\mysql_users_backup_*.zip"') do del "%DEST1%\%%F"

echo ======================================== >> "%LOG_FILE%"
echo Backup finalizado - %date% %time% >> "%LOG_FILE%"
echo. >> "%LOG_FILE%"

echo.
echo Backup completado en:
echo   %DEST1%
echo   %DEST2%
echo.
echo Revisa el archivo de log en: %LOG_FILE%
echo.
pause 