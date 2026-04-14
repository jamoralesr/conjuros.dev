# Conjuros.dev

> Plataforma de contenido educativo sobre desarrollo de software con IA. En español, con membresías pro, construida con Laravel 13 + Livewire 4 + Flux UI Pro.

Conjuros.dev es un **registro de oficio abierto** — tutoriales, cursos y recursos reales para desarrolladores y vibe coders que construyen con IA. Cada laboratorio es un proyecto funcional en GitHub. Cada pieza de contenido se produce en colaboración con Claude (Anthropic), que se cita como co-autor.

Este repositorio contiene la plataforma: admin de contenido, frontend público con paywall y el sistema de membresías vía Stripe. El contenido vive en la base de datos y se edita desde `/admin`.

---

## Stack

| Área | Tecnología |
|---|---|
| Framework | Laravel 13 (PHP 8.4) |
| Frontend | Livewire 4 (SFC) + Flux UI Pro v2 |
| Estilos | Tailwind CSS v4 |
| Base de datos | PostgreSQL 16+ |
| Autenticación | Laravel Fortify (login, 2FA, password reset) |
| Pagos | Laravel Cashier 16 + Stripe Checkout hosted |
| Email transaccional | Resend |
| Newsletter | Buttondown (vía API) |
| Editor | Flux Editor (TipTap con bloques de código) |
| Tests | Pest 4 |
| Hosting objetivo | Laravel Forge + Hetzner/DigitalOcean |

---

## Arquitectura

**Un solo proyecto Laravel** — admin y frontend público conviven en el mismo codebase. Las rutas están separadas por dominio:

```
routes/
├── web.php         # Entry point, incluye los demás
├── front.php       # /, /articulos, /tutoriales, /cursos, /recursos, /metodologia, /planes
├── back.php        # /admin/* (protegido por middleware EnsureUserIsAdmin)
└── settings.php    # /settings/* (perfil, seguridad/2FA, membresía, apariencia)
```

### Modelo de contenido

- **Articles** — pieza libre o pro, formato blog
- **Tutorials** — pieza autocontenida con `github_url` de laboratorio
- **Courses + Lessons** — colección pro con lecciones encadenadas
- **Resources** — prompts, skills, commands, hooks, agents, snippets, links, tools, docs
- **Authors** — polimórficos vía `content_authors` (humanos o IA como Claude)
- **Categories** — una por pieza (FK directa)
- **Tags** — múltiples vía `taggables` polimórfico
- **Resourceables** — recursos asociados a cualquier tipo de contenido

### Paywall

Estrategia **preview + gate**: el body del contenido pro se trunca a ~1500 chars preservando integridad HTML (`App\Support\ContentGate::preview()`) y se muestra un bloque con CTA a `/planes`. Google indexa el preview completo, por lo que el SEO no se rompe.

---

## Desarrollo local

### Requisitos

- PHP 8.4 (Herd o local)
- PostgreSQL 16 (Herd trae uno)
- Node 20+
- Composer 2
- `auth.json` con credenciales de Flux UI Pro (paquete de pago)

### Setup

```bash
# 1. Clonar e instalar dependencias
git clone <repo> conjuros.dev
cd conjuros.dev
composer install
npm install

# 2. Configurar entorno
cp .env.example .env
php artisan key:generate

# 3. Crear base Postgres (Herd)
psql -h 127.0.0.1 -p 5432 -U postgres -c "CREATE DATABASE conjuros;"

# 4. Migrar y sembrar
php artisan migrate --seed

# 5. Compilar assets y arrancar
npm run dev
```

El sitio estará disponible en `http://conjuros.dev.test` (Herd lo sirve automáticamente).

### Usuario admin inicial

El seeder crea:

- **Email:** `dumbo@sietepm.com`
- **Password:** `password` (cambiar inmediatamente)
- **Rol:** `admin`

Entra al backend en `http://conjuros.dev.test/admin`.

Para cambiar la contraseña:

```bash
php artisan tinker --execute 'App\Models\User::where("email","dumbo@sietepm.com")->update(["password" => bcrypt("NUEVO_PASSWORD")]);'
```

---

## Comandos útiles

```bash
# Tests (50 tests / 112 assertions)
php artisan test --compact

# Filtrar tests
php artisan test --compact --filter=ArticleAccessTest

# Formateo (obligatorio antes de commit)
vendor/bin/pint --dirty --format agent

# Lint + tests juntos
composer test

# Dev server + queue + logs + vite en paralelo
composer dev

# Inspeccionar rutas
php artisan route:list --except-vendor

# Regenerar DB desde cero
php artisan migrate:fresh --seed
```

