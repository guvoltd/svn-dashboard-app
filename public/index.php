<?php
session_start();

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/helpers/router.php';

// Autoloader
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../app/controllers/',
        __DIR__ . '/../app/models/',
        __DIR__ . '/../app/svn/',
        __DIR__ . '/../app/middleware/',
        __DIR__ . '/../app/helpers/'
    ];
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }
});

// Routing
$route = $_GET['route'] ?? 'auth/login';
dispatch($route);
