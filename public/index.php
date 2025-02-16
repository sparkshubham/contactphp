<?php
include "../config/database.php";
$query = $conn->query("SELECT * FROM contacts");
$contacts = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Contact List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">📇 Contact List</h2>

    <div class="d-flex justify-content-between mb-3">
        <a href="create.php" class="btn btn-success">➕ Add Contact</a>
        <a href="import.php" class="btn btn-primary">📥 Import XML</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contacts as $contact): ?>
                <tr>
                    <td><?= htmlspecialchars($contact['id']) ?></td>
                    <td><?= htmlspecialchars($contact['name']) ?></td>
                    <td><?= htmlspecialchars($contact['email']) ?></td>
                    <td><?= htmlspecialchars($contact['phone']) ?></td>
                    <td>
                        <a href="update.php?id=<?= $contact['id'] ?>" class="btn btn-warning btn-sm">✏️ Edit</a>
                        <a href="delete.php?id=<?= $contact['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this contact?')">🗑 Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
