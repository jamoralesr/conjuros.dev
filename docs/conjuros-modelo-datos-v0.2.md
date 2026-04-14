# Modelo de Datos — Conjuros.dev
## Borrador v0.2 — Abril 2026

---

## Decisiones de diseño

- **Polimorfismo** para relaciones compartidas entre tipos de contenido (`taggables`, `content_authors`, `resourceables`). Permite que tags, autores y recursos se asocien a cualquier tipo de contenido sin duplicar tablas.
- **Categoría única** por contenido (FK directa). Tags son múltiples (polimórfico).
- **Autores** como entidad separada de usuarios. `type` puede ser `human` o `ai`. Claude es un autor de tipo `ai` sin `user_id`. Un humano tiene `user_id` vinculado.
- **Cashier** maneja `subscriptions` internamente — las columnas de Cashier van en `users` (`stripe_id`, `pm_type`, etc). La tabla `plans` es propia, no de Cashier.
- **`access`** en artículos, tutoriales y recursos: `free` | `pro`. Cursos y lecciones son siempre pro (no necesitan el campo).
- **`interactive_html_path`** en lecciones: URL al archivo HTML servido desde CDN (Cloudflare R2 / S3). Nullable — no todas las lecciones lo tienen.
- **`body`** en recursos: campo nullable para artefactos ejecutables (prompts, skills, commands, hooks, agents, snippets). Los recursos referenciales (links, tools, docs) usan `url` en su lugar.
- **`model`** en recursos: campo nullable solo relevante para prompts, skills y agents. Indica el modelo de IA para el que fue escrito (ej: `claude-sonnet-4`). Commands, hooks y snippets son agnósticos al modelo.

---

## Tablas

### `users`
| Campo | Tipo | Notas |
|-------|------|-------|
| id | uuid PK | |
| name | string | |
| email | string unique | |
| password | string | |
| role | enum | `member`, `author`, `admin` |
| stripe_id | string nullable | Cashier |
| pm_type | string nullable | Cashier |
| pm_last_four | string nullable | Cashier |
| trial_ends_at | timestamp nullable | Cashier |
| created_at / updated_at | timestamps | |

---

### `plans`
| Campo | Tipo | Notas |
|-------|------|-------|
| id | uuid PK | |
| name | string | "Estándar" |
| slug | string unique | `standard` |
| price_monthly | decimal(8,2) | 8.00 |
| price_yearly | decimal(8,2) | 80.00 |
| stripe_price_id_monthly | string | desde `.env` |
| stripe_price_id_yearly | string | desde `.env` |

---

### `subscriptions`
Manejada por Cashier. Referencia a `plans` para la lógica de negocio propia.

| Campo | Tipo | Notas |
|-------|------|-------|
| id | uuid PK | |
| user_id | uuid FK | → users |
| plan_id | uuid FK nullable | → plans |
| type | string | `default` (Cashier) |
| stripe_id | string | |
| stripe_status | string | `active`, `canceled`, `past_due`... |
| trial_ends_at | timestamp nullable | |
| ends_at | timestamp nullable | grace period |

---

### `authors`
| Campo | Tipo | Notas |
|-------|------|-------|
| id | uuid PK | |
| name | string | "Dumbo", "Claude" |
| slug | string unique | |
| bio | text nullable | |
| avatar | string nullable | ruta o URL |
| type | enum | `human`, `ai` |
| user_id | uuid FK nullable | → users (null para Claude) |

> Claude es un autor permanente con `type=ai` y `user_id=null`. Patrón inspirado en Every.to.

---

### `categories`
| Campo | Tipo | Notas |
|-------|------|-------|
| id | uuid PK | |
| name | string | |
| slug | string unique | |

Una sola categoría por contenido (relación directa via `category_id`).

---

### `tags`
| Campo | Tipo | Notas |
|-------|------|-------|
| id | uuid PK | |
| name | string | |
| slug | string unique | |

Múltiples tags por contenido via `taggables`.

