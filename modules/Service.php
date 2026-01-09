<?php
class Service
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function all(): array
    {
        return $this->db->fetchAll('SELECT * FROM services ORDER BY created_at DESC');
    }

    public function findBySlug(string $slug): ?array
    {
        return $this->db->fetch('SELECT * FROM services WHERE slug = :slug', [':slug' => $slug]);
    }

    public function create(array $data): string
    {
        $this->db->execute(
            'INSERT INTO services (name_ro, name_en, name_de, name_fr, slug, icon, description_ro, description_en, description_de, description_fr, benefits, created_at)
             VALUES (:name_ro, :name_en, :name_de, :name_fr, :slug, :icon, :description_ro, :description_en, :description_de, :description_fr, :benefits, NOW())',
            $data
        );
        return $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $data[':id'] = $id;
        return $this->db->execute(
            'UPDATE services SET name_ro = :name_ro, name_en = :name_en, name_de = :name_de, name_fr = :name_fr, slug = :slug, icon = :icon,
            description_ro = :description_ro, description_en = :description_en, description_de = :description_de, description_fr = :description_fr, benefits = :benefits WHERE id = :id',
            $data
        );
    }

    public function delete(int $id): bool
    {
        return $this->db->execute('DELETE FROM services WHERE id = :id', [':id' => $id]);
    }
}
