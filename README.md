# API REST Turismo CDMX

API REST desarrollada con Laravel Lumen para la aplicación Turismo CDMX.

## Requisitos

- PHP >= 7.4
- Composer
- MySQL o MariaDB
- Extensiones PHP: OpenSSL, PDO, Mbstring, Tokenizer

## Instalación

1. Clonar el repositorio:
   ```bash
   git clone https://github.com/tuusuario/turismo-cdmx-api.git
   cd turismo-cdmx-api
   ```

2. Instalar dependencias:
   ```bash
   composer install
   ```

3. Configurar el archivo .env:
   ```bash
   cp .env.example .env
   ```
   Edita el archivo .env con tus credenciales de base de datos y configura la clave JWT_SECRET.

4. Generar la clave de la aplicación:
   ```bash
   php -r "echo md5(uniqid());"
   ```
   Copia la clave generada y ponla en APP_KEY en el archivo .env como `base64:clave`.

5. Crear la base de datos:
   ```sql
   CREATE DATABASE turismo_cdmx CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

6. Ejecutar migraciones y seeders:
   ```bash
   php artisan migrate --seed
   ```

## Ejecución

Para ejecutar el servidor de desarrollo:

```bash
php -S localhost:8000 -t public
```

## Endpoints de la API

### Autenticación

- `POST /auth/register` - Registrar un nuevo usuario
    - Parámetros: name, email, password, password_confirmation

- `POST /auth/login` - Iniciar sesión
    - Parámetros: email, password

- `GET /auth/me` - Obtener información del usuario autenticado
    - Headers: Authorization: Bearer {token}

### Categorías

- `GET /categories` - Listar todas las categorías
- `POST /categories` - Crear una nueva categoría (requiere autenticación)
- `GET /categories/{id}` - Ver detalle de una categoría
- `PUT /categories/{id}` - Actualizar una categoría (requiere autenticación)
- `DELETE /categories/{id}` - Eliminar una categoría (requiere autenticación)

### Lugares

- `GET /places` - Listar todos los lugares
    - Parámetros opcionales:
        - per_page: Número de elementos por página
        - order_by: Campo para ordenar
        - order: asc o desc
        - category_id: Filtrar por categoría
        - search: Búsqueda por texto

- `POST /places` - Crear un nuevo lugar (requiere autenticación)
- `GET /places/{id}` - Ver detalle de un lugar
- `PUT /places/{id}` - Actualizar un lugar (requiere autenticación)
- `DELETE /places/{id}` - Eliminar un lugar (requiere autenticación)
- `GET /places/district/{district}` - Listar lugares por alcaldía/municipio

## Seguridad

Esta API implementa:
- Autenticación JWT
- Validación de datos
- Manejo de errores estructurado
- CORS para permitir solicitudes de diferentes dominios
- Configuraciones recomendadas para producción

## Producción

Para entornos de producción, recuerda:

1. Configurar el archivo .env:
    - APP_ENV=production
    - APP_DEBUG=false
    - Usar claves seguras para APP_KEY y JWT_SECRET

2. Optimizar autoload:
   ```bash
   composer install --optimize-autoloader --no-dev
   ```

3. Configurar un servidor web adecuado (Nginx, Apache) con SSL
