# PRD — Conjuros.dev
## v0.4 — Abril 2026

---

## 1. Visión del Producto

**Conjuros.dev** es una plataforma de contenido educativo sobre desarrollo de software con Inteligencia Artificial, orientada a desarrolladores y personas que construyen con IA — con o sin conocimiento técnico profundo.

El nombre refleja la metáfora central del producto: el vibe coder emite conjuros en lenguaje natural y espera resultados. Conjuros.dev es el lugar donde se aprende lo que hay entre el conjuro y el resultado.

### Propósito dual
1. **Para el creador (Dumbo):** Flujo de ingresos paralelo a Siete PM. El proceso de creación de contenido resuelve problemas reales y genera aprendizaje aplicable a clientes y productos existentes.
2. **Para el lector:** Aprender metodologías, fundamentos y flujos de trabajo reales para desarrollar con IA — desde desarrolladores experimentados hasta vibe coders que construyen sin entender lo que construyen.

### Posicionamiento
- No es un blog técnico tradicional
- No es una academia de programación
- Es un **registro de oficio abierto** — problemas reales, laboratorios reales, decisiones documentadas con honestidad
- La IA (Claude) es co-creadora explícita en todo el contenido, no un detalle oculto

---

## 2. Audiencia Objetivo

### Idioma
El contenido es en **español**. El nicho hispanohablante de contenido técnico de calidad sobre desarrollo con IA está subatendido. No se contempla inglés en el corto o mediano plazo.

### Geografía
**Hispanohablantes globales**, con foco en Latinoamérica y España. Chile es la base operativa. España es un mercado secundario activo — hay contactos en Barcelona y posibilidad de sumar a alguien del equipo.

### Perfil primario — El vibe coder
- Construye software instruyendo herramientas de IA en lenguaje natural
- No tiene formación CS tradicional
- Quiere entender lo que construye, no solo que funcione
- Necesita vocabulario técnico para dirigir mejor a los agentes de IA
- **Objetivo práctico:** detectar errores, salir de bug loops, tomar mejores decisiones arquitectónicas

### Perfil secundario — El desarrollador que adopta IA
- Tiene base técnica (puede ser Laravel, Node, Python, cualquier stack)
- Está incorporando IA a su flujo de trabajo
- Busca metodologías probadas, no teoría
- Valora el código real sobre el código de ejemplo simplificado

### Fuera de scope (por ahora)
Audiencia no técnica (founders, PMs). Diluye el mensaje y complica la producción. Si llegan, bienvenidos, pero no se diseña para ellos.

---

## 3. Propuesta de Valor

- **Contenido desde la práctica real:** Todo laboratorio existe como proyecto funcional en GitHub. No hay código inventado para el artículo.
- **Proceso documentado:** Se muestra el cómo y el porqué, incluyendo decisiones descartadas y errores reales.
- **IA como co-creadora visible:** Claude se identifica explícitamente como parte del proceso. No hay pretensión de que el contenido es 100% humano.
- **Dos profundidades:** Contenido libre para llegar, contenido pro para profundizar.
- **Agnóstico al stack:** Los laboratorios usan la herramienta correcta para el problema. Laravel hoy, Python mañana si el problema lo pide.

---

## 4. Modelo de Contenido

### Tipos de contenido

**Artículo**
Formato libre. Noticia, opinión, tip, conjuro, reflexión. Sin laboratorio obligatorio. El más cercano a un blog tradicional. Principalmente libre.

**Tutorial**
Pieza única y autocontenida. Un problema, una solución, un flujo de trabajo. Laboratorio + repositorio GitHub asociado. Libre o pro. Puede ser la génesis de un curso pero no se convierte en él — mundos separados con ADN compartido.

**Curso**
Colección de lecciones con hilo conductor y progresión. Siempre pro. Repositorio GitHub propio que crece con cada lección. Una lección puede incluir un recurso interactivo HTML cuando el codebase lo justifica y la complejidad lo amerita.

**Recursos**
Todo lo que no tiene formato narrativo. Artefactos ejecutables o instruccionales que se usan, no solo se leen. Siempre libres — los recursos asociados a un curso pro son accesibles solo en ese contexto, pero como entidad propia un recurso no tiene paywall.

