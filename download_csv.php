<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare('SELECT * FROM Users WHERE id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch();

$stmt = $pdo->prepare('SELECT title FROM Photos WHERE user_id = ?');
$stmt->execute([$user_id]);
$photos = $stmt->fetchAll();

$filename = "userdata.csv";
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="' . $filename . '"');

$fp = fopen('php://output', 'w');
fputcsv($fp, array('Username', 'Title of Photos'));

fputcsv($fp, array($user['username']));
foreach ($photos as $photo) {
    fputcsv($fp, array('', $photo['title']));
}

fclose($fp);
exit;
