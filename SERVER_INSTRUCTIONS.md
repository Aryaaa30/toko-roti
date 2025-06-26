# Server Instructions

This Laravel project is configured to run on port 1114 instead of the default port 8000.

## How to Start the Server

### Option 1: Using the Batch File
Double-click the `start-server-1114.bat` file in the project root directory.

### Option 2: Using PowerShell
Run the PowerShell script by right-clicking `start-server-1114.ps1` and selecting "Run with PowerShell".

### Option 3: Using Artisan Command
Open a terminal in the project root directory and run:
```
php artisan serve:custom
```

### Option 4: Using the Default Artisan Command with Port Specification
Open a terminal in the project root directory and run:
```
php artisan serve --port=1114
```

## Accessing the Application
Once the server is running, you can access the application at:
```
http://localhost:1114
```

## Restarting the Server
If you need to restart the server (kill any running PHP processes and start a new one), use:
```
powershell -ExecutionPolicy Bypass -File restart-server-1114.ps1
```

## Configuration
The application URL is configured in the `.env` file as:
```
APP_URL=http://localhost:1114
```