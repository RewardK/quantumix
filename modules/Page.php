<?php
class Page
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function findBySlug(string $slug): ?array
    {
        return $this->db->fetch('SELECT * FROM pages WHERE slug = :slug', [':slug' => $slug]);
    }
}
