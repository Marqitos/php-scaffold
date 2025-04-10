/**
  * Representa un error en un token
  *
  */
class TokenError extends Error {
  constructor(message = "", url = undefined) {
    super(message, url);
    this.name = "TokenError";
    this.url = url;
  }
}
