@echo off
echo Starting Ngrok URL Updater for Travel Agency Website...
powershell -ExecutionPolicy Bypass -File "%~dp0update-ngrok-urls.ps1"
pause
