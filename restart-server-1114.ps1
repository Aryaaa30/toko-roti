Write-Host "Stopping any running PHP servers..." -ForegroundColor Yellow
Get-Process -Name php -ErrorAction SilentlyContinue | Stop-Process -Force -ErrorAction SilentlyContinue

Write-Host "Starting Laravel server on port 1114..." -ForegroundColor Green
php artisan serve --port=1114