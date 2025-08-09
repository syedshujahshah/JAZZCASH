<?php
require_once 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_pin = password_hash($_POST['new_pin'], PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("UPDATE users SET pin = ? WHERE id = ?");
    $stmt->execute([$new_pin, $_SESSION['user_id']]);
    $success = "PIN updated successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JazzCash Clone - Account</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #ff5e62, #f7f7f7);
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .container h2 {
            color: #ff5e62;
            text-align: center;
        }
        .form-group {
            margin: 15px 0;
        }
        .form-group label {
            display: block;
            color: #333;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }
        .form-group button {
            background: #ff5e62;
            color: #fff;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            transition: background 0.3s;
        }
        .form-group button:hover {
            background: #e04e52;
        }
        .success {
            color: green;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Account Settings</h2>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <form method="POST">
            <div class="form-group">
                <label>New PIN</label>
                <input type="password" name="new_pin" placeholder="Enter new 4-digit PIN" required>
            </div>
            <div class="form-group">
                <button type="submit">Update PIN</button>
            </div>
        </form>
    </div>
</body>
</html>
