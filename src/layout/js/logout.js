/**
  * Borra la información del token
  */
function logout() {
  // Eliminamos el token
  document.cookie = 'token=;max-age=-1;path=/';
  // Eliminamos los datos almacenados
  localStorage.clear();
  sessionStorage.clear();
  // Redirecionamos a la página de inicio de sesión
  document.location.href = '/login';
}
