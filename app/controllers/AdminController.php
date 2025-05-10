<?php

class AdminController
{
    public function dashboard()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: ' . BASE_URL . 'auth/login');
            exit;
        }

        $stmt = DB::get()->query("SELECT action_type, COUNT(*) as total FROM svn_activity_logs GROUP BY action_type");
        $stats = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $labels = array_column($stats, 'action_type');
        $data = array_column($stats, 'total');

        include __DIR__ . '/../views/admin/dashboard.php';
    }

    public function regenerate()
    {
        AuthzManager::regenerateAuthz();
        PasswdManager::regeneratePasswd();

        $stmt = DB::get()->prepare("INSERT INTO admin_actions (admin_id, action, metadata) VALUES (?, ?, ?)");
        $stmt->execute([
            $_SESSION['user']['id'],
            'regenerate_auth_files',
            json_encode(['ip' => $_SERVER['REMOTE_ADDR']])
        ]);

        $_SESSION['message'] = "Authz and passwd files regenerated.";
        header('Location: ' . BASE_URL . 'admin/dashboard');
    }

    public function manageGroups() { /* added in Phase 5 */ }
    public function exclude() { /* added in Phase 5 */ }
    public function logs() { /* added in Phase 5 */ }
}
