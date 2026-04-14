<?php

namespace App\Support;

class ContentGate
{
    /**
     * Truncate HTML body to the first N characters, preserving tag integrity.
     */
    public static function preview(?string $html, int $maxChars = 1500): string
    {
        if (blank($html)) {
            return '';
        }

        $plain = strip_tags($html);

        if (mb_strlen($plain) <= $maxChars) {
            return $html;
        }

        $length = 0;
        $open = [];
        $result = '';
        $len = mb_strlen($html);

        for ($i = 0; $i < $len; $i++) {
            $char = mb_substr($html, $i, 1);

            if ($char === '<') {
                $tagEnd = mb_strpos($html, '>', $i);
                if ($tagEnd === false) {
                    break;
                }
                $tag = mb_substr($html, $i, $tagEnd - $i + 1);
                $result .= $tag;

                if (preg_match('#^</(\w+)#', $tag, $m)) {
                    array_pop($open);
                } elseif (preg_match('#^<(\w+)(?:\s[^>]*)?(/?)>$#', $tag, $m)) {
                    if ($m[2] !== '/' && ! in_array(strtolower($m[1]), ['br', 'hr', 'img', 'input'])) {
                        $open[] = $m[1];
                    }
                }

                $i = $tagEnd;

                continue;
            }

            $result .= $char;
            $length++;

            if ($length >= $maxChars) {
                break;
            }
        }

        while ($tag = array_pop($open)) {
            $result .= "</{$tag}>";
        }

        return $result;
    }
}
