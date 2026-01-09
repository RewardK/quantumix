<?php
require_once __DIR__ . '/partials/header.php';
$message = '';
$settings = $db->fetchAll('SELECT * FROM settings');
$settingsMap = [];
foreach ($settings as $setting) {
    $settingsMap[$setting['name']] = $setting['value'];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $csrf->validate($_POST['csrf'] ?? '')) {
    $data = [
        'site_title' => trim($_POST['site_title'] ?? ''),
        'seo_description' => trim($_POST['seo_description'] ?? ''),
        'contact_email' => trim($_POST['contact_email'] ?? ''),
    ];
    foreach ($data as $name => $value) {
        $existing = $db->fetch('SELECT * FROM settings WHERE name = :name', [':name' => $name]);
        if ($existing) {
            $db->execute('UPDATE settings SET value = :value WHERE name = :name', [':value' => $value, ':name' => $name]);
        } else {
            $db->execute('INSERT INTO settings (name, value) VALUES (:name, :value)', [':name' => $name, ':value' => $value]);
        }
        $settingsMap[$name] = $value;
    }
    $message = 'Setări actualizate.';
    $user = $auth->user();
    Audit::log($db, $user['id'] ?? null, 'update_settings', 'site_settings');
}
?>
<section class="admin-section">
    <h2>Setări site</h2>
    <?php if ($message): ?><p class="success"><?= Utils::e($message) ?></p><?php endif; ?>
    <form method="post" class="form">
        <input type="hidden" name="csrf" value="<?= $csrf->token() ?>">
        <input type="text" name="site_title" placeholder="Titlu site" value="<?= Utils::e($settingsMap['site_title'] ?? '') ?>" required>
        <textarea name="seo_description" placeholder="Descriere SEO" required><?= Utils::e($settingsMap['seo_description'] ?? '') ?></textarea>
        <input type="email" name="contact_email" placeholder="Email contact" value="<?= Utils::e($settingsMap['contact_email'] ?? '') ?>" required>
        <button class="btn" type="submit">Salvează</button>
    </form>
</section>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