---

### `articles`
| Campo | Tipo | Notas |
|-------|------|-------|
| id | uuid PK | |
| title | string | |
| slug | string unique | |
| excerpt | text nullable | |
| body | longtext | HTML (editor TipTap) |
| access | enum | `free`, `pro` |
| status | enum | `draft`, `published` |
| category_id | uuid FK | → categories |
| published_at | timestamp nullable | |

---

### `tutorials`
| Campo | Tipo | Notas |
|-------|------|-------|
| id | uuid PK | |
| title | string | |
| slug | string unique | |
| excerpt | text nullable | |
| body | longtext | HTML (editor TipTap) |
| access | enum | `free`, `pro` |
| status | enum | `draft`, `published` |
| github_url | string nullable | repo del laboratorio |
| category_id | uuid FK | → categories |
| published_at | timestamp nullable | |

---

### `courses`
| Campo | Tipo | Notas |
|-------|------|-------|
| id | uuid PK | |
| title | string | |
| slug | string unique | |
| description | text nullable | |
| status | enum | `draft`, `published` |
| github_url | string nullable | repo del curso |
| category_id | uuid FK | → categories |
| published_at | timestamp nullable | |

Siempre pro — sin campo `access`. Sin precio individual en MVP.

---

### `lessons`
| Campo | Tipo | Notas |
|-------|------|-------|
| id | uuid PK | |
| course_id | uuid FK | → courses |
| title | string | |
| slug | string unique | |
| body | longtext | HTML (editor TipTap) |
| order | integer | posición dentro del curso |
| interactive_html_path | string nullable | URL en CDN (Cloudflare R2 / S3) |
| published_at | timestamp nullable | |

Heredan acceso del curso — siempre pro.

---

### `resources`
| Campo | Tipo | Notas |
|-------|------|-------|
| id | uuid PK | |
| title | string | |
| slug | string unique | |
| type | enum | `prompt`, `skill`, `command`, `hook`, `agent`, `tool`, `snippet`, `link`, `doc` |
| body | longtext nullable | texto ejecutable para prompt / skill / command / hook / agent / snippet |
| url | string nullable | para `link`, `tool`, `doc` externos |
| description | text nullable | contexto de uso, qué hace, cuándo usarlo |
| model | string nullable | modelo de IA objetivo — solo para `prompt`, `skill`, `agent` (ej: `claude-sonnet-4`) |
| access | enum | `free`, `pro` — siempre `free` para recursos sueltos; los recursos de cursos son pro por contexto |

> Los recursos asociados a un curso no necesitan `access=pro` — su restricción viene del curso al que pertenecen vía `resourceables`.

---

## Tablas polimórficas

### `taggables`
| Campo | Tipo | Notas |
|-------|------|-------|
| tag_id | uuid FK | → tags |
| taggable_id | uuid | id del contenido |
| taggable_type | string | `Article`, `Tutorial`, `Course`, `Resource` |

### `content_authors`
| Campo | Tipo | Notas |
|-------|------|-------|
| author_id | uuid FK | → authors |
| authorable_id | uuid | id del contenido |
| authorable_type | string | `Article`, `Tutorial`, `Course` |

### `resourceables`
| Campo | Tipo | Notas |
|-------|------|-------|
| resource_id | uuid FK | → resources |
| resourceable_id | uuid | id del contenido |
| resourceable_type | string | `Article`, `Tutorial`, `Course`, `Lesson` |

---

## Relaciones resumidas

```
users          ──< subscriptions >── plans
users          ──o  authors           (user puede ser autor)
categories     ──<  articles
categories     ──<  tutorials
categories     ──<  courses
courses        ──<  lessons
tags           ──<  taggables         (polimórfico)
authors        ──<  content_authors   (polimórfico)
resources      ──<  resourceables     (polimórfico)
```

---

*Modelo generado en colaboración con Claude (Anthropic)*
*Versión: 0.2 — Abril 2026*
