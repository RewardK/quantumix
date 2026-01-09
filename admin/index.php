<?php
require_once __DIR__ . '/../core/bootstrap.php';
if ($auth->check()) {
    Utils::redirect('/admin/dashboard.php');
}
Utils::redirect('/admin/login.php');
