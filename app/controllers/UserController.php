<?php

class UserController
{
    public function home()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
            header('Location: ' . BASE_URL . 'auth/login');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $db = DB::get();

        // Direct repository assignments
        $stmt = $db->prepare("SELECT repository_name FROM repository_assignments WHERE user_id = ?");
        $stmt->execute([$userId]);
        $userRepos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Group-based repository assignments
        $stmt = $db->prepare("
            SELECT DISTINCT rga.repository_name
            FROM group_memberships gm
            JOIN repository_group_assignments rga ON gm.group_id = rga.group_id
            WHERE gm.user_id = ?
        ");
        $stmt->execute([$userId]);
        $groupRepos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $repositories = array_unique(array_merge($userRepos, $groupRepos), SORT_REGULAR);

        include __DIR__ . '/../views/user/home.php';
    }

    public function createBranch()
    {
        // Will call SvnService in a later phase, placeholder here
    }

    public function diff()
    {
        // Will call SvnService in a later phase, placeholder here
    }
}
