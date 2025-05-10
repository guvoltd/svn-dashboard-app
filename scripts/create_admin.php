<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/db.php';

$username = 'admin';
$password = 'admin123';

$hash = password_hash($password, PASSWORD_BCRYPT);

$stmt = DB::get()->prepare("INSERT INTO users (username, password_hash, role) VALUES (?, ?, 'admin')");
$stmt->execute([$username, $hash]);

echo "Admin user 'admin' created with password 'admin123'.\n";
