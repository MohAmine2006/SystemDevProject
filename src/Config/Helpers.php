<?php
namespace App\Config;

class Helpers
{
    public static function url(string $path = ''): string
    {
        $basePath = rtrim($_ENV['BASE_PATH'] ?? '', '/');
        $path = '/' . ltrim($path, '/');
        return $basePath . $path;
    }

    public static function redirect($response, string $path)
    {
        return $response->withHeader('Location', self::url($path))->withStatus(302);
    }

    public static function money(float|string|null $value): string
    {
        return '$' . number_format((float)$value, 2);
    }

    public static function stockStatus(array $product): string
    {
        $qty = (int)$product['quantity'];
        if ($qty <= (int)$product['low_stock_threshold']) return 'Low Stock';
        if ($qty >= (int)$product['max_stock_threshold']) return 'Overstocked';
        return 'In Stock';
    }
}
