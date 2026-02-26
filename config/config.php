<?php
namespace App;

class Config {
    private static $instance = null;
    private $environment;
    private $config = [];
    private $envBasePath;
    
    // Singleton: Evita múltiples instancias
    private function __construct($envBasePath = null) {
        $this->envBasePath = $envBasePath ?? $this->getDefaultEnvPath();
        $this->detectEnvironment();
        $this->loadEnvironment();
        $this->loadConfig();
    }
    
    public static function getInstance($envBasePath = null) {
        if (self::$instance === null) {
            self::$instance = new self($envBasePath);
        }
        return self::$instance;
    }
    
    /**
     * Obtiene la ruta por defecto a los archivos .env
     * Basado en tu estructura específica
     */
    private function getDefaultEnvPath() {
        // Desde config/config.php, necesitamos subir 1 nivel
        $projectRoot = dirname(__DIR__); // SupportTracking / HelpDesk_Tecno/
        
        // Obtener el nombre del proyecto (nombre de la carpeta)
        $projectName = basename($projectRoot); // 'SupportTracking / HelpDesk_Tecno'
        
        // Construir la ruta: ir al directorio hermano 'dotenv'
        $dotenvPath = dirname($projectRoot) . '/dotenv/' . $projectName . '/';
        
        // Verificar si existe, si no, usar estructura dentro del proyecto
        if (!is_dir($dotenvPath)) {
            // Fallback: buscar en el proyecto mismo
            return $projectRoot . '/';
        }
        
        return $dotenvPath;
    }
    
    private function detectEnvironment() {
        // Prioridad 1: Variable de entorno del sistema
        if (($env = getenv('APP_ENV')) !== false) {
            $this->environment = $env;
            return;
        }
        
        // Prioridad 2: Variable de servidor
        if (isset($_SERVER['APP_ENV'])) {
            $this->environment = $_SERVER['APP_ENV'];
            return;
        }
        
        // Prioridad 3: Detección automática
        $this->environment = $this->autoDetectEnvironment();
    }
    
    private function autoDetectEnvironment() {
        // Por nombre de host
        $host = $_SERVER['HTTP_HOST'] ?? gethostname();
        
/*        if (PHP_SAPI === 'cli') {
            // Estamos en línea de comandos
            return $this->detectCliEnvironment();
        }
*/        
        // Detección por dominio
        if (strpos($host, 'localhost') !== false || 
            strpos($host, '127.0.0.1') !== false ||
            strpos($host, '.local') !== false ||
            strpos($host, 'dev.') !== false) {
            return 'dev';
        }
        
        if (strpos($host, 'staging.') !== false ||
            strpos($host, 'test.') !== false ||
            strpos($host, 'qa.') !== false) {
            return 'staging';
        }
        
        // Por defecto, producción
        return 'prod';
    }
/*    
    private function detectCliEnvironment() {
        // En CLI podemos pasar el entorno como argumento
        global $argv;
        
        foreach ($argv as $arg) {
            if (preg_match('/^--env=(\w+)$/', $arg, $matches)) {
                return $matches[1];
            }
        }
        
        // O por variable de entorno
        return getenv('APP_ENV') ?: 'dev';
    }
*/    
    private function loadEnvironment() {
        // Lista de archivos en orden de prioridad
        $files = [
            ".env.{$this->environment}.local", // .env.dev.local
            ".env.{$this->environment}",        // .env.dev
            '.env.local',                       // .env.local
            '.env'                              // .env
        ];
        
        foreach ($files as $file) {
            $filePath = $this->envBasePath . $file;
            
            if (file_exists($filePath)) {
                $dotenv = \Dotenv\Dotenv::createImmutable($this->envBasePath, basename($file));
                $dotenv->safeLoad();
                
                // Validar variables críticas si el archivo tiene contenido
                if (filesize($filePath) > 0) {
                    $dotenv->required(['APP_ENV']);
                    
                    // Validar DB solo si no estamos en testing
                    if ($this->environment !== 'test') {
                        $dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER']);
                    }
                }
            }
        }
    }
    
    private function loadConfig() {
        // Cargar configuración específica por entorno
        // Como no hay carpeta config/ en tu estructura, usamos defaults
        $configFile = dirname(__DIR__) . "/config/{$this->environment}.php";
        
        if (file_exists($configFile)) {
            $this->config = require $configFile;
        } else {
            // Configuración por defecto
            $this->config = [
                'timezone' => 'America/Mexico_City',
                'locale' => 'es_MX',
                'charset' => 'UTF-8',
            ];
        }
        
        // Añadir variables de .env a la configuración
        $this->config['environment'] = $this->environment;
        $this->config['debug'] = ($_ENV['APP_DEBUG'] ?? 'false') === 'true';
    }
    
    public function get($key, $default = null) {
        // Buscar en este orden: $_ENV, $this->config, $default
        return $_ENV[$key] ?? $this->config[$key] ?? $default;
    }
    
    public function getEnvironment() {
        return $this->environment;
    }
    
    public function isProduction() {
        return $this->environment === 'dev';
    }
    
    public function isDevelopment() {
        return $this->environment === 'dev';
    }
    
    public function isStaging() {
        return $this->environment === 'staging';
    }
    
    public function getEnvPath() {
        return $this->envBasePath;
    }
    
    // Prevenir clonación y deserialización
    private function __clone() {}
    public function __wakeup() {
        throw new \Exception("No se puede deserializar un singleton");
    }
}