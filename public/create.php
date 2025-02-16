<?php
include "../config/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $lastName = trim($_POST["lastName"]);
    $phone = trim($_POST["phone"]);

    // Check if contact already exists (same name, lastName, and phone)
    $checkStmt = $conn->prepare("SELECT COUNT(*) FROM contacts WHERE name = ? AND lastName = ? AND phone = ?");
    $checkStmt->execute([$name, $lastName, $phone]);
    $contactExists = $checkStmt->fetchColumn();

    if ($contactExists > 0) {
        // Show error message if contact already exists
        $error = "This contact already exists!";
    } else {
        // Insert the new contact
        $stmt = $conn->prepare("INSERT INTO contacts (name, lastName, phone) VALUES (?, ?, ?)");
        if ($stmt->execute([$name, $lastName, $phone])) {
            header("Location: index.php?success=Contact added successfully!");
            exit();
        } else {
            $error = "Error adding contact. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Contact</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/custom.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Add Contact</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <div class="card shadow p-4">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">First Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Last Name</label>
                <input type="text" name="lastName" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Save Contact</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
