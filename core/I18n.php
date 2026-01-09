<?php
class I18n
{
    private array $supported = ['ro', 'en', 'de', 'fr'];

    public function current(): string
    {
        if (!empty($_GET['lang']) && in_array($_GET['lang'], $this->supported, true)) {
            $_SESSION['lang'] = $_GET['lang'];
        }
        return $_SESSION['lang'] ?? 'ro';
    }

    public function t(array $values): string
    {
        $lang = $this->current();
        return $values[$lang] ?? $values['ro'] ?? reset($values);
    }
}
