<?php declare(strict_types = 1);
/**
  * Configura la aplicación
  *
  * @author     Marcos Porto Mariño <php@marcospor.to>
  * @copyright  2025, Marcos Porto
  */

use Kansas\Autoloader;
use Kansas\Environment;
use System\EnvStatus;
use System\Fake\FakeSyncReaderWriter;

// Añadir directorio de librerías de código
set_include_path(
    realpath(__DIR__) . DIRECTORY_SEPARATOR . PATH_SEPARATOR .
    get_include_path()
);

require_once 'Kansas/Environment.php';

$environment    = Environment::getInstance($envStatus);
$configFileSer  = __DIR__ . DIRECTORY_SEPARATOR . $config . '.ser';

// Comprobamos si existe la extensión sync, necesaria para SyncReaderWriter
if (!extension_loaded('sync') &&
    function_exists('dl')) {
    dl('sync');
}

// Intentamos crear un bloqueo de lectura/escritura
if (class_exists('SyncReaderWriter', false)) {
    $lock   = new SyncReaderWriter('config-' . $config, true);
} else {
    require_once 'System/Fake/FakeSyncReaderWriter.php';
    $lock   = new FakeSyncReaderWriter();
}

// Opciones exclusivas en modo desarrollo
if ($environment->getStatus() == EnvStatus::DEVELOPMENT) {
    // Mostramos los errores en la aplicación
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);

    // Eliminamos el caché de configuación
    $lock->writelock();
    @unlink($configFileSer);
    $lock->writeunlock();
}

// Nos aseguramos de usar la zona horaria de España
date_default_timezone_set('Europe/Madrid');

// Registramos un autoloader de archivos en caso necesario
if(!class_exists('Autoloader', false)) {
    require_once "Kansas/Autoloader.php";
    $loader = new Autoloader([
        'fallback_autoloader' => true
    ]);
    $loader->register();
}

// Cargamos la configuración de la aplicación
if (file_exists($configFileSer)) {
    $lock->readlock();
    $options = unserialize(file_get_contents($configFileSer));
    $lock->readunlock();
} else {
    $options = include __DIR__ . DIRECTORY_SEPARATOR . $config . '.php';

    // Cacheamos la configuración en producción
    if ($environment->getStatus() == EnvStatus::PRODUCTION) {
        $lock->writelock();
        file_put_contents($configFileSer, serialize($options));
        $lock->writeunlock();
    }
}
