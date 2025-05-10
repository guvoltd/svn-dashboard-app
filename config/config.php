<?php

// Database
define('DB_HOST', 'localhost');
define('DB_NAME', 'svn_dashboard');
define('DB_USER', 'root');
define('DB_PASS', '');

// Base URL (adjust to your project folder under localhost)
define('BASE_URL', '/svn-dashboard-app/public/');

// SVN repository root path
define('SVN_REPO_BASE', '/var/svn/');

// Paths to generated files
define('AUTHZ_FILE', __DIR__ . '/../data/authz');
define('PASSWD_FILE', __DIR__ . '/../data/passwd');

// Other settings
define('DEBUG', true);
