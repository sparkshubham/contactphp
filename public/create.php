<?php
include "../config/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);

    // Check if email already exists
    $checkStmt = $conn->prepare("SELECT COUNT(*) FROM contacts WHERE email = ?");
    $checkStmt->execute([$email]);
    $emailExists = $checkStmt->fetchColumn();

    if ($emailExists > 0) {
        // Show error message if email is already in use
        $error = "This email is already registered!";
    } else {
        // Insert the new contact
        $stmt = $conn->prepare("INSERT INTO contacts (name, email, phone) VALUES (?, ?, ?)");
        if ($stmt->execute([$name, $email, $phone])) {
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
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
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