Los tipos de recursos son:

| Tipo | Descripción |
|------|-------------|
| `prompt` | Conjuro listo para usar, con contexto de uso y modelo objetivo |
| `skill` | Instrucción estructurada para agentes de IA |
| `command` | Comando de terminal o CLI documentado |
| `hook` | Punto de extensión o automatización |
| `agent` | Configuración de agente con stack y herramientas |
| `snippet` | Fragmento de código reutilizable |
| `link` | Enlace externo curado |
| `tool` | Herramienta externa referenciada |
| `doc` | Documentación de referencia |

### Nomenclatura de acceso
El acceso libre es libre, sin etiqueta. El acceso restringido se llama **pro**. En la UI se muestra un badge `Pro` donde aplique.

### Caducidad del contenido
El contenido caduca — se asume desde el inicio. La solución no es actualizarlo todo sino marcarlo. Cada artículo, tutorial y lección incluye una nota al inicio con el contexto de versión:

> *Escrito con Laravel 13 / Claude Sonnet 4 — abril 2026. Puede haber cambios en versiones posteriores.*

El proceso documentado no caduca. Los comandos y versiones sí.

### Anatomía de una lección (dentro de un curso)
- Artículo con código real y decisiones documentadas
- Fragmento del repositorio del curso
- Recurso interactivo HTML — opcional, cuando el codebase lo justifica

### Cadencia de publicación
- **Artículos:** 1 cada 2 semanas
- **Tutoriales o lecciones de curso:** 1 al mes

No se comunica cadencia públicamente hasta tener 3 meses de rodaje validado.

### Pipeline de producción (ya validado)
1. **Problema real** identificado en proyecto propio o de cliente
2. **Laboratorio aislado** — proyecto independiente en GitHub, sin ruido del proyecto real
3. **Contenido** — artículo, tutorial o lección según la naturaleza del problema
4. **Recurso interactivo HTML** — capa opcional aplicada por lección, no al curso completo

### Contenido existente listo para publicar

| Contenido | Tipo | Estado |
|-----------|------|--------|
| BlaBlaBot (Laravel AI SDK + Reverb + Livewire) | Tutorial pro | Listo |
| Laravel Cashier + Stripe (6 lecciones) | Curso | Listo |
| course.html — Hotel PMS | Recurso interactivo HTML | Demo / referencia |

---

## 5. Modelo de Negocio

### Membresía
- **Mensual:** USD 8/mes
- **Anual:** USD 80/año (equivale a ~2 meses gratis)
- La membresía desbloquea tutoriales pro y cursos

### Precio por contenido individual
No en MVP. La membresía es más simple de comunicar y de gestionar. Los precios por contenido generan fatiga de decisión. Se reevalúa en 12 meses si hay cursos que claramente lo justifican.

### Facturación
Factura Siete PM SpA.

### Plataforma de pagos
Laravel Cashier + Stripe. El laboratorio ya está construido y validado. No se evalúan alternativas para el MVP.

---

## 6. Arquitectura Técnica

### Un solo proyecto Laravel
Admin y frontend público conviven en el mismo codebase. No hay separación en dos proyectos. La arquitectura del Egghead Clone es la referencia directa: rutas separadas, layouts distintos, sin duplicar lógica.

### Stack
- Laravel 13 + Livewire 4 + Flux UI Pro v2 + Tailwind CSS v4
- `wire:navigate` para navegación SPA-like
- SEO manejado server-side — Laravel renderiza HTML completo

### Base de datos
PostgreSQL. Mejor soporte para JSON y búsqueda full-text nativa en el futuro.

### Hosting
Laravel Forge + Hetzner o DigitalOcean (VPS). Forge maneja deploys, Nginx y SSL sin gestión manual del servidor.

### Editor de contenido
TipTap en el admin (WYSIWYG). El body se almacena como HTML.

### Recursos interactivos HTML
Se sirven desde CDN (Cloudflare R2 o S3). Son archivos estáticos independientes del servidor Laravel.

