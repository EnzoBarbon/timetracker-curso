# Guía para Crear Usuarios de Prueba

Esta guía explica cómo crear y probar usuarios en el backend Laravel de la aplicación.

## Prerrequisitos

-   Tener los contenedores Docker ejecutándose
-   Base de datos migrada correctamente

## Verificar Contenedores

Primero, asegúrate de que todos los contenedores estén ejecutándose:

```bash
docker ps
```

Deberías ver contenedores como:

-   `timetrack-curso-backend-1` (Backend Laravel)
-   `timetrack-curso-nginx-1` (Nginx proxy)
-   `supabase_db_timetrack-curso` (Base de datos PostgreSQL)

## Ejecutar Migraciones

Si es la primera vez o las tablas no existen, ejecuta las migraciones:

```bash
docker exec -it timetrack-curso-backend-1 php artisan migrate
```

## Métodos para Crear Usuarios de Prueba

### Método 1: Comando Artisan Interactivo (Recomendado)

Usa el comando personalizado que permite crear usuarios de forma interactiva:

```bash
docker exec -it timetrack-curso-backend-1 php artisan app:create-user
```

El comando te pedirá:

-   **Name:** Nombre del usuario
-   **Email:** Email único
-   **Password:** Contraseña (se ocultará al escribir)

### Método 2: Usando Seeders

Modifica el archivo `database/seeders/DatabaseSeeder.php` y ejecuta:

```bash
docker exec -it timetrack-curso-backend-1 php artisan db:seed
```

### Método 3: Tinker (Si tienes permisos)

```bash
docker exec -it timetrack-curso-backend-1 php artisan tinker --execute="App\\Models\\User::create(['name' => 'test', 'email' => 'test@test.com', 'password' => Hash::make('test')]);"
```

## Usuario de Prueba por Defecto

Ya existe un usuario de prueba creado con las siguientes credenciales:

-   **Nombre:** test
-   **Email:** test@test.com
-   **Password:** test

## Probar la Autenticación

### 1. Obtener Token de Autenticación

```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email": "test@test.com", "password": "test"}'
```

**Respuesta esperada:**

```json
{ "token": "1|lJEEccyurDXuYphl6Vxoax2AZDeZLrw3BKSorCjI0087f0b3" }
```

### 2. Verificar Información del Usuario

Usa el token obtenido para acceder a la información del usuario:

```bash
curl -X GET http://localhost:8000/api/me \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer [TU_TOKEN_AQUI]"
```

**Respuesta esperada:**

```json
{
    "id": 1,
    "name": "test",
    "email": "test@test.com",
    "email_verified_at": null,
    "created_at": "2025-06-24T12:59:23.000000Z",
    "updated_at": "2025-06-24T12:59:23.000000Z"
}
```

## Endpoints Disponibles

### Autenticación

-   `POST /api/login` - Iniciar sesión y obtener token
-   `GET /api/me` - Obtener información del usuario autenticado (requiere token)
-   `GET /api/user` - Alias de /api/me (requiere token)

### Headers Requeridos para Endpoints Protegidos

```
Content-Type: application/json
Authorization: Bearer [token]
```

## Solución de Problemas

### Error: "Relation 'users' does not exist"

Ejecuta las migraciones:

```bash
docker exec -it timetrack-curso-backend-1 php artisan migrate
```

### Error: "could not translate host name"

Asegúrate de ejecutar los comandos desde dentro del contenedor usando `docker exec`.

### Error: "Writing to directory is not allowed" (Tinker)

Usa el comando `app:create-user` en su lugar o verifica los permisos del contenedor.

## Estructura de la Tabla Users

```sql
- id (bigint, primary key)
- name (string)
- email (string, unique)
- email_verified_at (timestamp, nullable)
- password (string, hashed)
- remember_token (string, nullable)
- created_at (timestamp)
- updated_at (timestamp)
```

## Notas de Seguridad

-   Las contraseñas se hashean automáticamente usando bcrypt
-   Los tokens se generan usando Laravel Sanctum
-   El usuario de prueba es solo para desarrollo, no usar en producción
