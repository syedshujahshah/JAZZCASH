<?php
require_once 'db.php';
session_start();
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("INSERT INTO auth_logs (user_id, action, ip_address) VALUES (?, 'logout', ?)");
    $stmt->execute([$_SESSION['user_id'], $_SERVER['REMOTE_ADDR']]);
    session_destroy();
}
echo "<script>window.location.href='index.php';</script>";
?>
