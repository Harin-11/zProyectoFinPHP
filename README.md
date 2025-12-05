# GestionProyectos — Back-end (PHP)

> Sistema de gestión de proyectos ligero construido en PHP con arquitectura MVC sencilla. Incluye modelos para usuarios, clientes, programadores y proyectos, con vistas básicas y controladores para autenticación y CRUD.


---

## ✨ Resumen

Proyecto educativo / de ejemplo que sirve como base para gestionar clientes, proyectos y programadores. Diseñado para ejecutarse en un entorno local con XAMPP (Apache + MySQL) y PHP.


---

## 🧭 Características principales

- Autenticación de usuarios con `password_hash()` y `password_verify()`.
- CRUD básico para `clientes`, `programadores` y `proyectos`.
- Plantillas de vistas sencillas y helpers para generación de URLs.
- Estructura organizada en `controllers/`, `models/`, `Views/` y `config/`.


---

## 🛠️ Tecnologías

- PHP (7.4+ recomendado)
- MySQL / MariaDB
- jQuery (incluido en el proyecto)
- Servidor local: XAMPP (o similar)


---

## 🚀 Instalación rápida (Windows / XAMPP)

1. Coloca la carpeta del proyecto en el directorio de servidor (ej: `C:\xampp\htdocs\E001_Backend`).
2. Inicia Apache y MySQL en XAMPP.
3. Abre `phpMyAdmin` y crea una base de datos (o usa la que tenga el proyecto). Importa `database.sql` desde la raíz del proyecto para crear tablas y datos de ejemplo.
4. Ajusta las credenciales de la base de datos en `config/database.php` si es necesario.
5. Accede en el navegador a:

   `http://localhost/E001_Backend/public/`


---

## 🔐 Notas sobre usuarios y contraseñas

- El sistema usa `password_hash()` al registrar usuarios y `password_verify()` al iniciar sesión. Por eso, **no** se debe insertar contraseñas en texto plano directamente en la base de datos.
- Si quieres pre-cargar usuarios en `database.sql`, asegúrate de insertar las contraseñas ya hasheadas con `password_hash()` (bcrypt). Alternativamente, crea usuarios desde el formulario de registro incluido.


---

## Estructura del proyecto (resumen)

- `config/` — configuración y helpers (`helpers.php`, `database.php`).
- `controllers/` — controladores principales (`AuthController.php`, `BaseController.php`, etc.).
- `models/` — modelos (`User.php`, `Cliente.php`, `Programador.php`, `Proyecto.php`).
- `Views/` — plantillas HTML/PHP para cada recurso.
- `public/` — punto de entrada (`index.php`) y activos públicos (JS/CSS).
- `database.sql` — script con esquema y datos de ejemplo.


---

## 🧪 Pruebas rápidas / Verificación

- Registrar un usuario desde la pantalla de registro y luego iniciar sesión para comprobar que `password_hash()` y `password_verify()` funcionan correctamente.
- Si importas `database.sql`, limpia primero la tabla `usuarios` si vas a reimportar para evitar duplicados/errores por `UNIQUE` en `email`.


---

## ⚙️ Consejos y resolución de problemas

- Si al iniciar sesión recibes "Credenciales incorrectas":
  - Verifica que el registro se hizo desde la app (no insertar contraseñas en texto plano).
  - Revisa `config/database.php` para confirmar conexión correcta.
  - Habilita errores de PDO temporalmente para ver excepciones si hay fallos de BD.

- Si las rutas de recursos (JS/CSS) no cargan: revisa `config/helpers.php` y `Views/layouts/header.php` — `getBaseUrl()` construye la ruta hacia `/public/`.


---

## 📋 Buenas prácticas al modificar

- Mantén las contraseñas solo a través de `password_hash()`.
- Evita cambiar la estructura de carpetas sin actualizar `getBaseUrl()`.
- Al agregar datos de ejemplo, prefiere crear un script de seed en PHP que use `password_hash()` para generar los usuarios.


---

## 🤝 Contribuir

1. Haz fork del repositorio.
2. Crea una rama con la mejora (`feature/nombre`).
3. Haz un pull request con descripción clara.


---

## 📬 Contacto / Autor

Proyecto mantenido por el autor del repositorio. Para dudas o mejoras, abre un issue o contacta vía los canales del repositorio.


