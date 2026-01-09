<?php
$config = require __DIR__ . '/../config/config.php';

date_default_timezone_set($config['site']['timezone']);

ini_set('session.use_strict_mode', '1');
ini_set('session.use_only_cookies', '1');
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_samesite', 'Lax');

session_name($config['security']['session_name']);
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Utils.php';
require_once __DIR__ . '/Csrf.php';
require_once __DIR__ . '/Auth.php';
require_once __DIR__ . '/Mailer.php';
require_once __DIR__ . '/I18n.php';
require_once __DIR__ . '/Audit.php';
require_once __DIR__ . '/Cache.php';

$db = new Database($config['db']);
$auth = new Auth($db);
$csrf = new Csrf($config['security']['csrf_key']);
$i18n = new I18n();
$cache = new Cache(__DIR__ . '/../logs/cache');
