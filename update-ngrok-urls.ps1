# PowerShell script to update URLs with ngrok URLs

# Auto-detect the current directory
$scriptDir = Split-Path -Parent $MyInvocation.MyCommand.Path
$projectName = Split-Path -Leaf $scriptDir

# Configuration
$vitePort = 5173
$xamppPort = 80
$localViteUrl = "http://localhost:$vitePort"
$localXamppUrl = "http://localhost/$projectName"

# Function to start ngrok and get the public URL
function Start-Ngrok {
    param (
        [int]$port
    )
    
    Write-Host "Starting ngrok for port $port..."
    $process = Start-Process -FilePath "ngrok" -ArgumentList "http", "$port" -PassThru -WindowStyle Hidden
    
    # Wait for ngrok to start
    Start-Sleep -Seconds 3
    
    # Get the ngrok URL from the API
    $ngrokApi = Invoke-RestMethod -Uri "http://localhost:4040/api/tunnels"
    $publicUrl = ($ngrokApi.tunnels | Where-Object { $_.proto -eq "https" }).public_url
    
    if (-not $publicUrl) {
        Write-Host "Error: Could not get ngrok URL for port $port"
        exit 1
    }
    
    return @{
        Process = $process
        Url = $publicUrl
    }
}

# Function to find and replace URLs in files
function Replace-Urls {
    param (
        [string]$directory,
        [string]$oldUrl,
        [string]$newUrl,
        [string[]]$fileExtensions = @(".html", ".js", ".jsx", ".ts", ".tsx", ".php", ".css")
    )
    
    Write-Host "Replacing $oldUrl with $newUrl in $directory..."
    
    foreach ($ext in $fileExtensions) {
        $files = Get-ChildItem -Path $directory -Filter "*$ext" -Recurse -File
        foreach ($file in $files) {
            $content = Get-Content -Path $file.FullName -Raw
            if ($content -match [regex]::Escape($oldUrl)) {
                $newContent = $content -replace [regex]::Escape($oldUrl), $newUrl
                Set-Content -Path $file.FullName -Value $newContent
                Write-Host "Updated $($file.FullName)"
            }
        }
    }
}

# Main script
Write-Host "=== URL Updater for Travel Agency and Chatbot ===" -ForegroundColor Cyan

# Check if ngrok is installed
try {
    $ngrokVersion = ngrok --version
    Write-Host "Found ngrok: $ngrokVersion"
} catch {
    Write-Host "Error: ngrok is not installed or not in PATH. Please install ngrok first." -ForegroundColor Red
    Write-Host "Download from: https://ngrok.com/download" -ForegroundColor Yellow
    exit 1
}

# Start ngrok for Vite server
$viteNgrok = Start-Ngrok -port $vitePort
Write-Host "Vite server exposed at: $($viteNgrok.Url)" -ForegroundColor Green

# Start ngrok for XAMPP server
$xamppNgrok = Start-Ngrok -port $xamppPort
Write-Host "XAMPP server exposed at: $($xamppNgrok.Url)/$projectName" -ForegroundColor Green

# Replace URLs in the travel agency website
$travelAgencyPath = $scriptDir
Replace-Urls -directory $travelAgencyPath -oldUrl $localViteUrl -newUrl $viteNgrok.Url
Replace-Urls -directory $travelAgencyPath -oldUrl $localXamppUrl -newUrl "$($xamppNgrok.Url)/$projectName"

# Replace URLs in the chatbot code
$chatbotPath = "$travelAgencyPath\chatbot"
Replace-Urls -directory $chatbotPath -oldUrl $localViteUrl -newUrl $viteNgrok.Url
Replace-Urls -directory $chatbotPath -oldUrl $localXamppUrl -newUrl "$($xamppNgrok.Url)/$projectName"

Write-Host "URL replacement complete!" -ForegroundColor Green
Write-Host "
Important URLs:" -ForegroundColor Cyan
Write-Host "Vite Chatbot: $($viteNgrok.Url)" -ForegroundColor Yellow
Write-Host "Travel Agency: $($xamppNgrok.Url)/$projectName" -ForegroundColor Yellow

Write-Host "
Press Enter to stop ngrok and restore original URLs..."
$null = Read-Host

# Stop ngrok processes
$viteNgrok.Process.Kill()
$xamppNgrok.Process.Kill()

# Restore original URLs
Replace-Urls -directory $travelAgencyPath -oldUrl $viteNgrok.Url -newUrl $localViteUrl
Replace-Urls -directory $travelAgencyPath -oldUrl "$($xamppNgrok.Url)/$projectName" -newUrl $localXamppUrl
Replace-Urls -directory $chatbotPath -oldUrl $viteNgrok.Url -newUrl $localViteUrl
Replace-Urls -directory $chatbotPath -oldUrl "$($xamppNgrok.Url)/$projectName" -newUrl $localXamppUrl

Write-Host "URLs restored to local development settings." -ForegroundColor Green
