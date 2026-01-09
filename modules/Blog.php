<?php
class Blog
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function posts(int $limit = 10, int $offset = 0, ?string $search = null): array
    {
        $sql = 'SELECT * FROM posts WHERE published = 1';
        $params = [];
        if ($search) {
            $sql .= ' AND (title_ro LIKE :search OR title_en LIKE :search OR title_de LIKE :search OR title_fr LIKE :search)';
            $params[':search'] = '%' . $search . '%';
        }
        $sql .= ' ORDER BY published_at DESC LIMIT :limit OFFSET :offset';
        $stmt = $this->db->pdo()->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function count(?string $search = null): int
    {
        $sql = 'SELECT COUNT(*) as total FROM posts WHERE published = 1';
        $params = [];
        if ($search) {
            $sql .= ' AND (title_ro LIKE :search OR title_en LIKE :search OR title_de LIKE :search OR title_fr LIKE :search)';
            $params[':search'] = '%' . $search . '%';
        }
        $row = $this->db->fetch($sql, $params);
        return (int)($row['total'] ?? 0);
    }

    public function findBySlug(string $slug): ?array
    {
        return $this->db->fetch('SELECT * FROM posts WHERE slug = :slug AND published = 1', [':slug' => $slug]);
    }

    public function categories(): array
    {
        return $this->db->fetchAll('SELECT * FROM categories ORDER BY name ASC');
    }

    public function comments(int $postId): array
    {
        return $this->db->fetchAll('SELECT * FROM comments WHERE post_id = :id AND approved = 1 ORDER BY created_at DESC', [':id' => $postId]);
    }

    public function addComment(int $postId, string $name, string $message): bool
    {
        return $this->db->execute(
            'INSERT INTO comments (post_id, name, message, approved, created_at) VALUES (:post_id, :name, :message, 1, NOW())',
            [':post_id' => $postId, ':name' => $name, ':message' => $message]
        );
    }
}
