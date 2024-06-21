<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare('SELECT * FROM Photos WHERE user_id = ?');
$stmt->execute([$user_id]);
$photos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Welcome</h1>
    <nav>
        <ul>
            <li><a href="upload.php">Upload Photo</a></li>
            <li><a href="download_csv.php">Download CSV</a></li>
            <li><a href="delete_account.php">Delete Account</a></li>
        </ul>
    </nav>
    <h2>Your Photos</h2>
    <div class="all">
        <?php foreach ($photos as $photo) : ?>

            <div class="photos">
                <img class="pic" src="<?php echo $photo['path']; ?>" alt="<?php echo $photo['title']; ?>" width="100">
                <p><?php echo $photo['title']; ?></p>
                <p><?php echo $photo['description']; ?></p>
            </div>

        <?php endforeach; ?>
    </div>
    <h2>Public Photos</h2>
    <div class="all">
        <?php
        $stmt = $pdo->query('SELECT * FROM Photos WHERE is_public = true');
        $public_photos = $stmt->fetchAll();
        foreach ($public_photos as $photo) :
        ?>

            <div class="photos">
                <img class="pic" src="<?php echo $photo['path']; ?>" alt="<?php echo $photo['title']; ?>" width="100">
                <p><?php echo $photo['title']; ?></p>
                <p><?php echo $photo['description']; ?></p>
            </div>

        <?php endforeach; ?>
    </div>
</body>

</html>