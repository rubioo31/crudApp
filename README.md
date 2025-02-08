# API de Gestion de Productos, Categorias y ordenes

Esta aplicacion web permite la gestion de inventario y ventas a traves de un sistema CRUD (**Crear, Leer, Actualizar y Eliminar**) para **productos**, **categorias** y **ordenes**.  

Fue desarrollada en **PHP** utilizando el framework **Symfony**. Para la base de datos, se usa **PDO** en lugar de Doctrine. La interfaz se renderiza con **Twig**, y los assets como **CSS y JavaScript** estan organizados para mejorar la experiencia de usuario.

> [!IMPORTANT] 
> - Antes de ejecutar la aplicacion, es necesario importar el script SQL ubicado en la carpeta `database/` para crear las tablas.
> - Configurar correctamente el archivo `.env` para la conexion a la base de datos.  

---

## Estructura del Proyecto

```bash
/crudApp
├── assets
│   ├── controllers
│   ├── scripts
│   │   └── script.js              # Script para transiciones
│   └── styles
│       └── style.css              # Estilos de la aplicacion
├── bin                            # Archivos de configuracion de Symfony
├── config                         # Archivos de configuracion de Symfony
├── database
│   └── dbCrudApp.sql              # Script SQL para la base de datos
├── public
│   ├── assets
│   │   ├── scripts                # Scripts compilados
│   │   └── styles                 # Estilos compilados
│   └── index.php                  # Front controller de Symfony
├── src
│   └── Controller
│       ├── BaseController.php     # Clase base con conexion PDO
│       ├── DefaultController.php  # Controlador de la pagina de inicio
│       ├── ProductController.php  # CRUD de productos
│       ├── CategoryController.php # CRUD de categorias
│       └── OrderController.php    # CRUD de ordenes
├── templates                      # Vistas renderizadas con Twig
│   ├── base.html.twig             # Plantilla base con navegacion
│   ├── index.html.twig            # Pagina de inicio
│   ├── product                    # Plantillas para productos
│   │   ├── index.html.twig        # Listado de productos
│   │   ├── new.html.twig          # Formulario de creacion
│   │   ├── edit.html.twig         # Formulario de edicion
│   │   └── show.html.twig         # Vista de detalles
│   ├── category                   # Plantillas para categorias
│   ├── order                      # Plantillas para ordenes
├── .env                           # Configuracion del entorno
├── composer.json                   # Dependencias del proyecto
└── README.md                      # Este archivo
```

---

## Configuracion del Entorno de Desarrollo

### 1️⃣ Instalacion de symfony y Composer

Instalamos Composer desde su [pagina oficial](https://getcomposer.org/download/).

Para asegurarnos de que PHP esta en la variable de entorno `PATH` en Windows:
```bash
1. WIN + R
2. Escribir `sysdm.cpl`
3. Editar la variable `PATH`
4. Agregar `C:\xampp\php`
5. Reiniciar la terminal
```

Despues, creamos el proyecto con:

```bash
composer create-project symfony/website-skeleton crudApp
```

Esto creara la estructura base en la carpeta `crudApp`.

---

### 2️⃣ Configuracion de la Base de Datos

Ejecuto el script SQL:

- Importo el archivo `database/dbCrudApp.sql` en mi mySQL para crear la base de datos.

---

### 3️⃣ Instalacion de Dependencias y Compilacion de Assets

Instalar dependencias de Symfony necesarias:

```bash
composer require symfony/http-foundation symfony/routing
```

Compilar los assets (CSS y JavaScript):

```bash
php bin/console asset-map:compile
```

---

### 4️⃣ Ejecutar el Servidor de Desarrollo

```bash
php -S localhost:8000 -t public
```

---

> [!NOTE]
> ## Endpoints Disponibles
> La aplicacion se ejecuta en `http://localhost:8000/`
>- **Pagina de inicio**: [`http://localhost:8000/`](http://localhost:8000/)
>- **CRUD de Productos**: [`http://localhost:8000/product`](http://localhost:8000/product)
>- **CRUD de Categorias**: [`http://localhost:8000/category`](http://localhost:8000/category)
>- **CRUD de ordenes**: [`http://localhost:8000/order`](http://localhost:8000/order)

---

## Despliegue en otro Entorno
Para instalar las mismas dependencias en otro sistema:

```bash
composer install
```

Compilar los assets nuevamente:

```bash
php bin/console asset-map:compile
```

Ejecutar el servidor:

```bash
php -S localhost:8000 -t public
```

---

## Conclusion

Este proyecto es un sistema de gestion de productos, categorias y ordenes desarrollado en **Symfony** con **Twig** y **PDO** para la conexion a MySQL. Se puede usar para cualquier aplicacion que requiera administracion de inventario y pedidos.