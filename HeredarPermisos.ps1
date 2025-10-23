# HeredarPermisos.ps1
# Script para habilitar permisos heredados en archivos nuevos de document/document_detalle

#rutas de carpetas
$folders = @(
    "C:\inetpub\SupportTracking\public\document_detalle",
    "C:\inetpub\SupportTracking\public\document"
)

# Función para configurar vigilancia en cada carpeta
function Start-Watcher($folderPath) {
    # Asegurar herencia en carpeta base
    icacls $folderPath /inheritance:e /t

    # Crear watcher
    $watcher = New-Object System.IO.FileSystemWatcher
    $watcher.Path = $folderPath
    $watcher.IncludeSubdirectories = $true
    $watcher.EnableRaisingEvents = $true
    $watcher.Filter = "*.*"

    # Acción al detectar archivo nuevo
    Register-ObjectEvent $watcher Created -Action {
        $path = $Event.SourceEventArgs.FullPath
        Start-Sleep -Milliseconds 500
        icacls $path /inheritance:e
        Write-Host "Permisos heredados para: $path"
    }

    Write-Host "Vigilando carpeta: $folderPath"
}

# Iniciar watchers para todas las carpetas
foreach ($folder in $folders) {
    Start-Watcher $folder
}

# Mantener el script corriendo
while ($true) { Start-Sleep 5 }

