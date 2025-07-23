<?php
require 'db.php';

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$total = $conn->query("SELECT COUNT(*) as count FROM expenses")->fetch_assoc()['count'];
$pages = ceil($total / $limit);
$expenses = $conn->query("SELECT * FROM expenses ORDER BY expense_date DESC LIMIT $limit OFFSET $offset");
$categoryQuery = $conn->query("SELECT DISTINCT category FROM expenses ORDER BY category ASC");
$categories = [];
while ($row = $categoryQuery->fetch_assoc()) {
    $categories[] = $row['category'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expenses</title>
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
        .table thead {
            background: #e0e7ef;
        }
        .modal-header {
            background: #f8fafc;
            border-bottom: 1px solid #dee2e6;
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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                   
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-primary px-4 fw-bold shadow-sm" href="#">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-lg-2 mb-4">
            <div class="sidebar d-flex flex-column">
                <nav class="nav flex-column w-100">
                    <a class="nav-link" href="dashboard.php"><i class="bi bi-house-door me-2"></i> Overview</a>
                    <a class="nav-link active" href="expenses.php"><i class="bi bi-wallet2 me-2"></i> Expenses</a>
                    <a class="nav-link" href="expense-highlight.php"><i class="bi bi-bar-chart-line me-2"></i> Highlights</a>
                    <a class="nav-link" href="#settings"><i class="bi bi-gear me-2"></i> Settings</a>
                </nav>
            </div>
        </div>
        <div class="col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold">Manage Expenses</h4>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">+ Add Expense</button>
            </div>

            <div class="card p-3">
                <div class="table-responsive">
                    <table class="table align-middle table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Category</th>
                                <th>Title</th>
                                <th>Amount</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="expenseTable">
                            <?php while ($row = $expenses->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['expense_date']) ?></td>
                                    <td><?= htmlspecialchars($row['category']) ?></td>
                                    <td><?= htmlspecialchars($row['title']) ?></td>
                                    <td>$<?= htmlspecialchars($row['amount']) ?></td>
                                    <td><?= htmlspecialchars($row['notes']) ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary editBtn" 
                                            data-id="<?= $row['id'] ?>" 
                                            data-date="<?= $row['expense_date'] ?>"
                                            data-category="<?= $row['category'] ?>"
                                            data-title="<?= $row['title'] ?>"
                                            data-amount="<?= $row['amount'] ?>"
                                            data-notes="<?= $row['notes'] ?>"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editModal">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger deleteBtn" data-id="<?= $row['id'] ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <nav>
                    <ul class="pagination justify-content-end">
                        <?php for ($i = 1; $i <= $pages; $i++): ?>
                            <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" id="addExpenseForm">
            <div class="modal-header">
                <h5 class="modal-title">Add Expense</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="text" name="title" class="form-control mb-2" placeholder="Title" required>
                <input type="number" name="amount" class="form-control mb-2" placeholder="Amount" required>
                <input type="date" name="expense_date" class="form-control mb-2" required>
                <input type="text" name="category" class="form-control mb-2" placeholder="Category" required>
                <textarea name="notes" class="form-control" placeholder="Notes"></textarea>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" id="editExpenseForm">
            <div class="modal-header">
                <h5 class="modal-title">Edit Expense</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id">
                <input type="text" name="title" class="form-control mb-2" placeholder="Title" required>
                <input type="number" name="amount" class="form-control mb-2" placeholder="Amount" required>
                <input type="date" name="expense_date" class="form-control mb-2" required>
                <input type="text" name="category" class="form-control mb-2" placeholder="Category" required>
                <textarea name="notes" class="form-control" placeholder="Notes"></textarea>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).on('click', '.editBtn', function () {
        const modal = $('#editModal');
        modal.find('input[name=id]').val($(this).data('id'));
        modal.find('input[name=title]').val($(this).data('title'));
        modal.find('input[name=amount]').val($(this).data('amount'));
        modal.find('input[name=expense_date]').val($(this).data('date'));
        modal.find('input[name=category]').val($(this).data('category'));
        modal.find('textarea[name=notes]').val($(this).data('notes'));
    });
    $(document).on('click', '.deleteBtn', function () {
    const id = $(this).data('id');
    if (confirm('Are you sure you want to delete this expense?')) {
        $.ajax({
            url: 'delete_expense.php',
            type: 'POST',
            data: { id },
            dataType: 'json',
            success: function (res) {
                if (res.success) {
                    // Remove the row from the table
                    $(`.deleteBtn[data-id="${id}"]`).closest('tr').fadeOut(300, function () {
                        $(this).remove();
                    });
                } else {
                    alert(res.error || 'Failed to delete expense.');
                }
            },
            error: function () {
                alert('Something went wrong while deleting.');
            }
        });
    }
});

// custom.js - Handles CRUD operations for expenses using jQuery and Bootstrap modals

function loadExpenses() {
    $.get('get_expenses.php', function(data) {
        let rows = '';
        data.forEach(function(exp) {
            rows += `<tr>
                <td>${exp.date}</td>
                <td>${exp.category}</td>
                <td>$${parseFloat(exp.amount).toFixed(2)}</td>
                <td>${exp.description || ''}</td>
                <td>
                    <button class="btn btn-sm btn-outline-primary me-1 edit-btn" data-id="${exp.id}" data-date="${exp.date}" data-category="${exp.category}" data-amount="${exp.amount}" data-description="${exp.description}"><i class="bi bi-pencil"></i></button>
                    <button class="btn btn-sm btn-outline-danger delete-btn" data-id="${exp.id}"><i class="bi bi-trash"></i></button>
                </td>
            </tr>`;
        });
        $('#expensesTable tbody').html(rows);
    });
}

$(document).ready(function() {
    console.log("Document ready, loading expenses");
 

    // Corrected: Bind submit to the form, not the modal div
   $('#addExpenseForm').submit(function (e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'add_expense.php', // ← must point to the separate file now
        data: $(this).serialize(),
        dataType: 'json',
        success: function (res) {
            if (res.success) {
                $('#addModal').modal('hide');
                $('#addExpenseForm')[0].reset();
                location.reload(); // or loadExpenses() if you prefer
            } else {
                alert(res.error || 'Failed to add expense.');
            }
        },
        error: function () {
            alert('AJAX error occurred while adding expense.');
        }
    });
});


    // Edit (open modal)
    $(document).on('click', '.edit-btn', function() {
        $('#edit-id').val($(this).data('id'));
        $('#edit-date').val($(this).data('date'));
        $('#edit-category').val($(this).data('category'));
        $('#edit-amount').val($(this).data('amount'));
        $('#edit-description').val($(this).data('description'));
        $('#editModal').modal('show');
    });
    // Edit (open modal)
$(document).on('click', '.editBtn', function () {
    const modal = $('#editModal');
    modal.find('input[name=id]').val($(this).data('id'));
    modal.find('input[name=title]').val($(this).data('title'));
    modal.find('input[name=amount]').val($(this).data('amount'));
    modal.find('input[name=expense_date]').val($(this).data('date'));
    modal.find('input[name=category]').val($(this).data('category'));
    modal.find('textarea[name=notes]').val($(this).data('notes'));
});

// Edit (submit)
$('#editExpenseForm').submit(function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'update_expense.php',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(res) {
            if (res.success) {
                $('#editModal').modal('hide');
                location.reload(); // reloads to update UI
            } else {
                alert(res.error || 'Failed to update expense');
            }
        },
        error: function(xhr) {
            console.error('Update failed:', xhr.responseText);
            alert('An error occurred.');
        }
    });
});

    // Delete (open modal)
    $(document).on('click', '.delete-btn', function() {
        $('#delete-id').val($(this).data('id'));
        $('#deleteModal').modal('show');
    });
    // Delete (submit)
    $('#deleteExpenseForm').submit(function(e) {
        e.preventDefault();
        $.post('delete_expense.php', $(this).serialize(), function(res) {
            if (res.success) {
                $('#deleteModal').modal('hide');
                loadExpenses();
            } else {
                alert(res.error || 'Failed to delete expense');
            }
        }, 'json');
    });
}); 
    
</script>
</body>
</html>