### Autenticación

| Feature | Implementación |
|---------|---------------|
| Login / Logout | Fortify |
| Registro | Fortify |
| Reset de password | Fortify |
| Verificación de email | Fortify |
| Two-Factor Authentication (2FA) | Fortify (opcional) |
| API auth | Sanctum |

### Búsqueda
Meilisearch self-hosted en el mismo VPS, integrado con Laravel Scout. Se evalúa Algolia si el crecimiento lo justifica.

### Estructura de rutas

```
routes/
├── web.php          # Dashboard + includes
├── front.php        # Rutas públicas (artículos, tutoriales, cursos, búsqueda)
├── back.php         # Rutas admin (/admin/*)
└── settings.php     # Configuración de usuario
```

### Repositorios GitHub
- Cuenta GitHub dedicada a Conjuros.dev
- Repositorios públicos de laboratorios (el contenido)
- Repositorios privados de la plataforma

---

## 7. Marketing y Distribución

### Canales

**Distribución de contenido**
Cada pieza se publica en Conjuros.dev como fuente canónica y se distribuye en Medium, Dev.to, X y LinkedIn con canonical URL apuntando al sitio original.

**Newsletter**
- Transaccional: Resend
- Editorial (newsletter a suscriptores): Buttondown — fuera de la plataforma en el MVP

**Substack**
Descartado como plataforma principal. Si se usa, solo como espejo de distribución — la lista de emails vive en la plataforma propia.

**GitHub**
Los repositorios públicos de laboratorios son un canal de descubrimiento orgánico para desarrolladores.

### SEO
Habilitado desde el día 1, sin obsesión. Con Laravel SSR el SEO viene casi gratis. Lo mínimo por pieza: título, descripción, canonical, og:image.

### Estrategia de lanzamiento
Lanzamiento blando. Se publica el primer tutorial, se comparte en canales y se deja que el contenido haga el trabajo. No hay "gran lanzamiento" — paraliza y el primer contenido siempre es imperfecto.

---

## 8. Claude como co-creador

Esto es parte de la identidad del producto, no un disclaimer.

Claude participa en la generación de contenido, estructura de artículos y código. Se identifica siempre como co-creador. Es parte de la propuesta de valor y la honestidad editorial del proyecto.

### Cómo se comunica al lector

Una **página de metodología** dentro del sitio — no un disclaimer legal ni una nota al pie. La co-creación con Claude no es una advertencia, es algo de lo que estar orgulloso.

Contenido de la página:

> Conjuros.dev es un proyecto construido con IA, no a pesar de ella. Todo el contenido — artículos, tutoriales, cursos, código — se produce en colaboración activa con Claude. No como autocomplete, sino como co-autor: propone estructura, critica decisiones, escribe código, hace preguntas incómodas.
>
> Dumbo aporta el problema real, el criterio, la experiencia de haberlo vivido. Claude aporta velocidad, perspectiva y la capacidad de mantener coherencia a lo largo de un proyecto complejo.
>
> Esto no es una advertencia. Es el método.

Al final de cada pieza de contenido, una línea simple y consistente:

> *Escrito con Claude (Anthropic) — [mes año]*

Sin detalles de modelo ni temperatura. Solo autoría compartida, igual que se cita a un co-autor humano.

---

## 9. Métricas de Éxito

### MRR

El costo real de Conjuros no es el hosting — es el tiempo. El umbral tiene que cubrir ese tiempo de alguna forma.

| Hito | MRR | Significado |
|------|-----|-------------|
| Piso mínimo | USD 500/mes | Valida que hay un mercado que paga. Por debajo es un hobby con infraestructura. |
| Negocio real | USD 2.000/mes | Cubre costos, paga algo de tiempo, justifica priorizar contenido. |

El MRR se mide en dos dimensiones simultáneamente:

- **MRR directo:** ingresos de Conjuros.dev por sí solo
- **MRR apalancado:** estimación del valor generado para Siete PM (clientes atraídos, proyectos acelerados)

Hoy el apalancamiento es el argumento principal. En el futuro Conjuros podría necesitar sostenerse solo — y si ese momento llega, el umbral ya está definido y el dato histórico separado existe.

