<?php
require_once __DIR__ . '/../core/bootstrap.php';
$auth->logout();
Utils::redirect('/');
