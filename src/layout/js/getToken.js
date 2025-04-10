/**
  * Busca si hay un token JWT, y lo valida
  *
  * @returns Cadena del token, o undefined
  */
function getToken() {
  // Buscamos en las cookies
  let token = document.cookie.replace(
    /(?:(?:^|.*;\s*)token\s*\=\s*([^;]*).*$)|^.*$/,
    "$1",
  );

  if (token == undefined ||
      token == '') { // No se ha encontrado el token en las cookies
    // Buscamos en local storage
    token = sessionStorage.getItem('token') ?? localStorage.getItem('token');
  }

  if (token != undefined) {
    try {
      token = new JWToken(token);
    } catch (error) {
      console.error(error);
      let ru = logout();
      throw new TokenError("Token no válido", ru);
    }
    if(token.exp()) { // El token ha expirado
      let ru = logout();
      throw new TokenExpiredError("Token expirado", ru);
    }
  }

  return token;
}
