# API de Gestion de Productos, Categorias y ordenes

Esta aplicacion me permite gestionar los recursos de un sistema de inventario y ventas: **productos**, **categorias** y **ordenes**. La desarrolle en PHP utilizando el framework Symfony y PDO para la conexion a MySQL (sin emplear Doctrine para el mapeo de entidades). La aplicacion esta organizada en controladores y plantillas Twig, y cuenta con assets (CSS y JavaScript) para mejorar la interfaz de usuario.

> [!WARNING] 
> - Ejecuto el script SQL incluido en la carpeta `database` para crear la base de datos y las tablas necesarias.  

> [!NOTE]
> - La aplicacion utiliza Symfony, por lo que el archivo `public/index.php` actua como front controller. Las rutas definidas en los controladores gestionan las distintas funcionalidades.  

> [!IMPORTANT] 
> - Me aseguro de configurar correctamente las variables de entorno en el archivo `.env` o `.env.local` para la conexion a la base de datos.

---

## Estructura del Proyecto

La estructura del proyecto es la siguiente:

```
/crudApp
├── assets
│   ├── controllers
│   ├── scrips
│   |   └── script.js                             # Script para una transicion
│   └── styles
|       └── style.css                             # Estilos de todo mi programa
├── bin
│   └── ...                                       # Archivos de configuracion de Symfony
├── config
│   └── ...                                       # Archivos de configuracion de Symfony
├── database
│   └── dbCrudApp.sql                             # Codigo SQL para la creacion de la base de datos y tablas
├── public
│   ├── assets
|   |   ├── scrips                                # Scrips compilados para la aplicacion
│   │   └── styles                                # Estilos compilados CSS para la aplicacion
│   └── index.php                                 # Front controller de Symfony
├── src
│   └── Controller
│       ├── BaseController.php                    # Clase base con la conexion PDO
│       ├── DefaultController.php                 # Controlador para la pagina de inicio
│       ├── ProductController.php                 # CRUD para la entidad "productos"
│       ├── CategoryController.php                # CRUD para la entidad "categorias"
│       └── OrderController.php                   # CRUD para la entidad "ordenes"
├── templates
│   ├── base.html.twig                            # Plantilla base que incluye el menu de navegacion
│   ├── index.html.twig                           # Pagina de inicio de la aplicacion
│   ├── product
│   │   ├── index.html.twig                       # Listado de productos
│   │   ├── new.html.twig                         # Formulario para crear un nuevo producto
│   │   ├── edit.html.twig                        # Formulario para editar un producto
│   │   └── show.html.twig                        # Detalle de un producto
│   ├── category
│   │   ├── index.html.twig                       # Listado de categorias
│   │   ├── new.html.twig                         # Formulario para crear una nueva categoria
│   │   ├── edit.html.twig                        # Formulario para editar una categoria
│   │   └── show.html.twig                        # Detalle de una categoria
│   └── order
│       ├── index.html.twig                       # Listado de ordenes
│       ├── new.html.twig                         # Formulario para crear una nueva orden
│       ├── edit.html.twig                        # Formulario para editar una orden
│       └── show.html.twig                        # Detalle de una orden
├── .env                                     # Variables de entorno (configuracion de la base de datos, etc.)
├── composer.json                            # Dependencias del proyecto
└── README.md                                # Este archivo
```

---

## Configuracion del Entorno de Desarrollo

### 1. Instalacion de symfony y Composer

Instalamos Composer desde su pagina original:
```bash
https://getcomposer.org/download/
```
Usamos PHP de XAMPP para la instalacion y la metemos en la variable PATH del ordenador:
```bash
1. WIN + R
2. sysdm.cpl
3. Editamos la variable PATH
4. Añadimos:
   C:\xampp\php
5. Reiniciamos la consola para que se apliquen las variables PATH
```

Puedo crear el proyecto utilizando Composer, vamos al directorio donde queramos y ponemos:

```bash
composer create-project symfony/website-skeleton crudApp
```

Esto creara la estructura base del proyecto en la carpeta `crudApp`.

### 2. Configuracion de la Base de Datos

Ejecuto el script SQL:

- Importo el archivo `database/dbCrudApp.sql` en mi gestor de base de datos para crear la base de datos, las tablas y los registros de ejemplo.

Configuro las variables de conexion:

En el archivo `.env`, defino las siguientes variables:

```dotenv
DATABASE_DSN="mysql:host=127.0.0.1;dbname=my_database"
DATABASE_USER="mi_usuario"
DATABASE_PASSWORD="mi_contraseña"
```

### Desarrollo de la Aplicacion CRUD

La aplicacion se divide en tres modulos principales:

- **Productos**: Gestion completa (listar, crear, editar, ver y eliminar) de productos.
- **Categorias**: Gestion completa de categorias.
- **ordenes**: Gestion de ordenes, donde cada orden se asocia a un producto.

### Endpoints / Rutas Disponibles

#### Productos

- `GET /product` → Listado de productos.
- `GET /product/new` → Formulario para crear un nuevo producto.
- `GET /product/{id}` → Muestra los detalles de un producto.
- `GET /product/{id}/edit` → Formulario para editar un producto.
- `POST /product/{id}/delete` → Accion para eliminar un producto.

#### Categorias

- `GET /category` → Listado de categorias.
- `GET /category/new` → Formulario para crear una nueva categoria.
- `GET /category/{id}` → Muestra los detalles de una categoria.
- `GET /category/{id}/edit` → Formulario para editar una categoria.
- `POST /category/{id}/delete` → Accion para eliminar una categoria.

#### ordenes

- `GET /order` → Listado de ordenes.
- `GET /order/new` → Formulario para crear una nueva orden.
- `GET /order/{id}` → Muestra los detalles de una orden.
- `GET /order/{id}/edit` → Formulario para editar una orden.
- `POST /order/{id}/delete` → Accion para eliminar una orden.

### Como hice funcionar este proyecto

Instalo dependencias que uso como:

```bash
composer require symfony/http-foundation symfony/routing
```

Compilo los estilos y los scrips que uso en la aplicacion ubicados en `/assets`

```bash
php bin/console asset-map:compile
```

Levanto el Servidor de Desarrollo:

```bash
php -S localhost:8000 -t public
```

Accedo a la Aplicacion:

- Pagina de inicio: `http://localhost:8000/`
- CRUD de Productos: `http://localhost:8000/product`
- CRUD de Categorias: `http://localhost:8000/category`
- CRUD de ordenes: `http://localhost:8000/order`

---

> [!WARNING]
> Para instalar y poner en produccion este proyecto en otros ordenadores hay que hacer los siguientes pasos:

 #### 1. Para instalar las mismas dependencias usadas en este proyecto sin saber cuales se instalaron se generan dos archivos que tienen toda la configuracion se ejecuta asi:
   ```bash
   composer install
   ```

#### 2. Compilamos los estilos y los scrips que uso en la aplicacion ubicados en `/assets`

  ```bash
  php bin/console asset-map:compile
  ```

#### 3. Levanto el Servidor de Desarrollo:

  ```bash
  php -S localhost:8000 -t public
  ```

## Conclusion

Este CRUD me proporciona una solucion eficiente para gestionar productos, categorias y ordenes con Symfony y PDO.

