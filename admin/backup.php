<?php
require_once __DIR__ . '/partials/header.php';
if (isset($_GET['download']) && $csrf->validate($_GET['csrf'] ?? '')) {
    $user = $auth->user();
    Audit::log($db, $user['id'] ?? null, 'download_backup', 'full_export');
    $tables = $db->fetchAll('SHOW TABLES');
    $sql = "";
    foreach ($tables as $tableRow) {
        $table = array_values($tableRow)[0];
        $create = $db->fetch("SHOW CREATE TABLE `$table`");
        $sql .= $create['Create Table'] . ";\n\n";
        $rows = $db->fetchAll("SELECT * FROM `$table`");
        foreach ($rows as $row) {
            $columns = array_map(fn($col) => "`$col`", array_keys($row));
            $values = array_map(function ($value) use ($db) {
                if ($value === null) {
                    return 'NULL';
                }
                return $db->pdo()->quote((string)$value);
            }, array_values($row));
            $sql .= "INSERT INTO `$table` (" . implode(',', $columns) . ") VALUES (" . implode(',', $values) . ");\n";
        }
        $sql .= "\n";
    }
    header('Content-Type: application/sql');
    header('Content-Disposition: attachment; filename="quantumix-backup.sql"');
    echo $sql;
    exit;
}
?>
<section class="admin-section">
    <h2>Backup DB</h2>
    <p>Generează un export complet SQL al bazei de date.</p>
    <a class="btn" href="/admin/backup.php?download=1&csrf=<?= $csrf->token() ?>">Descarcă backup</a>
</section>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
