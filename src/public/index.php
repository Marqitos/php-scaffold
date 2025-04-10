<?php declare(strict_types = 1);
/**
  * Procesa todas las solicitudes que no son archivos estáticos
  *
  * @author     Marcos Porto Mariño <php@marcospor.to>
  * @copyright  2025, Marcos Porto
  */

use Kansas\Application;
use System\EnvStatus;

// Establece el entorno de trabajo
require_once __DIR__ . '/../libs/System/EnvStatus.php';
if (file_exists(__DIR__ . '/environment.php')) {
    $envStatus = include __DIR__ . '/environment.php';
} else { // Por omisión, producción
    $envStatus = EnvStatus::PRODUCTION;
}

// En modo mantenimiento se permite cambiar a desarrollo
if ($envStatus == EnvStatus::MAINTENANCE &&
    isset($_GET['dev'])) {
    $envStatus = EnvStatus::DEVELOPMENT;
}
// En modo mantenimiento, montramos la página de mantenimiento
if (file_exists(__DIR__ . '/../maintenance.php') &&
    $envStatus == EnvStatus::MAINTENANCE) {
    require_once __DIR__ . '/../maintenance.php';
    exit(0);
}

// Configuración especifica de la entrada a la aplicación
$config = 'default';
if (file_exists(__DIR__ . '/config')) {
    $config = trim(file_get_contents(__DIR__ . '/config'));
}

// Configurar la aplicación
require_once realpath(__DIR__ . '/../libs/proyectFile.php');
require_once 'Kansas/Application.php';

try {
    // Ejecutar la aplicación
    $app = Application::getInstance($options);
    $app->run();
} catch (Throwable $th) {
    @http_response_code(500);
    // En modo desarrollo, mostramos los mensajes de error
    if ($environment->getStatus() == EnvStatus::DEVELOPMENT) {
        var_dump($th);
    }
    exit($th->getCode());
}
