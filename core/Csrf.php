<?php
class Csrf
{
    private string $key;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function token(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return hash_hmac('sha256', $_SESSION['csrf_token'], $this->key);
    }

    public function validate(?string $token): bool
    {
        if (empty($_SESSION['csrf_token']) || !$token) {
            return false;
        }
        $expected = hash_hmac('sha256', $_SESSION['csrf_token'], $this->key);
        return hash_equals($expected, $token);
    }
}
