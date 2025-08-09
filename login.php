<?php
require_once 'db.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $pin = $_POST['pin'];
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE phone = ?");
    $stmt->execute([$phone]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password']) && password_verify($pin, $user['pin'])) {
        $_SESSION['user_id'] = $user['id'];
        $stmt = $pdo->prepare("INSERT INTO auth_logs (user_id, action, ip_address) VALUES (?, 'login', ?)");
        $stmt->execute([$user['id'], $_SERVER['REMOTE_ADDR']]);
        echo "<script>window.location.href='dashboard.php';</script>";
    } else {
        $error = "Invalid credentials or PIN";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JazzCash Clone - Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #ff5e62, #f7f7f7);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .login-container h2 {
            color: #ff5e62;
            margin-bottom: 20px;
        }
        .login-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }
        .login-container button {
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
        .login-container button:hover {
            background: #e04e52;
        }
        .error {
            color: red;
            margin: 10px 0;
        }
        .link {
            margin-top: 20px;
            color: #666;
        }
        .link a {
            color: #ff5e62;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="phone" placeholder="Phone Number" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="pin" placeholder="4-Digit PIN" required>
            <button type="submit">Login</button>
        </form>
        <p class="link">Don't have an account? <a href="javascript:window.location.href='signup.php'">Sign Up</a></p>
    </div>
</body>
</html>
