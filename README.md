# <img src="https://w7.pngwing.com/pngs/399/620/png-transparent-laravel-hd-logo.png" alt="Laravel Logo" width="40" height="40"/> ANDES SCD - API

## Diego Alexander Jimenez - API- LARAVEL-JWT

## Prueba realizada del 04/02/2025 al 05/02/2025

Bienvenido. Esta es la prueba técnica para validar mis conocimientos y fortalezas en el mundo del Backend utilizando Laravel, demostrando así mi capacidad de arquitectura de código, patrones de diseño, clean code, REST, y demás para el mundo de ANDES SCD.

### Implementaciones realizadas:

- **Autenticación JWT**: Configuración e integración de JWT para proteger las rutas de la API, garantizando que solo usuarios autenticados puedan acceder a las operaciones CRUD.
- **CRUD de Tareas**: Creación del `TaskController` para manejar las operaciones CRUD de tareas, incluyendo la posibilidad de filtrar tareas por titulo,descripción y estado.
- **Relación User-Task**: Establecimiento de la relación uno-a-muchos entre los modelos `User` y `Task`, permitiendo que un usuario pueda tener múltiples tareas.
- **Protección de Rutas**: Implementación de middleware para asegurar que todas las rutas relacionadas con tareas estén protegidas por autenticación JWT.


# Contenido
* Instrucciones para el correcto funcionamiento
* Herramientas de desarrollo utilizadas
* ¿DESEAS PROBAR LA API EN POSTMAN?

## Instalación:
1. **Crear una base de datos PosgreSQL**: Crea una base de datos en tu servidor PosgreSQL donde se almacenarán los datos del proyecto.

2. **Clonar o descargar el proyecto**:
    - Clona el repositorio utilizando Git:
      ```bash
      git clone <URL-del-repositorio>
      ```
    - O descarga el proyecto como un archivo ZIP y extráelo en el directorio de tu servidor web.

3. **Acceder mediante terminal a la carpeta del proyecto**:
    - Navega hasta la carpeta raíz del proyecto:
      ```bash
      cd <nombre-del-proyecto>
      ```

4. **Instalar dependencias**:
    - Ejecuta el siguiente comando para instalar las dependencias del proyecto:
      ```bash
      composer install
      ```

5. **Configurar el archivo de entorno**:
    - Copia el archivo de entorno de ejemplo y renómbralo a `.env`:
      ```bash
      cp .env.example .env
      ```

6. **Generar la clave de la aplicación**:
    - Genera una clave de la aplicación ejecutando:
      ```bash
      php artisan key:generate
      ```

7. **Configurar la base de datos**:
    - Abre el archivo `.env` en un editor de texto y configura los detalles de tu base de datos:
      ```plaintext
      DB_CONNECTION=posgresql
      DB_HOST=127.0.0.1
      DB_PORT=5432
      DB_DATABASE=nombre_de_tu_base_de_datos
      DB_USERNAME=tu_usuario
      DB_PASSWORD=tu_contraseña
      ```

8. **Generar el JWT Secret**:
    - Genera el secreto JWT necesario para la autenticación:
      ```bash
      php artisan jwt:secret
      ```
      
9. **Correr Migraciones del proyecto **:
    - Genera las tablas requeridas para el proyecto:
      ```bash
      php artisan migrate
      ```
10. **Correr seeders del proyecto **:
    - Genera las seeders requeridos para usuarios de prueba:
      ```bash
      php artisan db:seed
      ```

11. **Levantar el servidor**:
    - Inicia el servidor de desarrollo de Laravel con:
      ```bash
      php artisan serve

## HERRAMIENTAS DE DESARROLLO UTILIZADAS
* Laravel Framework v9
* PHP 8.2.4 
* Visual Studio Code
* Postman
* Laragon
* PgAdmin 4 v8
* Git
* GitHub

## Diagrama de la Base de Datos

A continuación se muestra el diagrama de la base de datos que ilustra la estructura y relaciones entre las tablas de la aplicación:

![Diagrama de la Base de Datos](https://github.com/goslip05/Prueba-Andes-Backend/blob/main/public/img/Diagrama_Andes.png)


## ¿DESEAS PROBAR LA API EN POSTMAN?
Si deseas probar la API en Postman, sigue estos pasos:
1. Importa la colección de Postman que se encuentra en el repositorio (si está disponible) o crea manualmente las solicitudes según las rutas de la API.
2. Asegúrate de que el servidor de desarrollo de Laravel esté en ejecución.
3. Utiliza la URL base `http://127.0.0.1:8000/api` para todas las solicitudes API.
4. Realiza una solicitud POST a `/login` con las credenciales de un usuario registrado para obtener el token JWT.
5. Incluye el token en las solicitudes posteriores usando el encabezado `Authorization: Bearer <tu_token_jwt>` para acceder a las rutas protegidas.

## Colección de Postman

Puedes utilizar la siguiente colección de Postman para validar la documentación de la API del proyecto, así como para interactuar con los endpoints utilizados.

<a href="https://documenter.getpostman.com/view/18148117/2sAYX8HLt9" target="_blank">Ver Documentación API</a>