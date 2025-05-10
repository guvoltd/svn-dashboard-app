CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE user_groups (
    id INT AUTO_INCREMENT PRIMARY KEY,
    group_name VARCHAR(100) UNIQUE NOT NULL,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE group_memberships (
    id INT AUTO_INCREMENT PRIMARY KEY,
    group_id INT,
    user_id INT,
    FOREIGN KEY (group_id) REFERENCES user_groups(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE repository_assignments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    repository_name VARCHAR(100),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE repository_group_assignments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    group_id INT,
    repository_name VARCHAR(100),
    FOREIGN KEY (group_id) REFERENCES user_groups(id)
);

CREATE TABLE repository_exclusions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    repository_name VARCHAR(100),
    path VARCHAR(255),
    excluded_for_users TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE svn_activity_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action_type VARCHAR(50),
    repository_name VARCHAR(100),
    details TEXT,
    action_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE admin_actions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    admin_id INT,
    action TEXT,
    metadata TEXT,
    action_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE repository_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    repository_name VARCHAR(100) UNIQUE NOT NULL,
    settings JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE repository_access (
    id INT AUTO_INCREMENT PRIMARY KEY,
    repository_name VARCHAR(100),
    user_id INT,
    access_level ENUM('read', 'write', 'admin'),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE repository_group_access (
    id INT AUTO_INCREMENT PRIMARY KEY,
    repository_name VARCHAR(100),
    group_id INT,
    access_level ENUM('read', 'write', 'admin'),
    FOREIGN KEY (group_id) REFERENCES user_groups(id)
);

CREATE TABLE repository_webhooks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    repository_name VARCHAR(100),
    webhook_url VARCHAR(255),
    events TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE repository_webhook_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    webhook_id INT,
    status_code INT,
    response TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (webhook_id) REFERENCES repository_webhooks(id)
);

