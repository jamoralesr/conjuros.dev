<x-layouts::front>
    <article class="mx-auto max-w-3xl py-6">
        <flux:heading size="xl" class="!text-4xl">Cómo hacemos Conjuros</flux:heading>

        <div class="prose prose-zinc mt-8 max-w-none text-lg dark:prose-invert">
            <p>
                <strong>Conjuros.dev es un proyecto construido con IA, no a pesar de ella.</strong>
                Todo el contenido — artículos, tutoriales, cursos, código — se produce en colaboración activa con Claude.
                No como autocomplete, sino como co-autor: propone estructura, critica decisiones, escribe código, hace preguntas incómodas.
            </p>

            <p>
                Dumbo aporta el problema real, el criterio, la experiencia de haberlo vivido.
                Claude aporta velocidad, perspectiva y la capacidad de mantener coherencia a lo largo de un proyecto complejo.
            </p>

            <p><em>Esto no es una advertencia. Es el método.</em></p>

            <hr />

            <h2>Cómo funciona el pipeline</h2>
            <ol>
                <li><strong>Problema real</strong> identificado en proyecto propio o de cliente.</li>
                <li><strong>Laboratorio aislado</strong> — proyecto independiente en GitHub, sin ruido del proyecto real.</li>
                <li><strong>Contenido</strong> — artículo, tutorial o lección según la naturaleza del problema.</li>
                <li><strong>Recurso interactivo HTML</strong> — capa opcional aplicada por lección, cuando el codebase lo justifica.</li>
            </ol>

            <h2>Caducidad</h2>
            <p>
                El contenido caduca — se asume desde el inicio. La solución no es actualizarlo todo sino marcarlo.
                Cada pieza incluye el contexto de versión: el stack y el modelo de IA con los que fue escrita.
                El proceso documentado no caduca. Los comandos y versiones sí.
            </p>
        </div>
    </article>
</x-layouts::front>
