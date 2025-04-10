<?php declare(strict_types = 1);
/**
  * Funciones en javacript para el manejo de tokens, e información de usuario
  *
  * @author     Marcos Porto Mariño <php@marcospor.to>
  * @copyright  2025, Marcos Porto
  * @since      v0.1
  */

namespace Oversea\Layout;

use Kansas\Layout\Javascript;
use System\Collections\KeyNotFoundException;
use function file_get_contents;
use function is_callable;

require_once 'Kansas/Layout/Javascript.php';

class Token extends Javascript {

  public const JS_GET_TOKEN = 'getToken';
  public const JS_LOGOUT = 'logout';
  public const JS_JWT = 'JWToken';
  public const JS_TOKEN_ERROR = 'TokenError';
  public const JS_TOKEN_EXPIRED_ERROR = 'TokenExpiredError';

  public function __get(string $name) : array {
    $callable_name = null;
    if(!is_callable([self::class, $name], false, $callable_name)) {
      require_once 'System/Collections/KeyNotFoundException.php';
      throw new KeyNotFoundException($name);
    }
    // Cargamos el script si es necesario
    if (!isset($this->scripts[$callable_name])) {
      $this->loadScript([self::class, $name]);
    }
    
    // Creamos la lista de scripts
    $scripts[$callable_name] = $this->scripts[$callable_name];

    // Comprobamos si tiene dependencias
    $this->resolveDependencies($this->scripts[$callable_name], $scripts);

    return $scripts;
  }

  public static function getToken() : array {
     return [
      self::SCRIPT => file_get_contents(__DIR__ . '/getToken.js'),
      self::DEPENDENCIES  => [
        [self::class, self::JS_JWT],
        [self::class, self::JS_TOKEN_EXPIRED_ERROR],
        [self::class, self::JS_TOKEN_ERROR]
      ]
    ];
  }

  public static function logout() : array {
    return [
      self::SCRIPT => file_get_contents(__DIR__ . '/logout.js')
    ];
  }

  public static function JWToken() : array {
    return [
      self::SCRIPT => file_get_contents(__DIR__ . '/JWToken.js'),
      self::DEPENDENCIES  => [
        [self::class, self::JS_TOKEN_ERROR]
      ]
    ];
  }

  public static function TokenError() : array {
    return [
      self::SCRIPT => file_get_contents(__DIR__ . '/TokenError.js'),
    ];
  }

  public static function TokenExpiredError() : array {
    return [
      self::SCRIPT => file_get_contents(__DIR__ . '/TokenExpiredError.js'),
      self::DEPENDENCIES  => [
        [self::class, self::JS_TOKEN_ERROR]
      ]
    ];
  }

}

global $javascript;
$javascript['token'] = new Token();
