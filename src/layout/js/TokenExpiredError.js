/**
  * Representa un error de un token expirado
  *
  */
class TokenExpiredError extends TokenError {
  constructor(message = "", url = undefined) {
    super(message, url);
    this.name = "TokenExpiredError";
  }
}
