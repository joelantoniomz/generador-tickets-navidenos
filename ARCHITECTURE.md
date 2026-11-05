# Arquitectura definida

## Capas

1. **Presentación:** Blade + CSS responsive; todas las páginas pasan por el layout autenticado y escapan salida con Blade.
2. **HTTP:** controladores pequeños, Form Request inline para validaciones críticas, middleware `auth`, autorización `can:manage-users` y rate limiting.
3. **Dominio/persistencia:** modelos Eloquent `User`, `RaffleSetting` y `TicketBatch`; rangos consecutivos se asignan en transacción y se almacenan como lote auditable.
4. **Documentos:** una plantilla HTML común alimenta PDF con DomPDF; PHPWord genera el Word editable con la misma información. El document root debe ser `public/`.
5. **Datos:** MySQL en producción; SQLite en pruebas. Configuración por `.env`, sin secretos en código salvo credencial demo documentada para el seed.

## Flujo principal

Login → Dashboard → Generar lote → validación → transacción de persistencia → Historial → descarga PDF/DOCX autorizada.

## Controles de seguridad

CSRF en formularios, hash Argon/Bcrypt vía cast `hashed`, regeneración/invalidez de sesión, ORM parametrizado, validación de cantidad/rango/formato, límite de peticiones, autorización por rol, descarga restringida por propietario/admin, `APP_DEBUG=false` recomendado y logs Laravel.
