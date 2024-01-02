# Busify

## Pasos para levantar el proyecto:

Antes de ejecutar los comandos, asegúrense de tener la terminal en la ruta del proyecto, por ejemplo: `C:\xampp\htdocs\Busify\busify>`.

1. Asegúrate de tener la base de datos "busify" creada en phpMyAdmin.
2. Duplica y cambia el nombre al archivo `.env.example` a: `.env`. Asegúrate de tener correctamente configuradas las credenciales personales. El archivo `.env.example` debe mantener las credenciales por defecto, así que solo duplícalo sin cambiar su nombre.
3. Ejecuta el comando `composer install`.
4. Genera una nueva clave de aplicación con `php artisan key:generate`.
5. Migra las tablas de la base de datos con `php artisan migrate`.
6. Inicia el servidor Laravel con `php artisan serve`. 

En una nueva terminal con la ruta del proyecto (importante correr estos comandos):

- Ejecuta `npm install`.
- Luego, compila los activos con `npm run dev`.

¡Listo! El proyecto estará listo para ser utilizado y podrás acceder a él en el enlace que proporciona el comando `php artisan serve` (por ejemplo, http://127.0.0.1:8000).

### Recomendación para programar:

Para facilitar el desarrollo, ejecuta los siguientes comandos en terminales distintas:

1. Ejecuta `php artisan serve` y utiliza el enlace proporcionado para ver el proyecto (por ejemplo, http://127.0.0.1:8000).
2. Ejecuta `npm run dev`.




