<?php
require 'db.php';

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Total count for pagination
$totalResult = $conn->query("SELECT COUNT(*) as count FROM expenses");
$totalRows = $totalResult->fetch_assoc()['count'];
$totalPages = ceil($totalRows / $limit);

// Fetch ALL expenses for calculations
$allQuery = $conn->query("SELECT amount FROM expenses");
$allExpenses = [];
while ($row = $allQuery->fetch_assoc()) {
    $allExpenses[] = $row;
}

// Fetch paginated expenses with all details
$query = $conn->query("SELECT * FROM expenses ORDER BY expense_date DESC LIMIT $limit OFFSET $offset");
$expenses = [];
while ($row = $query->fetch_assoc()) {
    $expenses[] = $row;
}

// Core PHP functions
function getTotal($arr) {
    $sum = 0;
    foreach ($arr as $exp) {
        $sum += $exp['amount'];
    }
    return $sum;
}
function getExtreme($arr, $type = 'max') {
    if (empty($arr)) return 0;
    $amounts = array_column($arr, 'amount');
    return $type === 'max' ? max($amounts) : min($amounts);
}
function getAverage($arr) {
    return count($arr) > 0 ? getTotal($arr) / count($arr) : 0;
}

$total = getTotal($allExpenses);
$highest = getExtreme($allExpenses, 'max');
$lowest = getExtreme($allExpenses, 'min');
$average = getAverage($allExpenses);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Expense Highlights</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e0e7ef 100%);
            min-height: 100vh;
        }
        .navbar-brand {
            font-weight: bold;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
        }
        .navbar-logo {
            width: 36px;
            height: 36px;
            margin-right: 10px;
        }
        .sidebar {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.07);
            padding: 32px 0;
            min-height: 80vh;
        }
        .sidebar .nav-link {
            color: #4f8cff;
            font-weight: 500;
            margin-bottom: 12px;
            border-radius: 8px 0 0 8px;
        }
        .sidebar .nav-link.active, .sidebar .nav-link:hover {
            background: linear-gradient(90deg, #4f8cff10 0%, #6ed6ff10 100%);
            color: #2563eb;
        }
        .card {
            border: none;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.07);
        }
        .highlight-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #333;
        }
        .highlight-value {
            font-size: 1.5rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Logo" class="navbar-logo">
            ExpensePro
        </a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link active" href="dashboard.php">Dashboard</a></li>
                <li class="nav-item ms-lg-3">
                    <a class="btn btn-primary px-4 fw-bold shadow-sm" href="#">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid mt-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-2 mb-4">
            <div class="sidebar d-flex flex-column">
                <nav class="nav flex-column w-100">
                    <a class="nav-link" href="dashboard.php"><i class="bi bi-house-door me-2"></i> Overview</a>
                    <a class="nav-link" href="expenses.php"><i class="bi bi-wallet2 me-2"></i> Expenses</a>
                    <a class="nav-link active" href="expense-highlight.php"><i class="bi bi-bar-chart-line me-2"></i> Highlights</a>
                    <a class="nav-link" href="#settings"><i class="bi bi-gear me-2"></i> Settings</a>
                </nav>
            </div>
        </div>

        <!-- Main -->
        <div class="col-lg-10">
            <h4 class="fw-bold mb-3">Expense Highlights</h4>
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card p-3 bg-light">
                        <div class="highlight-title">Total</div>
                        <div class="highlight-value text-success">₹<?= number_format($total, 2) ?></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3 bg-light">
                        <div class="highlight-title">Highest</div>
                        <div class="highlight-value text-danger">₹<?= number_format($highest, 2) ?></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3 bg-light">
                        <div class="highlight-title">Lowest</div>
                        <div class="highlight-value text-info">₹<?= number_format($lowest, 2) ?></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3 bg-light">
                        <div class="highlight-title">Average</div>
                        <div class="highlight-value text-primary">₹<?= number_format($average, 2) ?></div>
                    </div>
                </div>
            </div>

            <!-- Expense List Table -->
            <div class="card p-4">
                <h5 class="mb-3">Recent Expenses</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Amount</th>
                                <th>Category</th>
                                
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($expenses as $exp): ?>
                            <tr>
                                <td><?= htmlspecialchars($exp['id']) ?></td>
                                <td><?= htmlspecialchars($exp['title']) ?></td>
                                <td>₹<?= number_format($exp['amount'], 2) ?></td>
                                <td><?= htmlspecialchars($exp['category']) ?></td>
          
                                <td><?= htmlspecialchars($exp['expense_date']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <nav>
                    <ul class="pagination justify-content-center">
                        <?php if ($page > 1): ?>
                            <li class="page-item"><a class="page-link" href="?page=<?= $page - 1 ?>">Prev</a></li>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        <?php if ($page < $totalPages): ?>
                            <li class="page-item"><a class="page-link" href="?page=<?= $page + 1 ?>">Next</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
</body>
</html>
