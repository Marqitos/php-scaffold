/**
  * Almacena la información de un token JWT
  *
  */
class JWToken {
  constructor(tokenString) {
    this.tokenString = tokenString;
    let parts = tokenString.split('.');
    if (parts.length > 1) {
      this.payload = JSON.parse(atob(parts[1]));
    } else {
      throw new TokenError("Token no válido");
    }
    this.signed = parts.length == 3;
  }
  exp() {
    if(this.payload.exp) { // Si tiene fijada fecha de caducidad, comprobamos la validez del token
      let date = new Date(this.payload.exp * 1000);
      let now = new Date();
      return date < now;
    }
    return false; // Si no tiene fecha de caducidad, no es expirado
  }
  toString() {
    return this.tokenString;
  }
}