### Suscriptores en el tiempo

A USD 8/mes, los hitos se traducen así:

| Momento | Suscriptores pro | MRR aprox. |
|---------|-----------------|------------|
| 3 meses | 30 | USD 240 |
| 6 meses | 65 | USD 520 |
| 12 meses | 200 | USD 1.600 |
| Negocio real | 350 | USD 2.800 |

Números conservadores para un proyecto unipersonal en español sin presupuesto de marketing.

### Métricas de conversión

| Métrica | Objetivo | Señal de problema |
|---------|----------|-------------------|
| Conversión libre → pro | 4–6% | < 2%: el contenido pro no cumple lo que promete |
| Newsletter → pro | 8–12% | < 5%: problema de propuesta de valor o precio |
| Retención mensual pro | 85%+ | < 80%: el contenido no sostiene la membresía |

### Apalancamiento con Siete PM

No es un número — es una revisión trimestral con dos preguntas:

1. ¿Algún cliente de Siete PM llegó por Conjuros o mencionó haber visto contenido?
2. ¿Algún proyecto de Siete PM fue posible o más rápido por algo aprendido o documentado en Conjuros?

### Punto de quiebre con Siete PM

Conjuros no reemplaza activamente a Siete PM — al menos no como decisión planificada. La señal para rebalancear el tiempo no es un número de MRR sino la respuesta a las preguntas de apalancamiento.

Si en 12 meses Conjuros llega a USD 2.000 MRR **y** no ha generado ningún cliente para Siete PM, ahí tiene sentido evaluar si conviene dedicarle más tiempo como negocio independiente.

---

## 10. Funcionalidades Futuras

En orden de prioridad:

**1. "Necesito un curso de X tema"**
Sistema de solicitud de contenido por parte de miembros o empresas. Valida demanda antes de producir y abre canal de ingresos para cursos a medida (vía Siete PM).

**2. Sesiones en vivo**
Demostraciones y Q&A con miembros. Herramienta de lanzamiento y construcción de comunidad.

**3. Foro / Q&A**
Espacio comunitario entre miembros. Requiere masa crítica — fase tardía.

---

## 11. Resumen de Decisiones

| Decisión | Estado | Resolución |
|----------|--------|------------|
| Nombre | ✅ | Conjuros.dev |
| Dominio | ✅ | Comprado |
| Idioma | ✅ | Español |
| Geografía | ✅ | Hispanohablantes globales — foco en Latinoamérica y España |
| Stack | ✅ | Laravel 13 + Livewire 4 + Flux UI Pro v2 + Tailwind CSS v4 |
| Arquitectura | ✅ | Un solo proyecto Laravel (admin + front) |
| Base de datos | ✅ | PostgreSQL |
| Hosting | ✅ | Forge + Hetzner/DigitalOcean |
| Editor de contenido | ✅ | TipTap (HTML en DB) |
| Recursos interactivos | ✅ | CDN (Cloudflare R2 / S3) |
| Autenticación | ✅ | Fortify + Sanctum |
| Búsqueda | ✅ | Meilisearch self-hosted |
| Modelo de membresía | ✅ | USD 8/mes o USD 80/año |
| Plataforma de pagos | ✅ | Stripe + Laravel Cashier |
| Precio por contenido | ✅ | No en MVP |
| Newsletter | ✅ | Resend (transaccional) + Buttondown (editorial) |
| SEO | ✅ | Desde el día 1, básico |
| Lanzamiento | ✅ | Blando, sin fecha de "gran lanzamiento" |
| Cadencia de contenido | ✅ | 1 tutorial/mes, 1 artículo/2 semanas |
| Quien factura | ✅ | Siete PM SpA |
| Rol de Claude | ✅ | Co-creador explícito — página de metodología + línea de autoría |
| Métricas de éxito | ✅ | MRR directo + apalancado + conversión + retención |
| Fecha de MVP | ✅ | Jueves 17 de abril de 2026 |

---

*Documento generado en colaboración con Claude (Anthropic)*
*Versión: 0.4 — Abril 2026*
