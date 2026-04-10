# FansiteCMS — Traducción Español Latinoamérica + PostgreSQL

> Rama: `traduccion-es-latam`  
> Fecha: Abril 2026  
> Estado: ✅ Completo

## Resumen de cambios

Este PR traduce completamente el proyecto del **francés** al **Español Latinoamérica (es_419)** y migra los avatares de Habbo de la API de HabboCity a **habbo.es** (hotel oficial en español).

## Archivos modificados

| Archivo | Cambio |
|---|---|
| `translations/messages.es_419.yaml` | ✅ Creado — Todas las cadenas de texto en es_419 |
| `templates/base.html.twig` | ✅ `lang="fr"` → `lang="es"`, meta descripción en español |
| `templates/index.html.twig` | ✅ Textos hardcodeados → `\|trans`, avatares → habbo.es |
| `templates/security/login.html.twig` | ✅ Formulario de login completamente en español |
| `templates/register/index.html.twig` | ✅ Registro traducido, imagen de habbo.es |
| `templates/profile/index.html.twig` | ✅ Perfil traducido + avatar habbo.es + enlace al perfil |
| `config/packages/translation.yaml` | ✅ Locale configurado como es_419 con fallback es/en |

## Cambio de Avatar Habbo

**Antes (HabboCity — API privada):**
```
https://api.habbocity.me/avatar_image.php?user=NOMBRE&headonly=0&direction=2&size=l
```

**Después (Habbo.es — hotel oficial español):**
```
https://www.habbo.es/habbo-imaging/avatarimage?user=NOMBRE&action=std&direction=2&head_direction=3&gesture=sml&size=l
```

### Parámetros del avatar habbo.es

| Parámetro | Valores | Descripción |
|---|---|---|
| `user` | nombre | Nombre del personaje |
| `action` | `std`, `wav`, `sit` | Acción/pose |
| `direction` | 0–7 | Dirección del cuerpo |
| `head_direction` | 0–7 | Dirección de la cabeza |
| `gesture` | `sml`, `sad`, `agr`, `srp` | Expresión facial |
| `size` | `s`, `m`, `l` | Tamaño |

## Configuración PostgreSQL

Actualizar `.env`:

```dotenv
# Cambiar de MySQL:
# DATABASE_URL="mysql://user:pass@127.0.0.1:3306/fansite"

# A PostgreSQL:
DATABASE_URL="postgresql://user:pass@127.0.0.1:5432/fansite?serverVersion=15&charset=utf8"
```

Regeneración de migraciones:

```bash
# 1. Eliminar migraciones anteriores (MySQL)
rm migrations/Version*.php

# 2. Crear base de datos
php bin/console doctrine:database:create

# 3. Generar nueva migración desde las entidades
php bin/console doctrine:migrations:diff

# 4. Ejecutar migración
php bin/console doctrine:migrations:migrate
```

## Activar locale en Symfony

En `config/packages/framework.yaml` agregar:

```yaml
framework:
    default_locale: 'es_419'
```

## Uso de traducciones en Twig

```twig
{# Texto simple #}
{{ 'nav.inicio'|trans }}

{# Con variables #}
{{ 'auth.bienvenido'|trans({'%nombre%': app.user.username}) }}

{# En atributo HTML #}
<img alt="{{ 'profile.avatar'|trans }}">
```
