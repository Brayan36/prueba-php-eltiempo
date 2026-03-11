# prueba-php-eltiempo — Prueba Técnica PHP El Tiempo

Portal de noticias en PHP desarrollado con **Laravel 12**, **PHP** y **CSS propio**, inspirado en el diseño de [motor.com.co](https://www.motor.com.co).

---

## Requisitos

- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Node.js >= 18

---

## Instalación y puesta en marcha

### 1. Clonar el repositorio

```bash
git clone git@github.com:Brayan36/prueba-php-eltiempo.git ó https://github.com/Brayan36/prueba-php-eltiempo.git
cd prueba-php-eltiempo
```

### 2. Instalar dependencias

```bash
composer install
npm install && npm run build
```

### 3. Configurar el entorno

```bash
cp .env.example .env
php artisan key:generate
```

Editar `.env` con los datos de la base de datos:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=prueba-php-eltiempo
DB_USERNAME=root
DB_PASSWORD={contraseña utilicen}
```

También puede usarse SQLite modificando 
```env
DB_CONNECTION=sqlite
#DB_HOST=127.0.0.1
#DB_PORT=3306
#DB_DATABASE=prueba-php-eltiempo
#DB_USERNAME=root
#DB_PASSWORD={contraseña utilicen}
```


### 4. Crear la base de datos

Crear manualmente la base de datos en MySQL:

```sql
CREATE DATABASE prueba-php-eltiempo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Nota: las últimas versiones de Laravel, al correr el comando artisan migrate crea automáticamente la DB en MySQL.

### 5. Ejecutar migraciones y seeder

```bash
php artisan migrate --seed
```

El seeder crea automáticamente:
- Las 6 secciones: "Deportes, Política, Social, Internacional, Cultura, Salud"
- Los 3 estados: "Borrador, Publicado, Archivado": solo los que tengan estado publicado, se verán en el listado público
- Un usuario de prueba:

| Campo | Valor |
|-------|-------|
| Email | test@example.com |
| Password | 12345678 |

### 6. Enlace de almacenamiento

```bash
php artisan storage:link
```

### 7. Levantar el servidor

```bash
php artisan serve
```

El portal estará disponible en `http://127.0.0.1:8000`.

---

## Credenciales de prueba

```
Email:    test@example.com
Password: 12345678
```

---

## Estructura de archivos modificados / creados

```
news-portal/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── NewsController.php          <- CRUD completo + vistas públicas
│   │   └── Requests/
│   │       ├── StoreNewsRequest.php         <- Validación al crear noticia
│   │       └── UpdateNewsRequest.php        <- Validación al editar + ownership
│   └── Models/
│       ├── News.php                         <- Modelo principal, scopes, accessor imagen
│       ├── Section.php                      <- Catálogo de secciones
│       └── Status.php                       <- Catálogo de estados
│
├── database/
│   ├── migrations/
│   │   ├── xxxx_create_users_table.php              <- Laravel Breeze (sin modificar)
│   │   ├── 2025_01_01_000001_create_sections_table.php
│   │   ├── 2025_01_01_000002_create_statuses_table.php
│   │   └── 2025_01_01_000003_create_news_table.php
│   └── seeders/
│       └── DatabaseSeeder.php               <- Secciones, estados y usuario de prueba
│
├── routes/
│   ├── web.php                              <- Rutas públicas + dashboard autenticado
│   └── auth.php                             <- Laravel Breeze (sin modificar)
│
├── public/
│   └── css/
│       └── app.css                          <- Estilos globales del portal
│
└── resources/
    └── views/
        ├── el-tiempo/
        │   └── app.blade.php                <- Layout base (header, nav, footer)
        └── news/
            ├── index.blade.php              <- Listado público
            ├── show.blade.php               <- Detalle de noticia + relacionadas
            ├── my-news.blade.php            <- Dashboard del autor
            ├── create.blade.php             <- Formulario crear noticia
            ├── edit.blade.php               <- Formulario editar noticia
            └── _form.blade.php              <- Partial compartido (campos del form)
```

---

## Rutas disponibles

### Públicas

| Método | URL | Descripción |
|--------|-----|-------------|
| GET | `/` | Home — listado de noticias publicadas |
| GET | `/news` | Listado con filtro por sección |
| GET | `/news/{slug}` | Detalle de una noticia |

### Autenticadas (`auth + verified`)

| Método | URL | Descripción |
|--------|-----|-------------|
| GET | `/dashboard/my-news` | Listado de noticias del autor |
| GET | `/dashboard/news/create` | Formulario crear noticia |
| POST | `/dashboard/news` | Almacenar noticia |
| GET | `/dashboard/news/{id}/edit` | Formulario editar noticia |
| PUT | `/dashboard/news/{id}` | Actualizar noticia |
| DELETE | `/dashboard/news/{id}` | Eliminar noticia |

---

## Diagrama de base de datos

```
users
├── id
├── name
├── email
├── password
└── timestamps

sections                    statuses
├── id                      ├── id
├── name                    ├── name
├── slug                    ├── slug
└── timestamps              └── timestamps

news
├── id
├── section_id  ->  sections.id
├── user_id     ->  users.id
├── status_id   ->  statuses.id
├── title
├── slug
├── content
├── image          (path en storage/app/public/news/)
├── published_at
└── timestamps
```

---

## Notas

- Las imágenes se almacenan en `storage/app/public/news/` y son accesibles via `storage:link`.
- Los usuarios no autenticados solo ven noticias con estado **Publicado**.
- Los usuarios autenticados pueden ver noticias en cualquier estado (Borrador, Publicado, Archivado).
- Solo el autor de una noticia puede editarla o eliminarla.
