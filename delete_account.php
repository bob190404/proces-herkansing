<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare('DELETE FROM Users WHERE id = ?');
$stmt->execute([$user_id]);

session_destroy();
header('Location: register.php');
