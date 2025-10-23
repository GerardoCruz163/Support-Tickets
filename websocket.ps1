# Ruta al archivo websocket-server.js
$nodeScript = "C:\inetpub\SupportTracking\websocket\websocket-server.js"

# Verifica si Node.js está en el PATH
if (-not (Get-Command node -ErrorAction SilentlyContinue)) {
    Write-Host "Node.js no está instalado o no está en el PATH."
    exit 1
}

# Ejecutar el script en segundo plano
Start-Process "node" -ArgumentList "`"$nodeScript`"" -WindowStyle Hidden

Write-Host "Servidor WebSocket iniciado en segundo plano..."
