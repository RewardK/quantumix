<?php
class Utils
{
    public static function e(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    public static function slug(string $value): string
    {
        $value = strtolower(trim($value));
        $value = preg_replace('/[^a-z0-9\s-]/', '', $value);
        $value = preg_replace('/[\s-]+/', '-', $value);
        return trim($value, '-');
    }

    public static function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }

    public static function baseUrl(array $config): string
    {
        $base = rtrim($config['site']['base_url'], '/');
        return $base === '' ? '' : $base;
    }

    public static function formatDate(string $date): string
    {
        return date('d.m.Y', strtotime($date));
    }
}
