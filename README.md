# DVINE WEB APP

DVINE WEB APP es una aplicación web, capaz de gestionar proyectos de diversas áreas, geolocalizarlos y mostrar relaciones entre ellos. Su misión es servir como una red de proyectos y facilitar la colaboración entre sus participantes.

La aplicación funciona como un gestor de subaplicaciones, cada una con las funcionalidades descritas anteriormente, para así tener redes de locaboración respecto a diversas áreas, por ejemplo: música, educación, congresos, etc.

Actualmente la app corre en el sitio [app.dvine.cl](http://www.app.dvine.cl). Puede visitar la sub aplicación "Conectados Al Sur" [aquí](http://www.app.dvine.cl/en/cas).


## Deploy

A continuación se presenta una breve descripción de los requerimientos para correr este servidor.

### Prerequisitos

La aplicación fue desarrollada en con `php 7.0`, `postgresql 9.3` y utilizando los siguientes módulos de php: `mbstring`, `intl`, `pgsql`, `mcrypt`.

El resto de las dependencias corresponden a paquetes para cakephp, manejados mediante `composer`.

### Database

El [archivo SQL](data/DEPLOY_SQL_FULL.sql) contiene todas las instrucciones SQL necesarias para crear una app en estado **inicial**, es decir, con un usuario administrador, y una sub aplicación con datos por defecto llamada **conectados al sur**.
El usuario administrador es `lionelbrossi@gmail.com`. Para configurar el password, se puede generar mediante la app, usando un *SALT* conveniente.

#### Testing

Para cargar una base de datos de pruebas, existe el archivo [DEPLOY_SQL_FULL.sql](data/DEPLOY_SQL_FULL.sql), en donde se generan sub aplicaciones dummy, usuarios genéricos y proyectos aleatorios. Es importante cargar las seeds para cakephp mencionadas al final del archivo.


### Correo

La aplicación está configurada para enviar correos en caso de creación de cuentas, pérdidas de contraseña y contacto al administrador. Para ello, se debe contar con un servidor de correo electrónico, como el configurado en `config/app.default.php`.


### app.php

Se deben configurar los parámetros de la aplicación en el archivo `config/app.php`, el que puede ser copiado del template `config/app.default.php`. Los campos de interés corresponden a:

- Security.salt.
- EmailTransport.password: password del mail configurado anteriormente.
- Datasources: username, database, password: credenciales para la base de datos.


## TODOs

ver lista de [TODOs](data/TODOs.md)
