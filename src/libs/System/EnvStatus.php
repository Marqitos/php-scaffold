<?php declare(strict_types = 1);
/**
  * Indica el modo de ejecución de la aplicación
  *
  * @package    System
  * @author     Marcos Porto Mariño <lib-system@marcospor.to>
  * @copyright  2025, Marcos Porto
  * @since      v0.6
  */

namespace System;

/**
  * Indica el modo de ejecución de la aplicación
  */
enum EnvStatus : string {
    case CONSTRUCTION  = 'construction';
    case DEVELOPMENT   = 'development';
    case MAINTENANCE   = 'maintenance';
    case PRODUCTION    = 'production';
    case TEST          = 'test';
}
