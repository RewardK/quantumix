<?php
class Auth
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function attempt(string $email, string $password): bool
    {
        $user = $this->db->fetch('SELECT * FROM users WHERE email = :email LIMIT 1', [
            ':email' => $email,
        ]);
        if (!$user || !password_verify($password, $user['password_hash'])) {
            return false;
        }
        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
        ];
        $this->db->execute('UPDATE users SET last_login_at = NOW() WHERE id = :id', [':id' => $user['id']]);
        return true;
    }

    public function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    public function check(): bool
    {
        return isset($_SESSION['user']);
    }

    public function logout(): void
    {
        unset($_SESSION['user']);
        session_regenerate_id(true);
    }

    public function requireRole(array $roles): void
    {
        $user = $this->user();
        if (!$user || !in_array($user['role'], $roles, true)) {
            Utils::redirect('/admin/login.php');
        }
    }
}
