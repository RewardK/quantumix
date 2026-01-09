<?php
class Project
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function all(): array
    {
        return $this->db->fetchAll('SELECT * FROM projects ORDER BY created_at DESC');
    }

    public function findBySlug(string $slug): ?array
    {
        return $this->db->fetch('SELECT * FROM projects WHERE slug = :slug', [':slug' => $slug]);
    }

    public function images(int $projectId): array
    {
        return $this->db->fetchAll('SELECT * FROM project_images WHERE project_id = :id', [':id' => $projectId]);
    }

    public function create(array $data): string
    {
        $this->db->execute(
            'INSERT INTO projects (name_ro, name_en, name_de, name_fr, slug, category, description_ro, description_en, description_de, description_fr, created_at)
             VALUES (:name_ro, :name_en, :name_de, :name_fr, :slug, :category, :description_ro, :description_en, :description_de, :description_fr, NOW())',
            $data
        );
        return $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $data[':id'] = $id;
        return $this->db->execute(
            'UPDATE projects SET name_ro = :name_ro, name_en = :name_en, name_de = :name_de, name_fr = :name_fr, slug = :slug, category = :category,
            description_ro = :description_ro, description_en = :description_en, description_de = :description_de, description_fr = :description_fr WHERE id = :id',
            $data
        );
    }

    public function delete(int $id): bool
    {
        return $this->db->execute('DELETE FROM projects WHERE id = :id', [':id' => $id]);
    }
}
