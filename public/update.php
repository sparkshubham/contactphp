<?php
include "../config/database.php";

$id = $_GET['id'];
$query = $conn->prepare("SELECT * FROM contacts WHERE id = ?");
$query->execute([$id]);
$contact = $query->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $lastName = trim($_POST["lastName"]);
    $phone = trim($_POST["phone"]);

    // Proceed with the update
    $stmt = $conn->prepare("UPDATE contacts SET name=?, lastName=?, phone=? WHERE id=?");
    if ($stmt->execute([$name, $lastName, $phone, $id])) {
        header("Location: index.php?success=Contact updated successfully!");
        exit();
    } else {
        $error = "Error updating contact. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Contact</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/style.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Edit Contact</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <div class="card shadow p-4">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">First Name</label>
                <input type="text" name="name" value="<?= htmlspecialchars($contact['name']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Last Name</label>
                <input type="text" name="lastName" value="<?= htmlspecialchars($contact['lastName']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" value="<?= htmlspecialchars($contact['phone']) ?>" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Update Contact</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
