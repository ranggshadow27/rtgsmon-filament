@echo off
pause
cd /d D:\laragon\www\rtgsmon
:loop
php artisan schedule:run
timeout /t 600 >nul
goto loop
