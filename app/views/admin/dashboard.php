<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container py-5">
    <h2>Welcome, Admin <?= htmlspecialchars($_SESSION['user']['username']) ?></h2>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">SVN Activity Overview</div>
                <div class="card-body">
                    <canvas id="activityChart" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <a href="<?= BASE_URL ?>auth/changePassword" class="btn btn-warning mb-2">Change Password</a>
            <a href="<?= BASE_URL ?>auth/logout" class="btn btn-secondary mb-2">Logout</a>
        </div>
    </div>
</div>

<script>
const ctx = document.getElementById('activityChart').getContext('2d');
const activityChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($labels ?? ['No Data']) ?>,
        datasets: [{
            label: 'Actions',
            data: <?= json_encode($data ?? [0]) ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.7)'
        }]
    }
});
</script>
</body>
</html>
