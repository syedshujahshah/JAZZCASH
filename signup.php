<?php
require_once 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $pin = password_hash($_POST['pin'], PASSWORD_BCRYPT);
    
    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, phone, password, pin) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$username, $email, $phone, $password, $pin]);
        $user_id = $pdo->lastInsertId();
        $stmt = $pdo->prepare("INSERT INTO wallets (user_id, balance) VALUES (?, 0.00)");
        $stmt->execute([$user_id]);
        echo "<script>window.location.href='login.php';</script>";
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JazzCash Clone - Signup</title>
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
        .signup-container {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .signup-container h2 {
            color: #ff5e62;
            margin-bottom: 20px;
        }
        .signup-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }
        .signup-container button {
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
        .signup-container button:hover {
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
    <div class="signup-container">
        <h2>Sign Up</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone" placeholder="Phone Number" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="pin" placeholder="4-Digit PIN" required>
            <button type="submit">Sign Up</button>
        </form>
        <p class="link">Already have an account? <a href="javascript:window.location.href='login.php'">Login</a></p>
    </div>
</body>
</html>
