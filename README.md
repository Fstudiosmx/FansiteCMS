# 🏨 FansiteCMS — Fansite Habbo en Español Latinoamérica

CMS completo para fansites de Habbo Hotel, desarrollado con **Symfony 6**, **PostgreSQL** y totalmente traducido al **Español Latinoamérica (es_419)**.

## ✨ Características

- 🌎 **Español Latinoamérica** — Interfaz 100% en español (es_419)
- 🏨 **Habbo.es** — Avatar e integración con el hotel español oficial
- 🐘 **PostgreSQL** — Base de datos robusta para producción
- 📰 **Noticias** — Sistema de publicación de artículos
- 🏠 **Habitaciones** — Gestión de habitaciones de Habbo
- 👥 **Equipo** — Perfiles del equipo del fansite
- 🎬 **Videos** — Galería de videos
- 👤 **Perfiles** — Avatares en tiempo real desde habbo.es

## 🚀 Instalación

### Requisitos

- PHP 8.1+
- PostgreSQL 14+
- Composer
- Node.js + Yarn
- Extensión PHP: `php-pgsql`

### Pasos

```bash
# 1. Clonar el repositorio
git clone https://github.com/Fstudiosmx/FansiteCMS.git
cd FansiteCMS

# 2. Instalar dependencias PHP
composer install

# 3. Instalar dependencias JS
yarn install
yarn encore dev

# 4. Configurar base de datos PostgreSQL en .env
# Edita DATABASE_URL con tus credenciales de PostgreSQL

# 5. Crear la base de datos
php bin/console doctrine:database:create

# 6. Ejecutar migraciones
php bin/console doctrine:migrations:migrate

# 7. Iniciar servidor de desarrollo
symfony server:start
```

## 🐘 Configuración PostgreSQL

Edita `.env` con tu cadena de conexión:

```env
DATABASE_URL="postgresql://usuario:contraseña@127.0.0.1:5432/fansite?serverVersion=15&charset=utf8"
```

Instala el driver PHP si no lo tienes:

```bash
# Ubuntu/Debian
sudo apt install php-pgsql

# macOS con Homebrew
brew install php
```

## 🏨 Integración con Habbo.es

Este CMS usa el **hotel oficial de Habbo en Español** ([habbo.es](https://www.habbo.es)) para:

- **Avatares**: `https://www.habbo.es/habbo-imaging/avatarimage?user=NOMBRE&size=l`
- **Perfiles**: `https://www.habbo.es/es/profile/NOMBRE`
- **Habitaciones**: `https://www.habbo.es/es/hotel?roomId=ID`

## 🌎 Traducciones

Las traducciones están en `translations/messages.es_419.yaml`.

Para cambiar el idioma, edita `config/packages/translation.yaml`:

```yaml
framework:
    default_locale: es_419
```

## 📁 Estructura del Proyecto

```
FansiteCMS/
├── config/          # Configuración de Symfony
├── migrations/      # Migraciones de base de datos (PostgreSQL)
├── public/          # Archivos públicos
├── src/             # Código fuente PHP
│   ├── Controller/  # Controladores
│   ├── Entity/      # Entidades Doctrine
│   └── Form/        # Formularios Symfony
├── templates/       # Plantillas Twig (en español)
├── translations/    # Archivos de traducción (es_419)
└── webpack.config.js
```

## 🛠️ Tecnologías

| Tecnología | Versión | Uso |
|---|---|---|
| Symfony | 6.x | Framework PHP |
| PostgreSQL | 14+ | Base de datos |
| Doctrine ORM | 2.x | ORM |
| Twig | 3.x | Plantillas |
| Webpack Encore | 4.x | Assets |

## 📄 Licencia

GPL-3.0 — Ver [LICENSE](LICENSE) para más detalles.

---

Desarrollado con ❤️ para la comunidad de Habbo en Español Latinoamérica 🌎
