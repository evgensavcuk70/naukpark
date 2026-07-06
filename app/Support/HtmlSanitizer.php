<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMXPath;

class HtmlSanitizer
{
    private const ALLOWED_TAGS = [
        'p', 'br', 'strong', 'b', 'em', 'i', 'u', 's',
        'ul', 'ol', 'li',
        'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
        'blockquote', 'a', 'img', 'span', 'div',
    ];

    private const ALLOWED_ATTRIBUTES = [
        'a'   => ['href', 'title', 'target', 'rel'],
        'img' => ['src', 'alt', 'title', 'width', 'height'],
    ];

    public static function clean(?string $html): string
    {
        $html = trim((string) $html);

        if ($html === '') {
            return '';
        }

        $dom = new DOMDocument();

        libxml_use_internal_errors(true);
        $dom->loadHTML(
            '<?xml encoding="utf-8" ?><div id="__root__">' . $html . '</div>',
            LIBXML_NOWARNING | LIBXML_NOERROR
        );
        libxml_clear_errors();

        $xpath = new DOMXPath($dom);
        $root = $xpath->query('//*[@id="__root__"]')->item(0);

        if (! $root) {
            return '';
        }

        self::sanitizeNode($dom, $root);

        $output = '';
        foreach (iterator_to_array($root->childNodes) as $child) {
            $output .= $dom->saveHTML($child);
        }

        return trim($output);
    }

    private static function sanitizeNode(DOMDocument $dom, DOMNode $node): void
    {
        $children = iterator_to_array($node->childNodes);

        foreach ($children as $child) {
            if ($child instanceof DOMElement) {
                $tag = strtolower($child->tagName);

                if (! in_array($tag, self::ALLOWED_TAGS, true)) {
                    if (in_array($tag, ['script', 'style', 'iframe', 'object', 'embed', 'form'], true)) {
                        $node->removeChild($child);
                        continue;
                    }

                    foreach (iterator_to_array($child->childNodes) as $grandChild) {
                        $node->insertBefore($grandChild, $child);
                    }
                    $node->removeChild($child);
                    continue;
                }

                self::sanitizeAttributes($child, $tag);
                self::sanitizeNode($dom, $child);
            }
        }
    }

    private static function sanitizeAttributes(DOMElement $element, string $tag): void
    {
        $allowed = self::ALLOWED_ATTRIBUTES[$tag] ?? [];

        foreach (iterator_to_array($element->attributes) as $attr) {
            $name = strtolower($attr->name);

            if (str_starts_with($name, 'on') || ! in_array($name, $allowed, true)) {
                $element->removeAttribute($attr->name);
                continue;
            }

            if (in_array($name, ['href', 'src'], true)) {
                $value = trim($attr->value);
                $normalized = strtolower(preg_replace('/\s+/', '', $value));

                if (str_starts_with($normalized, 'javascript:') || str_starts_with($normalized, 'data:text/html')) {
                    $element->removeAttribute($attr->name);
                }
            }
        }

        if ($tag === 'a' && $element->getAttribute('target') === '_blank') {
            $element->setAttribute('rel', 'noopener noreferrer');
        }
    }
}
