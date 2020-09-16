## Configuración del proyecto

La configuración corresponde a los procesos del aplicativo, con un proyecto del lado del servidor, carpeta *raiz* y otro del lado del cliente que esta
en el proyecto raiz, en la carpeta *client*. 

### Configuración base de datos

En el archivo *.env* que esta en la raiz, modificar las credenciales para la conexión

#####DB_CONNECTION=mysql
#####DB_HOST=127.0.0.1
#####DB_PORT=3306
#####DB_DATABASE=nombre de la base de datos
#####DB_USERNAME=su usuario
#####DB_PASSWORD=su password

####Correr la aplicación del servidor

*php artisan serve*

####Correr los test

*vendor/bin/phpunit*

####Documentación de las rutas

http://localhost:8000/api/documentation

Se debe generar un token, para poder ver todos los recursos, la ruta que hace esto es la http://localhost:8000/api/v1/login

######Credenciales para obtener el token
######email: *john@gmail.com*
######password: *123456*

##Aplicación del lado del Cliente

######*cd client*
######*ng serve*

######Credenciales como administrador
######*email: john@gmail.com*
######*password: 123456*

######Credenciales como usuario
######*email: simon@gmail.com*
######*password: 123456*
