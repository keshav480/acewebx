<?php

namespace App\Helpers;

class ShortcodeManager
{
    protected static array $shortcodes = [];

    // Register a shortcode
    public static function register(string $tag, callable $callback)
    {
        self::$shortcodes[$tag] = $callback;
    }

    // Parse the content for shortcodes
    public static function parse(string $content)
    {
        return preg_replace_callback('/\["(\w+)"(.*?)\]/', function ($matches) {
        $tag = $matches[1];
        $attrs = trim($matches[2]);

        // Parse attributes like key="value"
        $attributes = [];
        if ($attrs) {
            preg_match_all('/(\w+)="([^"]+)"/', $attrs, $attrMatches, PREG_SET_ORDER);
            foreach ($attrMatches as $attr) {
                $attributes[$attr[1]] = $attr[2];
            }
        }

        if (isset(self::$shortcodes[$tag])) {
            return call_user_func(self::$shortcodes[$tag], $attributes);
        }

        return $matches[0]; 
    }, $content);
    }
}