---

## Estructura del proyecto

```
app/
├── Enums/                   # UserRole, ContentAccess, ContentStatus, AuthorType, ResourceType
├── Http/
│   ├── Controllers/Front/   # HomeController, ArticleController, TutorialController, etc
│   ├── Controllers/         # CheckoutController
│   └── Middleware/          # EnsureUserIsAdmin
├── Jobs/                    # SyncSubscriberToButtondown
├── Models/
│   ├── Concerns/            # HasContentRelations (trait polimórfico)
│   └── *.php                # Article, Tutorial, Course, Lesson, Resource, etc.
├── Services/                # ButtondownClient
└── Support/                 # ContentGate (paywall truncation)

resources/views/
├── components/              # paywall-gate, content-version-note, content-editor
├── layouts/                 # front, admin, app (settings), auth
├── livewire/front/          # Newsletter form SFC
├── pages/
│   ├── admin/               # CRUD Livewire para cada entidad
│   ├── auth/                # Fortify views (starter kit)
│   └── settings/            # Profile, security (2FA), billing, appearance
└── front/                   # Home, articles, tutorials, courses, resources, checkout, methodology, plans

database/
├── migrations/              # 13 migraciones propias + Cashier
├── factories/               # Factory por modelo con estados (published, pro, ai)
└── seeders/DatabaseSeeder.php  # Admin + Plan + Categorías + Authors

docs/                        # PRD, modelo de datos, plan de fases (decisiones de producto)
Plans/                       # Planes de implementación (ignorado en git)
tests/Feature/               # Paywall access, admin access, Buttondown sync, Fortify
```

---

## Membresías y pagos

- **Plan único:** USD 8/mes o USD 80/año (equivale a ~2 meses gratis)
- **Checkout:** Stripe Checkout hosted, vía `$user->newSubscription()->checkout()`
- **Portal de gestión:** Stripe Billing Portal, accesible desde `/settings/billing`
- **Webhook:** `/stripe/webhook` (registrado por Cashier, exento de CSRF)

Los price IDs de Stripe se leen desde `.env` (`STRIPE_PRICE_STANDARD_MONTHLY`, `STRIPE_PRICE_STANDARD_YEARLY`) y el seeder los copia a la tabla `plans`. Para actualizar precios, edítalos en el admin o re-ejecuta el seeder.

---

## Variables de entorno clave

| Variable | Descripción |
|---|---|
| `DB_CONNECTION=pgsql` | PostgreSQL obligatorio |
| `RESEND_KEY` | API key de Resend para emails transaccionales |
| `STRIPE_KEY` / `STRIPE_SECRET` | Claves públicas/secretas de Stripe |
| `STRIPE_WEBHOOK_SECRET` | Firma de webhooks de Stripe |
| `STRIPE_PRICE_STANDARD_MONTHLY` | ID del precio mensual en Stripe |
| `STRIPE_PRICE_STANDARD_YEARLY` | ID del precio anual en Stripe |
| `BUTTONDOWN_API_KEY` | API key de Buttondown para newsletter |
| `CASHIER_CURRENCY=usd` | Moneda por defecto |
| `CASHIER_CURRENCY_LOCALE=es` | Formato de precios |

---

## Deploy

Ver [`DEPLOY.md`](DEPLOY.md) para la guía paso a paso con Forge + Hetzner: provisión del servidor, configuración de Stripe en modo live, webhook, primer seed, queue worker daemon y smoke test post-deploy.

---

## Documentación de producto

- [`docs/conjuros-prd-v0.4.md`](docs/conjuros-prd-v0.4.md) — PRD completo (visión, audiencia, modelo de negocio, métricas)
- [`docs/conjuros-modelo-datos-v0.2.md`](docs/conjuros-modelo-datos-v0.2.md) — Esquema de tablas y relaciones
- [`docs/conjuros-plan-fases.md`](docs/conjuros-plan-fases.md) — Roadmap por fases

---

## Autoría

Conjuros.dev se escribe en colaboración activa con **Claude (Anthropic)** — no como autocomplete, sino como co-autor. La página `/metodologia` lo explica en detalle. Cada pieza de contenido cierra con:

> *Escrito con Claude (Anthropic) — [mes año]*

Esta plataforma también fue construida así.

---

*Factura: Siete PM SpA · Santiago, Chile*
