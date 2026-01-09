<?php
class Cache
{
    private string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function get(string $key, int $ttl): ?array
    {
        $file = $this->path . '/' . $key . '.json';
        if (!file_exists($file)) {
            return null;
        }
        if (time() - filemtime($file) > $ttl) {
            return null;
        }
        $content = file_get_contents($file);
        return json_decode($content, true);
    }

    public function set(string $key, array $data): void
    {
        if (!is_dir($this->path)) {
            mkdir($this->path, 0755, true);
        }
        file_put_contents($this->path . '/' . $key . '.json', json_encode($data));
    }
}
