# FansiteCMS — Habbo.es Edition

CMS de Fansite para **Habbo.es** construido con **Symfony 5**, EasyAdmin Bundle, SASS y JavaScript puro.

## API de Habbo.es utilizada

| Endpoint | Uso |
|---|---|
| `https://www.habbo.es/api/public/users?name={nick}` | Obtener datos del usuario: motto, figureString, memberSince |
| `https://www.habbo.es/habbo-imaging/avatarimage?user={nick}&...` | Imagen del avatar en todos los templates |
| `https://www.habbo.es/room/{roomId}` | Enlace directo a habitaciones |

## Verificación de misión en el registro

Al registrarse, el sistema genera un **token único** que el usuario debe colocar en su **Misión** dentro de Habbo.es.
El Controller consulta la API pública y verifica que `motto == token` antes de crear la cuenta.

## Reproductor Habbo Radio

Incluye un reproductor flotante (`templates/components/radio_player.html.twig`) que:
- Carga la portada/cover desde la API de AzuraCast de Habbo.es
- Muestra el nombre de la canción actual y el DJ en línea
- Controles: Play/Pause, Volumen, Mute
- Actualización automática cada 15 segundos

## Contribución
Por favor, realiza un pull request.
