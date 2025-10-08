@echo off
cd /d D:\Laravel_Project\Laravel_with_Excel\laravel_excel
:: start php artisan serve in background
start "" /min cmd /c "php artisan serve"

:: start npm run dev in background
start "" /min cmd /c "npm run dev"