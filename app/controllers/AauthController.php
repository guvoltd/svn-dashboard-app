<?php

class AuthController
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $stmt = DB::get()->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role']
                ];
                $redirect = $user['role'] === 'admin' ? 'admin/dashboard' : 'user/home';
                header('Location: ' . BASE_URL . $redirect);
                exit;
            } else {
                $error = "Invalid credentials.";
            }
        }

        include __DIR__ . '/../views/auth/login.php';
    }

    public function logout()
    {
        session_destroy();
        header('Location: ' . BASE_URL . 'auth/login');
    }

    public function changePassword()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . 'auth/login');
            exit;
        }

        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $current = $_POST['current_password'];
            $new = $_POST['new_password'];
            $userId = $_SESSION['user']['id'];

            $stmt = DB::get()->prepare("SELECT password_hash FROM users WHERE id = ?");
            $stmt->execute([$userId]);
            $user = $stmt->fetch();

            if ($user && password_verify($current, $user['password_hash'])) {
                $newHash = password_hash($new, PASSWORD_BCRYPT);
                $update = DB::get()->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
                $update->execute([$newHash, $userId]);
                $success = "Password changed successfully.";
            } else {
                $error = "Current password is incorrect.";
            }
        }

        include __DIR__ . '/../views/auth/change_password.php';
    }
}
