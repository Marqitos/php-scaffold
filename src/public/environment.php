<?php declare(strict_types = 1);
/**
  * Modo actual de ejecución de la aplicación
  *
  * @author     Marcos Porto Mariño <php@marcospor.to>
  * @copyright  2025, Marcos Porto
  */

use System\EnvStatus;

if (!class_exists('System\EnvStatus', false)) {
    header('Location: /', true, 308); // Permanent Redirect
}

return EnvStatus::MAINTENANCE;
