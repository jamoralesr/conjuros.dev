<?php

namespace App\Enums;

enum ResourceType: string
{
    case Prompt = 'prompt';
    case Skill = 'skill';
    case Command = 'command';
    case Hook = 'hook';
    case Agent = 'agent';
    case Snippet = 'snippet';
    case Link = 'link';
    case Tool = 'tool';
    case Doc = 'doc';

    public function label(): string
    {
        return match ($this) {
            self::Prompt => 'Prompt',
            self::Skill => 'Skill',
            self::Command => 'Comando',
            self::Hook => 'Hook',
            self::Agent => 'Agente',
            self::Snippet => 'Snippet',
            self::Link => 'Enlace',
            self::Tool => 'Herramienta',
            self::Doc => 'Documentación',
        };
    }

    public function hasBody(): bool
    {
        return in_array($this, [
            self::Prompt,
            self::Skill,
            self::Command,
            self::Hook,
            self::Agent,
            self::Snippet,
        ]);
    }

    public function hasUrl(): bool
    {
        return in_array($this, [self::Link, self::Tool, self::Doc]);
    }

    public function supportsModel(): bool
    {
        return in_array($this, [self::Prompt, self::Skill, self::Agent]);
    }
}
