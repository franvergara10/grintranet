# 🎓 Guía Paso a Paso: Construyendo tu Primer Gestor de Usuarios con Laravel

Esta guía está diseñada para alumnos que se inician en Laravel. Aprenderemos a crear una aplicación desde cero para gestionar usuarios y roles, con un diseño moderno y seguridad profesional.

---

## 🚀 Paso 1: Preparación del Entorno
Antes de empezar, asegúrate de tener instalado **XAMPP** (con PHP 8.2+) y **Composer**.

1.  **Abrir la terminal** (CMD o PowerShell).
2.  **Crear el proyecto**:
    ```bash
    composer create-project laravel/laravel gestor-usuarios
    cd gestor-usuarios
    ```
3.  **Encender la base de datos**: Abre el Panel de Control de XAMPP y activa **Apache** y **MySQL**.
4.  **Configurar la conexión**: Abre tu proyecto en un editor (como VS Code) y busca el archivo `.env`. Cambia estas líneas:
    ```env
    DB_DATABASE=gestor_usuarios_db
    DB_USERNAME=root
    DB_PASSWORD=
    ```
    *Nota: Debes crear la base de datos `gestor_usuarios_db` en el panel de PHPMyAdmin de XAMPP.*

---

## 📦 Paso 2: Instalación del "Motor" de Roles
Para no programar la lógica de permisos desde cero, usamos un paquete profesional llamado **Spatie Laravel Permission**.

1.  **Instalarlo**:
    ```bash
    composer require spatie/laravel-permission
    ```
2.  **Publicar configuración**:
    ```bash
    php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
    ```
3.  **Actualizar la base de datos**: Esto creará las tablas necesarias (usuarios, roles, permisos) automáticamente.
    ```bash
    php artisan migrate
    ```

---

## 👮 Paso 3: Configurar el Modelo de Usuario
El "Modelo" es el archivo que representa a un usuario en el código. Debemos decirle que ahora puede tener roles.

1.  Abre `app/Models/User.php`.
2.  Añade esta línea arriba con los otros `use`:
    ```php
    use Spatie\Permission\Traits\HasRoles;
    ```
3.  Dentro de la clase, añade el uso del trait:
    ```php
    class User extends Authenticatable {
        use HasFactory, Notifiable, HasRoles; // <--- Añade HasRoles aquí
    ```

---

## ⚙️ Paso 4: Configurar la Seguridad (Laravel 11)
Laravel 11 es muy minimalista. Debemos registrar manualmente los "guardianes" (middlewares) que vigilarán las rutas.

1.  Abre `bootstrap/app.php`.
2.  Añade los alias dentro de la función `withMiddleware`:
    ```php
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
        ]);
    })
    ```

---

## � Paso 5: Creando la Lógica (Controladores)
El Controlador es el cerebro que decide qué datos mostrar y qué hacer cuando el usuario pulsa un botón.

1.  **Crear el controlador de usuarios**:
    ```bash
    php artisan make:controller UserController --resource
    ```
    *El comando `--resource` crea automáticamente las funciones básicas (index, create, store, edit, update, destroy).*

2.  **En el archivo `app/Http/Controllers/UserController.php`**:
    *   En `index`: Buscamos los usuarios en la base de datos y los enviamos a la vista.
    *   En `store`: Validamos que el email sea real y guardamos al usuario con `$user->assignRole($request->role)`.

---

## �️ Paso 6: Definir las Rutas
Las rutas son las direcciones URL de nuestra web.

1.  Abre `routes/web.php`.
2.  Protege las rutas para que solo los que estén logueados y sean **admin** puedan entrar:
    ```php
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
    });
    ```

---

## 🎨 Paso 7: El Diseño (Blade y CSS)
Laravel usa **Blade**, un sistema que permite mezclar HTML con código PHP de forma sencilla.

1.  **Layout (`resources/views/layouts/app.blade.php`)**: Es el "esqueleto" de la web. Aquí ponemos el menú y el Sidebar.
2.  **Vistas**: Creamos carpetas en `resources/views/users/` para `index.blade.php` (la tabla de usuarios) y `create.blade.php` (el formulario).
3.  **Estilo Premium**: En `public/css/app.css` definimos los colores. Usamos:
    *   `background-color: #0f172a;` para un tono oscuro elegante.
    *   `backdrop-filter: blur(10px);` para que los menús parezcan de cristal (Glassmorphism).

---

## 🌱 Paso 8: Datos Iniciales (Seeders)
Como la base de datos está vacía, creamos un "sembrador" para tener un admin nada más empezar.

1.  **Crear Seeder**:
    ```bash
    php artisan make:seeder RoleSeeder
    ```
2.  **Script del Seeder (`database/seeders/RoleSeeder.php`)**:
    ```php
    $adminRole = Role::create(['name' => 'admin']);
    $user = User::create([
        'name' => 'Admin Principal',
        'email' => 'admin@admin.com',
        'password' => Hash::make('12345678')
    ]);
    $user->assignRole($adminRole);
    ```
3.  **Ejecutar**:
    ```bash
    php artisan db:seed --class=RoleSeeder
    ```

---

## ✅ Resumen para el Alumno
Para crear una aplicación en Laravel siempre sigue este orden:
1.  **Base de datos**: Configura el `.env`.
2.  **Migraciones**: Define las tablas (`php artisan migrate`).
3.  **Modelos**: Configura la lógica de datos.
4.  **Controladores**: Escribe la lógica de los botones y funciones.
5.  **Vistas**: Diseña el HTML de lo que el usuario ve.
6.  **Rutas**: Conecta las URL con los controladores.
7.  **Seguridad**: Protege las rutas con Middlewares.

