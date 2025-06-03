@echo off
setlocal enabledelayedexpansion

REM Configuración de rutas y variables
set "XAMPP_PATH=A:\xampp"
set "FECHA=%DATE:~6,4%-%DATE:~3,2%-%DATE:~0,2%_%TIME:~0,2%%TIME:~3,2%%TIME:~6,2%"
set "FECHA=%FECHA: =0%"

REM Rutas de destino
set "DEST1=E:\Proyecto TFG\BD"
set "DEST2=C:\Users\Osso\Documents\cursos actuales\2º DAW\Proyecto TFG"
set "LOG_FILE=%DEST1%\backup_log.txt"

REM Crear directorios si no existen
if not exist "%DEST1%" mkdir "%DEST1%"
if not exist "%DEST2%" mkdir "%DEST2%"

REM Iniciar registro de log
echo ======================================== >> "%LOG_FILE%"
echo Iniciando backup - %date% %time% >> "%LOG_FILE%"

REM Verificar si MySQL está en ejecución
netstat -an | find "3306" > nul
if %errorlevel% neq 0 (
    echo ERROR: MySQL no está en ejecución. Iniciando MySQL... >> "%LOG_FILE%"
    "%XAMPP_PATH%\mysql\bin\mysqld.exe" --console
    timeout /t 5
)

REM Backup de la base de datos salcooking
echo Realizando backup de la base de datos salcooking... >> "%LOG_FILE%"
"%XAMPP_PATH%\mysql\bin\mysqldump.exe" -u root --password= salcooking > "%DEST1%\salcooking_backup_%FECHA%.sql" 2>> "%LOG_FILE%"

if %errorlevel% equ 0 (
    echo Backup de salcooking completado exitosamente >> "%LOG_FILE%"
    copy "%DEST1%\salcooking_backup_%FECHA%.sql" "%DEST2%" >> "%LOG_FILE%" 2>&1
) else (
    echo ERROR: Fallo en el backup de salcooking >> "%LOG_FILE%"
    echo Código de error: %errorlevel% >> "%LOG_FILE%"
    echo Detalles del error: >> "%LOG_FILE%"
    type "%LOG_FILE%" | findstr /i "error" >> "%LOG_FILE%"
)

REM Backup de usuarios y privilegios (solo si el usuario tiene permisos)
echo Realizando backup de usuarios y privilegios... >> "%LOG_FILE%"
"%XAMPP_PATH%\mysql\bin\mysqldump.exe" -u root --password= mysql user > "%DEST1%\mysql_users_backup_%FECHA%.sql" 2>> "%LOG_FILE%"

if %errorlevel% equ 0 (
    echo Backup de usuarios completado exitosamente >> "%LOG_FILE%"
    copy "%DEST1%\mysql_users_backup_%FECHA%.sql" "%DEST2%" >> "%LOG_FILE%" 2>&1
) else (
    echo ERROR: Fallo en el backup de usuarios >> "%LOG_FILE%"
    echo Código de error: %errorlevel% >> "%LOG_FILE%"
    echo Detalles del error: >> "%LOG_FILE%"
    type "%LOG_FILE%" | findstr /i "error" >> "%LOG_FILE%"
)

REM Comprimir backups solo si existen
if exist "%DEST1%\salcooking_backup_%FECHA%.sql" (
    echo Comprimiendo backup de salcooking... >> "%LOG_FILE%"
    powershell Compress-Archive -Path "%DEST1%\salcooking_backup_%FECHA%.sql" -DestinationPath "%DEST1%\salcooking_backup_%FECHA%.zip" -Force
    del "%DEST1%\salcooking_backup_%FECHA%.sql"
)

if exist "%DEST1%\mysql_users_backup_%FECHA%.sql" (
    echo Comprimiendo backup de usuarios... >> "%LOG_FILE%"
    powershell Compress-Archive -Path "%DEST1%\mysql_users_backup_%FECHA%.sql" -DestinationPath "%DEST1%\mysql_users_backup_%FECHA%.zip" -Force
    del "%DEST1%\mysql_users_backup_%FECHA%.sql"
)

REM Limpiar backups antiguos (mantener últimos 7)
echo Limpiando backups antiguos... >> "%LOG_FILE%"
for /f "skip=7 delims=" %%F in ('dir /b /o-d "%DEST1%\salcooking_backup_*.zip" 2^>nul') do del "%DEST1%\%%F"
for /f "skip=7 delims=" %%F in ('dir /b /o-d "%DEST1%\mysql_users_backup_*.zip" 2^>nul') do del "%DEST1%\%%F"

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