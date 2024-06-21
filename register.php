<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $stmt = $pdo->prepare('INSERT INTO Users (username, password) VALUES (?, ?)');
        $stmt->execute([$username, $password]);

        header('Location: login.php');
        exit;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <form action="register.php" method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login</a></p>
</body>

</html>