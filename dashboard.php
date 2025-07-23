<?php
require 'db.php';

$monthStart = date('Y-m-01');
$today = date('Y-m-d');

// Summary Data
$totalMonth = $conn->query("SELECT SUM(amount) AS total FROM expenses WHERE expense_date >= '$monthStart'")
  ->fetch_assoc()['total'] ?? 0;

$categoryCount = $conn->query("SELECT COUNT(DISTINCT category) AS cnt FROM expenses")
  ->fetch_assoc()['cnt'] ?? 0;

$totalToday = $conn->query("SELECT SUM(amount) AS total FROM expenses WHERE expense_date = '$today'")
  ->fetch_assoc()['total'] ?? 0;

$totalAll = $conn->query("SELECT SUM(amount) AS total FROM expenses")
  ->fetch_assoc()['total'] ?? 0;

// Pagination
$limit = 5;
$page = max(1, intval($_GET['page'] ?? 1));
$offset = ($page - 1) * $limit;
$totalRows = $conn->query("SELECT COUNT(*) as total FROM expenses")->fetch_assoc()['total'] ?? 0;
$totalPages = ceil($totalRows / $limit);

$recentActivities = $conn->query("SELECT * FROM expenses ORDER BY expense_date DESC LIMIT $offset, $limit");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ExpensePro Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { background: linear-gradient(135deg,#f8fafc,#e0e7ef); min-height:100vh; }
    .card { border:none;border-radius:18px;transition:all .2s;box-shadow:0 4px 24px rgba(0,0,0,.07);}
    .card:hover { transform:translateY(-4px) scale(1.01); box-shadow:0 8px 32px rgba(79,140,255,.13);}
    .summary-icon {font-size:2.2rem;color:#4f8cff;background:#e0e7ef;border-radius:50%;padding:12px;margin-right:16px;}
    .sidebar {background:#fff;border-radius:18px;box-shadow:0 4px 24px rgba(0,0,0,.07);padding:32px 0;min-height:100vh;}
    #expenseChart { min-height: 320px; }
  </style>
</head>
<body>
<div class="container-fluid">
  <nav class="navbar navbar-light bg-white shadow-sm mb-4">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">
        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Logo" style="width:36px;height:36px;margin-right:10px;">
        ExpensePro
      </a>
      <a class="btn btn-primary" href="#">Logout</a>
    </div>
  </nav>

  <div class="row">
    <div class="col-lg-2">
      <div class="sidebar">
        <nav class="nav flex-column">
          <a class="nav-link active" href="dashboard.php"><i class="bi bi-house-door me-2"></i>Overview</a>
          <a class="nav-link" href="expenses.php"><i class="bi bi-wallet2 me-2"></i>Expenses</a>
          <a class="nav-link" href="expense-highlight.php"><i class="bi bi-bar-chart-line me-2"></i>Highlights</a>
          <a class="nav-link" href="#"><i class="bi bi-gear me-2"></i>Settings</a>
        </nav>
      </div>
    </div>

    <div class="col-lg-10">
      <h2 class="fw-bold mb-4">Dashboard Overview</h2>
      <div class="row g-4 mb-4">
        <?php foreach ([
          ['icon'=>'currency-dollar','val'=>$totalAll,'label'=>'Total (All Time)'],
          ['icon'=>'calendar2-week','val'=>$totalMonth,'label'=>'This Month'],
          ['icon'=>'tags','val'=>$categoryCount,'label'=>'Categories'],
          ['icon'=>'clock-history','val'=>$totalToday,'label'=>'Spent Today']
        ] as $item): ?>
        <div class="col-md-3">
          <div class="card p-4 d-flex align-items-center">
            <div class="summary-icon"><i class="bi bi-<?=$item['icon']?>"></i></div>
            <div>
              <div class="fs-5 fw-bold">
                <?= $item['label']=='Categories'
                    ? intval($item['val'])
                    : '₹'.number_format($item['val'],2) ?>
              </div>
              <small class="text-muted"><?=$item['label']?></small>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <div class="row g-4">
        <div class="col-lg-7">
          <div class="card p-4">
            <h5 class="fw-bold mb-3">Spending Analytics</h5>
            <div id="expenseChart"></div>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="card p-4 h-100">
            <h5 class="mb-3">Recent Activity</h5>
            <table class="table">
              <thead><tr><th>Date</th><th>Category</th><th>Amount</th><th>Title</th></tr></thead>
              <tbody>
                <?php while ($r = $recentActivities->fetch_assoc()): ?>
                <tr>
                  <td><?= date('d M',strtotime($r['expense_date'])) ?></td>
                  <td><?= htmlspecialchars($r['category']) ?></td>
                  <td>₹<?= number_format($r['amount'],2) ?></td>
                  <td><?= htmlspecialchars($r['title']) ?></td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
            <nav><ul class="pagination justify-content-center">
              <?php for ($i=1; $i<=$totalPages; $i++): ?>
              <li class="page-item <?= $i==$page?'active':'' ?>">
                <a class="page-link" href="?page=<?=$i?>"><?=$i?></a>
              </li>
              <?php endfor;?>
            </ul></nav>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const options = {
    chart: {
      type: 'bar',
      height: 320,
      toolbar: { show: false },
      animations: { enabled: true, easing: 'easeinout', speed: 800 }
    },
    series: [{ name: 'Spent', data: [] }],
    xaxis: {
      categories: [],
      labels: { style: { fontSize: '12px', fontFamily: 'Arial, sans-serif' } }
    },
    yaxis: {
      title: { text: 'Amount (₹)' },
      labels: {
        formatter: function (val) {
          return '₹' + val.toLocaleString('en-IN');
        }
      }
    },
    title: {
      text: 'Monthly Spending',
      align: 'center',
      style: { fontSize: '16px', fontWeight: 'bold', fontFamily: 'Arial, sans-serif' }
    },
    colors: ['#4f8cff'],
    plotOptions: {
      bar: {
        borderRadius: 4,
        columnWidth: '50%'
      }
    },
    dataLabels: { enabled: false },
    noData: { text: 'Loading data...' },
    responsive: [{
      breakpoint: 768,
      options: {
        chart: { height: 300 },
        xaxis: { labels: { rotate: -45 } }
      }
    }]
  };

  const chart = new ApexCharts(document.querySelector("#expenseChart"), options);
  chart.render();

  fetch('get_expense_data.php?filter=monthly')
    .then(res => {
      console.log('Fetch response status:', res.status, res.statusText);
      if (!res.ok) throw new Error(`HTTP error: ${res.status} ${res.statusText}`);
      return res.json();
    })
    .then(rows => {
      console.log('Fetched data:', rows);
      if (!rows || !Array.isArray(rows) || rows.length === 0) {
        chart.updateOptions({ noData: { text: 'No data available' } });
        return;
      }
      const periods = rows.map(o => o.period || '');
      const totals = rows.map(o => parseFloat(o.total) || 0);
      chart.updateOptions({ xaxis: { categories: periods }, series: [{ data: totals }] });
    })
    .catch(err => {
      console.error('Chart data error:', err.message);
      chart.updateOptions({ noData: { text: `Error loading data: ${err.message}` } });
    });
});
</script>
</body>
</html>