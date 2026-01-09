<?php
class Audit
{
    public static function log(Database $db, ?int $userId, string $action, string $details): void
    {
        $db->execute(
            'INSERT INTO audit_logs (user_id, action, details, created_at) VALUES (:user_id, :action, :details, NOW())',
            [':user_id' => $userId, ':action' => $action, ':details' => $details]
        );
    }
}
