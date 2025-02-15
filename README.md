# Estructura para un proyecto en PHP

Opciones deseadas del servidor:

* Apache
* PHP 8.*

Características principales:

* PHP no expuesto, para evitar vulnerabilidades, mediante un solo punto de entrada.
* Política de seguridad `Content-Security-Policy` estricta.
* Políticas de cache optimizadas para rendimiento.
* Estilos preconfigurados mediante Tailwind CSS v4.

## PHP

El código php quedará oculto, y todas las solicitudes serán gestionadas por `src/public/index.php`.

El archivo de entrada del proyecto, se sitúa en `scr/libs`.

Todas las librerías de PHP se instalan en la carpeta `scr/libs`, y haciendo coincidir sus `namespace`s, con el nombre de las carpetas.

Todos los datos sensibles se guardan en `src/.env`, y se pueden cargar con la librería `vlucas/phpdotenv`.

### Librerías por defecto

La estructura está diseñada para trabajar con las librerías:

* Kansas
* System
* Psr (PHP Standard Recommendation)
* DovEnt

Y sus dependencias según los plugins habilitados

### Desarrollo

Para poder hacer pruebas en el servidor, si existe el archivo `src/maintenance.php`, este será el mostrado a los usuarios.

Pero si se incluye `?dev`, como query de la consulta, no se mostrará el archivo de mantenimiento.

## CSS

Como framework para gestionar los estilos, está instalado Tailwind CSS v4, en su opción Tailwind CLI.

Se ha usado para su instalación: node v22.14.0 (LTS)

Puedes añadir tus propios estilos en `src/input.css`

### Tailwind CSS

Para le gestión de estilos está instalado Tailwind CSS v4, en su opción Tailwind CLI.

Para generar el archivo css, durante depuración, o para producción se usan los comandos:

```DOS
npx @tailwindcss/cli -i ./src/input.css -o ./src/public/css/style.css --watch
npx @tailwindcss/cli -i ./src/input.css -o ./src/public/css/style.css
```

Respectivamente.

Los cuales exponen la hoja de estilos en `/css/style.css`.
