@props([
    'label' => null,
    'description' => null,
])

<flux:editor :label="$label" :description="$description" {{ $attributes }}>
    <flux:editor.toolbar>
        <flux:editor.heading />
        <flux:editor.separator />
        <flux:editor.bold />
        <flux:editor.italic />
        <flux:editor.strike />
        <flux:editor.underline />
        <flux:editor.separator />
        <flux:editor.bullet />
        <flux:editor.ordered />
        <flux:editor.blockquote />
        <flux:editor.separator />
        <flux:editor.code />
        <flux:editor.button data-editor="code-block" tooltip="Bloque de código" kbd="⌘⇧C">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5" aria-hidden="true">
                <path fill-rule="evenodd" d="M4.5 2A1.5 1.5 0 0 0 3 3.5v13A1.5 1.5 0 0 0 4.5 18h11a1.5 1.5 0 0 0 1.5-1.5v-13A1.5 1.5 0 0 0 15.5 2h-11ZM7.28 7.72a.75.75 0 0 1 0 1.06L5.81 10.25l1.47 1.47a.75.75 0 1 1-1.06 1.06l-2-2a.75.75 0 0 1 0-1.06l2-2a.75.75 0 0 1 1.06 0Zm5.44 0a.75.75 0 0 1 1.06 0l2 2a.75.75 0 0 1 0 1.06l-2 2a.75.75 0 1 1-1.06-1.06l1.47-1.47-1.47-1.47a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
            </svg>
        </flux:editor.button>
        <flux:editor.button data-editor="hr" tooltip="Separador horizontal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5" aria-hidden="true">
                <path fill-rule="evenodd" d="M3 10a.75.75 0 0 1 .75-.75h12.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 10Z" clip-rule="evenodd" />
            </svg>
        </flux:editor.button>
        <flux:editor.separator />
        <flux:editor.link />
        <flux:editor.separator />
        <flux:editor.align />
        <flux:spacer />
        <flux:editor.undo />
        <flux:editor.redo />
    </flux:editor.toolbar>
    <flux:editor.content />
</flux:editor>
