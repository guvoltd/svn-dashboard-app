<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container py-5">
    <h2>Welcome, <?= htmlspecialchars($_SESSION['user']['username']) ?></h2>
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Your Repositories</h5>
            <ul class="list-group">
                <?php foreach ($repositories as $repo): ?>
                    <li class="list-group-item"><?= htmlspecialchars($repo['repository_name']) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="mt-4">
        <a href="<?= BASE_URL ?>auth/changePassword" class="btn btn-warning">Change Password</a>
        <a href="<?= BASE_URL ?>auth/logout" class="btn btn-secondary">Logout</a>
    </div>
</div>
</body>
</html>
