
## Movies Manager **[UAT Demo](http://uat-movies.dredward.site)** / **[DEV Demo](http://dev-movies.dredward.site)**

## Status: 
* Frontend: En desarrollo
* Backend: Terminado
* API: Terminado
* Integración continua: Terminado
* Pruebas de integración: Pendiente
* Pruebas unitarias: Pendiente

## Instalación rápida

1. Clonar este repo
2. Correr composer install
3. Crear un archivo de entorno (.env) con las configuraciónes de la su base de datos local y su app key (No hay que agregar el archivo .env al repositorio). Se puede tomar el archivo `.env.example` como base
4. Correr npm install
5. Correr npm run build
6. Correr php artisan build:development:refresh (ejecuta migraciones, seeders, limpia la carpeta storage, crea link simbólico y genera keys de passport)



## Acceso

* Usuario: admin@dredward.site
* Contraseña: 6C91by9zruEwTNsT

## Api

### DEV - Entorno para el testeo en el desarrollo (ejecuta seeders y otras cosas)
Se puede obtener una colección completa con todos los endpoints por medio de los siguientes archivos:
* **Insomnia (JSON)** - **[file](https://github.com/DR-Edward/Movies/blob/master/Importation/dev/Insomnia_2020-08-17.json)**
* Insomnia (HAR) - **[file](https://github.com/DR-Edward/Movies/blob/master/Importation/dev/Insomnia_2020-08-17.har)**
* Postman (JSON) - **[file](https://github.com/DR-Edward/Movies/blob/master/Importation/dev/Movies.postman_collection.json)**

### UAT - User Acceptance Testing (Ejecuta seeders específicos)
Se puede obtener una colección completa con todos los endpoints por medio de los siguientes archivos:
* **Insomnia (JSON)** - **[file](https://github.com/DR-Edward/Movies/blob/master/Importation/uat/Insomnia_2020-08-17.json)**
* Insomnia (HAR) - **[file](https://github.com/DR-Edward/Movies/blob/master/Importation/uat/Insomnia_2020-08-17.har)**
* Postman (JSON) - **[file](https://github.com/DR-Edward/Movies/blob/master/Importation/uat/Movies.postman_collection.json)**
