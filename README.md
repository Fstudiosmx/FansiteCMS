# FansiteCMS 🏨

**FansiteCMS** es un CMS de fansite para el hotel virtual **Habbo**, construido con **Symfony 6** y completamente traducido al **Español Latinoamérico (es_419)**.

## ✨ Características

- 🌎 Interfaz completa en **Español Latinoamérica** (es_419)
- 🏨 Integración con **[Habbo.es](https://www.habbo.es)** — hotel oficial en español
- 👤 **Avatar Habbo** cargado directamente desde `habbo.es/habbo-imaging`
- 🗞️ Sistema de **Noticias** con editor CKEditor
- 🏠 Gestión de **Habitaciones** con enlace a Habbo.es
- 👥 Sistema de **Equipos** con roles y cargos
- 🎥 Galería de **Videos**
- 🔐 Autenticación segura con Symfony Security
- 🐘 Base de datos **PostgreSQL** (compatible también con MySQL)

## 🚀 Instalación

### Requisitos previos
- PHP 8.1+
- Composer
- PostgreSQL 13+ (o MySQL 8+)
- Node.js + Yarn

### Pasos

```bash
# 1. Clonar el repositorio
git clone https://github.com/Fstudiosmx/FansiteCMS.git
cd FansiteCMS

# 2. Instalar dependencias PHP
composer install

# 3. Instalar dependencias JS
yarn install
yarn build

# 4. Configurar base de datos en .env
# PostgreSQL:
DATABASE_URL="postgresql://usuario:contraseña@127.0.0.1:5432/fansite?serverVersion=15&charset=utf8"

# 5. Crear base de datos y ejecutar migraciones
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

# 6. Limpiar caché
php bin/console cache:clear

# 7. Levantar servidor de desarrollo
php -S localhost:8000 -t public/
```

## 🌐 Integración con Habbo.es

Los avatares se cargan directamente desde el hotel español:

```twig
{# Avatar grande en perfil #}
<img src="https://www.habbo.es/habbo-imaging/avatarimage?user=NOMBRE&action=std&direction=2&head_direction=3&gesture=sml&size=l">

{# Avatar pequeño en navbar #}
<img src="https://www.habbo.es/habbo-imaging/avatarimage?user=NOMBRE&action=std&direction=2&head_direction=3&gesture=sml&size=s">

{# Enlace al perfil #}
<a href="https://www.habbo.es/es/profile/NOMBRE">Ver en Habbo.es</a>
```

## 🗄️ Base de Datos PostgreSQL

Esquema incluido en `migrations/Version20260410PostgreSQL.php`:

| Tabla | Descripción |
|---|---|
| `user` | Usuarios del fansite |
| `news` | Noticias y artículos |
| `room` | Habitaciones de Habbo |
| `team` | Equipos del fansite |
| `team_member` | Relación usuarios-equipos |
| `video` | Galería de videos |
| `badge` | Insignias de usuarios |

## 📄 Licencia

GPL-3.0 — Ver [LICENSE](./LICENSE)
