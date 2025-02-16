<?php
include "../config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['xml_file'])) {
    $xmlFile = $_FILES['xml_file']['tmp_name'];

    if (file_exists($xmlFile)) {
        $xml = simplexml_load_file($xmlFile);
        $importedCount = 0;
        $skippedCount = 0;

        foreach ($xml->contact as $contact) {
            $name = trim($contact->name);
            $lastName = trim($contact->lastName);
            $phone = trim($contact->phone);

            // Check if the contact already exists based on name and phone
            $checkStmt = $conn->prepare("SELECT COUNT(*) FROM contacts WHERE name = ? AND phone = ?");
            $checkStmt->execute([$name, $phone]);
            $contactExists = $checkStmt->fetchColumn();

            if ($contactExists == 0) {
                $stmt = $conn->prepare("INSERT INTO contacts (name, lastName, phone) VALUES (?, ?, ?)");
                if ($stmt->execute([$name, $lastName, $phone])) {
                    $importedCount++;
                }
            } else {
                $skippedCount++;
            }
        }

        $message = "<div class='alert alert-success'>✅ $importedCount contacts imported! ❌ $skippedCount duplicates skipped.</div>";
    } else {
        $message = "<div class='alert alert-danger'>❌ Error uploading XML file.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Import Contacts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">📥 Import Contacts from XML</h2>

    <?= $message ?>

    <div class="card shadow p-4">
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Select XML File</label>
                <input type="file" name="xml_file" class="form-control" accept=".xml" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">🚀 Import Contacts</button>
        </form>
    </div>

    <div class="text-center mt-3">
        <a href="index.php" class="btn btn-secondary">🔙 Back to Contacts</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
