# API REST - Concesionaria (TPE Web 2)

Este proyecto consiste en una API RESTful para la gestión de una concesionaria de vehículos, permitiendo administrar marcas, autos y comentarios.

## 📂 Estructura del Proyecto

Qué hay en este proyecto:

* **`api_router.php`**: Punto de entrada para los endpoints de la API.
* **`app/controllers/`**: Contiene los controladores de la API.
* **`app/models/`**: Contiene los modelos de la API (acceso a datos).
* **`libs/router/`**: Librería de ruteo utilizada.
* **`database/db_tareas.sql`**: Script SQL para crear la base de datos y tablas iniciales.
* **`.htaccess`**: Archivo de configuración para el manejo de URLs semánticas.

---

## 🔐 Autenticación (Login)

Para realizar operaciones de escritura (POST, PUT, DELETE) es necesario obtener un Token JWT.

* **Usuario:** `webadmin`
* **Contraseña:** `webadmin`
* **Endpoint:** `GET /tpe_api/auth/login`

> **Nota:** El token obtenido debe enviarse en el Header `Authorization` como `Bearer <TOKEN>` en las peticiones protegidas.

---

## 📡 endpoints para consumir la api mediante postman

### 🏷️ Marcas

| Método | Endpoint | Descripción |
| :--- | :--- | :--- |
| **GET** | `/tpe_api/marcas` | Listar todas las marcas |
| **GET** | `/tpe_api/marcas/id` | Ver una marca específica |
| **POST** | `/tpe_api/marcas` | Crear una nueva marca (Requiere Token) |
| **PUT** | `/tpe_api/marcas/id` | Modificar una marca existente (Requiere Token) |
| **DELETE** | `/tpe_api/marcas/id` | Eliminar una marca (Requiere Token) |

### 🚗 Vehículos (Cars)

| Método | Endpoint | Descripción |
| :--- | :--- | :--- |
| **GET** | `/tpe_api/cars` | Listar todos los vehículos |
| **GET** | `/tpe_api/cars/id` | Ver un vehículo específico |
| **POST** | `/tpe_api/cars` | Crear un nuevo vehículo (Requiere Token) |
| **PUT** | `/tpe_api/cars/id` | Modificar un vehículo existente (Requiere Token) |
| **DELETE** | `/tpe_api/cars/id` | Eliminar un vehículo (Requiere Token) |

### 💬 Comentarios

| Método | Endpoint | Descripción |
| :--- | :--- | :--- |
| **GET** | `/tpe_api/comentarios` | Listar todos los comentarios |
| **GET** | `/tpe_api/comentarios/id` | Ver un comentario específico |
| **POST** | `/tpe_api/comentarios` | Publicar un comentario (Requiere Token) |
| **PUT** | `/tpe_api/comentarios/id` | Modificar un comentario (Requiere Token) |
| **DELETE** | `/tpe_api/comentarios/id` | Eliminar un comentario (Requiere Token) |

---

## 📝 Ejemplos de JSON (Body)

Estos son los cuerpos (Body) que se deben enviar en formato **JSON** para agregar o editar recursos.

### Cars (Vehículos)
```json
{
    "modelo": "Ford Focus EDITADO",
    "año": 2021,
    "kilometraje": 50000,
    "version": "Titanium",
    "motorizacion": "2.0 Turbo",
    "categoria": "Sedan",
    "id_marca": 1
}
### marcas
```json
{
    "marca": "Tesla Motors",
    "info_general": "Información actualizada: Ahora fabrican robots también.",
    "cant_concesionarias_ofi": 10,
    "post_venta": "[https://www.tesla.com/service-update](https://www.tesla.com/service-update)"
}
### comentarios
```json
{
    "comentario": "Edito mi opinión: Al final el auto no era tan bueno.",
    "puntaje": 3
}
