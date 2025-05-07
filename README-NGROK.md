# Ngrok URL Updater for Travel Agency Website

## Overview

This script automatically updates URLs in your travel agency website and chatbot application when using ngrok to expose your local servers to the internet. It handles both the Vite React app (running on port 5173) and the PHP website (running on XAMPP).

## Requirements

- PowerShell (comes pre-installed on Windows)
- [ngrok](https://ngrok.com/download) installed and in your PATH
- XAMPP running your travel agency website
- Vite server running your chatbot application

## How to Use

1. Make sure both your XAMPP server and Vite development server are running:
   - XAMPP serving your travel agency website
   - Vite serving your chatbot on port 5173

2. Open PowerShell and navigate to the travel agency directory:
   ```
   cd path\to\travel-agency
   ```

3. Run the script with execution policy bypass:
   ```
   powershell -ExecutionPolicy Bypass -File .\update-ngrok-urls.ps1
   ```

4. The script will:
   - Start ngrok for both servers
   - Get the randomly generated ngrok URLs
   - Replace all instances of local URLs with ngrok URLs in your codebase
   - Display the public URLs you can use to access your applications

5. When you're done testing, press Enter to:
   - Stop the ngrok processes
   - Restore all original URLs in your codebase

## What the Script Does

- Automatically detects your project folder name
- Starts ngrok for both the Vite server (port 5173) and XAMPP server (port 80)
- Finds and replaces all instances of:
  - `http://localhost:5173` with the ngrok Vite URL
  - `http://localhost/travel-agency` with the ngrok XAMPP URL
- When finished, it restores all original URLs

## Troubleshooting

- If you get a security error, make sure to run with `-ExecutionPolicy Bypass`
- If ngrok fails to start, ensure it's installed and in your PATH
- If URL replacement doesn't work, check that your servers are running on the expected ports

## Notes

- The script is designed to work with the free version of ngrok, which generates random URLs each time
- If you have a paid ngrok account with fixed subdomains, the script will still work correctly
