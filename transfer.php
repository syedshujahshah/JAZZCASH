<?php
require_once 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipient = $_POST['recipient'];
    $amount = $_POST['amount'];
    $pin = $_POST['pin'];
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    
    if (password_verify($pin, $user['pin'])) {
        $stmt = $pdo->prepare("SELECT balance FROM wallets WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $wallet = $stmt->fetch();
        
        if ($wallet['balance'] >= $amount) {
            $pdo->beginTransaction();
            try {
                $stmt = $pdo->prepare("UPDATE wallets SET balance = balance - ? WHERE user_id = ?");
                $stmt->execute([$amount, $_SESSION['user_id']]);
                
                $stmt = $pdo->prepare("INSERT INTO transactions (user_id, recipient_phone, amount, type, status) VALUES (?, ?, ?, 'transfer', 'completed')");
                $stmt->execute([$_SESSION['user_id'], $recipient, $amount]);
                $pdo->commit();
                $success = "Transfer successful!";
            } catch (Exception $e) {
                $pdo->rollBack();
                $error = "Transfer failed: " . $e->getMessage();
            }
        } else {
            $error = "Insufficient balance";
        }
    } else {
        $error = "Invalid PIN";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JazzCash Clone - Transfer</title>
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
        .error {
            color: red;
            text-align: center;
        }
        .success {
            color: green;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Send Money</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <form method="POST">
            <div class="form-group">
                <label>Recipient Phone/IBAN</label>
                <input type="text" name="recipient" placeholder="Enter phone or IBAN" required>
            </div>
            <div class="form-group">
                <label>Amount (PKR)</label>
                <input type="number" name="amount" placeholder="Enter amount" required>
            </div>
            <div class="form-group">
                <label>PIN</label>
                <input type="password" name="pin" placeholder="Enter 4-digit PIN" required>
            </div>
            <div class="form-group">
                <button type="submit">Transfer</button>
            </div>
        </form>
    </div>
</body>
</html>
