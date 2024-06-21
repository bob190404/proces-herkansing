<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo'])) {
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $is_public = isset($_POST['is_public']) ? 1 : 0;

    $upload_dir = 'uploads/';
    $upload_file = $upload_dir . basename($_FILES['photo']['name']);

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    if (move_uploaded_file($_FILES['photo']['tmp_name'], $upload_file)) {
        $stmt = $pdo->prepare('INSERT INTO Photos (user_id, title, description, path, is_public) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$user_id, $title, $description, $upload_file, $is_public]);

        header('Location: dashboard.php');
        exit;
    } else {
        echo 'Failed to upload file.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Upload Photo</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Title" required>
        <textarea name="description" placeholder="Description"></textarea>
        <input type="file" name="photo" required>
        <label>
            <input type="checkbox" name="is_public"> Public
        </label>
        <button type="submit">Upload</button>
    </form>
</body>

</html>