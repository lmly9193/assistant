<?php

if (! function_exists('external_url')) {
    function external_url(string $url, array $data): string
    {
        return $url . http_build_query(data: $data, encoding_type: PHP_QUERY_RFC3986);
    }
}

if (!function_exists('ui_avatars')) {
    function ui_avatars(string $name, string $background = '09090b', string $color = 'FFFFFF'): string
    {
        return external_url('https://ui-avatars.com/api/?', [
            'name'       => $name,
            'background' => $background,
            'color'      => $color,
        ]);
    }
}
