# Proyecto Laravel – CRUD de Posts, Filtros, Compras por Email y Google Meet

Este proyecto es una aplicación desarrollada en **Laravel 10** como parte de una prueba técnica para acceder a unas prácticas como desarrolladora web.  
Incluye un **CRUD completo de posts**, sistema de **filtros dinámicos**, una función para **comprar un post mediante email**, y una integración real con **Google Calendar API** para generar enlaces de **Google Meet** desde la aplicación.

---

## Tecnologías utilizadas

-   PHP 8+
-   Laravel 10
-   Composer
-   Blade Templates
-   MySQL
-   XAMPP + phpMyAdmin
-   Laravel Socialite
-   Google Cloud Console
-   Google Calendar API
-   HTML / CSS / Bootstrap

---

## 1. CRUD Completo de Posts

El proyecto permite gestionar posts con todas las operaciones CRUD:

-   Crear publicaciones
-   Listar posts
-   Editar posts
-   Eliminar posts
-   Ver un post individual

Cada vista incluye validación, mensajes de error y formularios funcionales.

---

## 🔍 2. Filtro de Posts

La aplicación permite filtrar posts por título.

## 🛒 3. Comprar un Post mediante Email

En cada vista individual de un post, el usuario puede introducir un correo para “comprar” ese post.

Funcionamiento interno:

Se valida el email recibido

Se crea un registro en la tabla purchases

Se vincula la compra al post

Se registra la fecha de la compra

No se procesa ningún pago real; solo se simula el flujo.

## 4. Integración con Google Meet (Google Calendar API)

El proyecto permite generar automáticamente un enlace de Google Meet desde Laravel gracias a la integración con Google Calendar API.

Flujo completo:

El usuario pulsa “Conectar con Google”.

Se abre la pantalla oficial de OAuth de Google.

Laravel obtiene google_token y google_refresh_token.

Los tokens se guardan en la base de datos.

El usuario selecciona “Crear reunión”.

Laravel crea un evento en Google Calendar.

Google devuelve automáticamente un enlace de Google Meet.

El enlace se muestra en la vista /meeting.

GoogleCalendarService

Se creó un servicio personalizado que:

Inicializa el cliente de Google

Comprueba si el token está expirado

Renueva automáticamente el token si es necesario

Crea eventos en Google Calendar

Obtiene enlaces Meet

Guarda nuevos tokens en BD cuando Google los envía

# Estructura técnica

Controladores:

PostController

PurchaseController

GoogleAuthController

DashboardController

Modelos:

Post

Purchase

User (con campos adicionales para Google)

Servicios:

App\Services\GoogleCalendarService.php

Tablas principales:

posts

purchases

users

# Funciones implementadas

✔ CRUD completo
✔ Filtros
✔ Sistema de compras por email
✔ Integración OAuth con Google
✔ Creación de eventos en Google Calendar
✔ Enlace automático de Google Meet
✔ Renovación de tokens
✔ Uso de XAMPP y phpMyAdmin
