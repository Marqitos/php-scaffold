<?php declare(strict_types = 1);
/**
  * Procesa todas las solicitudes que no son archivos estáticos
  *
  * @author     Marcos Porto Mariño <hola@marcospor.to>
  * @copyright  2025, Marcos Porto
  */

use Kansas\Application;
use Kansas\Environment;

if (file_exists(__DIR__ . '/../maintenance.php') &&
    !isset($_GET('dev'))) {
    require_once __DIR__ . '/../maintenance.php';
    exit;
}

require_once realpath(__DIR__ . '/../libs/proyectFile.php');
require_once 'Kansas/Application.php';

try {
    $app = Application::getInstance($options);
    $app->run();
} catch (Exception $e) {
    if ($environment->getStatus() == Environment::ENV_DEVELOPMENT) {
        var_dump($e);
    }
}
