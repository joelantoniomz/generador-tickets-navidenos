# Generador de Tickets Navideños — Portátiles Perú

Aplicación Laravel + MySQL para administrar sorteos y producir tickets horizontales con copia de tienda y copia de cliente. La interfaz está en español y contempla Dashboard, Diseño/preview de plantilla, Generar tickets, Historial, Descargas, Usuarios y Configuración.

## Arquitectura

- Laravel 11, Blade y CSS propio responsive.
- MySQL para usuarios, configuración del sorteo y lotes de tickets.
- Eloquent ORM, validación server-side, CSRF, sesiones regeneradas, hash seguro de contraseñas, rate limiting en login/generación y autorización mediante Gate `manage-users`.
- DomPDF y PHPWord quedan declarados para implementar las descargas PDF/DOCX finales conservando el mismo layout horizontal.

## Instalación

Requisitos: PHP 8.2+, Composer, extensión PDO MySQL, Node opcional y MySQL 8+.

```bash
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Usuario demo: `admin@portatilesperu.pe` / `Cambiar-esta-clave-2026!`. Cámbialo inmediatamente en un entorno real. Para producción: `APP_DEBUG=false`, HTTPS, permisos restrictivos en `storage`/`bootstrap/cache`, backups, rotación de logs y un gestor de secretos.

## Despliegue

Apuntar el document root a `public/`, ejecutar `php artisan storage:link`, configurar MySQL y publicar con PHP-FPM/Apache/Nginx. No se ha desplegado en un servidor remoto porque no se proporcionaron credenciales, dominio ni datos de hosting.

## Estado de verificación

La inspección de este entorno encontró únicamente Node.js; PHP, Composer, MySQL y Docker no están instalados. Por ello no fue posible ejecutar `composer install`, migraciones, `php artisan test` ni generar realmente PDF/DOCX aquí. El código, migraciones, seeders, vistas, validaciones y pruebas quedan preparados para ejecutarse al instalar esos requisitos.
