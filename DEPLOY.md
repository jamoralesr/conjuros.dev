# Deploy — Conjuros.dev

Guía operativa para deployar Conjuros.dev por primera vez en producción. El stack esperado es Laravel Forge + Hetzner/DigitalOcean + PostgreSQL + Resend + Stripe + Buttondown.

---

## 1. Repositorio GitHub

1. Crear repositorio privado en la cuenta GitHub de Conjuros.dev.
2. `git remote add origin git@github.com:<org>/conjuros-platform.git`.
3. `git push -u origin main`.

## 2. Provisionar servidor en Forge

1. Crear servidor en Forge conectado a Hetzner (CX22 o similar, PHP 8.4, Postgres 16, Nginx, no MySQL).
2. Crear site `conjuros.dev` (no subdominio).
3. Conectar el repo. Branch `main`. Enable quick deploy.

## 3. Variables de entorno (`.env` de producción)

Copiar desde `.env.example` y completar:

```bash
APP_NAME=Conjuros.dev
APP_ENV=production
APP_KEY=base64:xxx  # php artisan key:generate
APP_DEBUG=false
APP_URL=https://conjuros.dev
APP_LOCALE=es
APP_FALLBACK_LOCALE=es

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=conjuros
DB_USERNAME=forge
DB_PASSWORD=<secret>

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database

MAIL_MAILER=resend
MAIL_FROM_ADDRESS="hola@conjuros.dev"
MAIL_FROM_NAME="${APP_NAME}"
RESEND_KEY=<resend_api_key>

STRIPE_KEY=pk_live_...
STRIPE_SECRET=sk_live_...
STRIPE_WEBHOOK_SECRET=whsec_...
CASHIER_CURRENCY=usd
CASHIER_CURRENCY_LOCALE=es
STRIPE_PRICE_STANDARD_MONTHLY=price_...
STRIPE_PRICE_STANDARD_YEARLY=price_...

BUTTONDOWN_API_KEY=<buttondown_api_key>
```

## 4. Deploy script de Forge

```bash
cd $FORGE_SITE_PATH
git pull origin $FORGE_SITE_BRANCH
$FORGE_COMPOSER install --no-dev --no-interaction --prefer-dist --optimize-autoloader
npm ci
npm run build
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
( flock -w 10 9 || exit 1; echo 'Restarting FPM...'; sudo -S service php8.4-fpm reload ) 9>/tmp/fpmlock
```

Nota: no correr `db:seed` en cada deploy. Primer deploy requiere seed inicial (paso 7).

## 5. SSL

En Forge → Sites → conjuros.dev → SSL → LetsEncrypt. Propagación de DNS debe estar hecha antes (A record apuntando al servidor).

## 6. Stripe en modo live

1. Crear producto "Conjuros Pro" en dashboard.stripe.com (modo live).
2. Crear 2 precios: `USD 8.00/mes` y `USD 80.00/año`.
3. Copiar los price IDs a las variables `STRIPE_PRICE_STANDARD_MONTHLY` y `STRIPE_PRICE_STANDARD_YEARLY`.
4. Crear webhook apuntando a `https://conjuros.dev/stripe/webhook`. Eventos mínimos:
   - `customer.subscription.created`
   - `customer.subscription.updated`
   - `customer.subscription.deleted`
   - `invoice.payment_succeeded`
   - `invoice.payment_failed`
5. Copiar el signing secret a `STRIPE_WEBHOOK_SECRET`.

## 7. Primer seed en producción

Conectar vía SSH o Forge Commands:

```bash
php artisan db:seed --force
```

El seeder crea:
- Usuario admin `dumbo@sietepm.com` (cambiar password inmediatamente)
- Plan "Estándar" con los price IDs del `.env`
- Categorías base
- Autores Dumbo (human) y Claude (ai)

Cambiar password del admin:

```bash
php artisan tinker --execute 'User::where("email","dumbo@sietepm.com")->update(["password" => bcrypt("NUEVO_PASSWORD_SEGURO")]);'
```

## 8. Queue worker

Forge → Daemons → crear daemon:

```bash
php $FORGE_SITE_PATH/artisan queue:work --tries=3 --timeout=60 --sleep=3 --max-jobs=1000
```

Necesario para que `SyncSubscriberToButtondown` se ejecute de fondo al registrarse un usuario.

## 9. Buttondown

1. Crear cuenta en buttondown.email si no existe.
2. API key en settings → integrations → API. Copiar a `BUTTONDOWN_API_KEY`.

## 10. Resend

1. Crear API key en resend.com.
2. Verificar el dominio `conjuros.dev` (añadir registros DKIM/SPF en el DNS).
3. Copiar la API key a `RESEND_KEY`.

## 11. Smoke test post-deploy

- `https://conjuros.dev` carga (200, SSL válido)
- Registro de un usuario de prueba funciona + email de bienvenida llega
- `/admin` es accesible solo para admin
- `/planes` muestra los dos precios
- Checkout con tarjeta de prueba Stripe `4242 4242 4242 4242` en modo test redirige correctamente
- Webhook de Stripe registra eventos en `subscriptions` table
- Dashboard de Stripe muestra logs 2xx del webhook

## 12. Backups

- Configurar backups diarios de PostgreSQL en Forge → Backups.
- `storage/app/public/uploads/*` también debe estar en el backup (imágenes del TipTap).

---

*Última actualización: 2026-04-14*
