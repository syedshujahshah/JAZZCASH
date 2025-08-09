<?php
require_once 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
}
$stmt = $pdo->prepare("SELECT balance FROM wallets WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$wallet = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JazzCash Clone - Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #ff5e62, #f7f7f7);
        }
        .navbar {
            background: #fff;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .navbar a {
            color: #ff5e62;
            text-decoration: none;
            margin: 0 15px;
            font-size: 1.1em;
        }
        .navbar a:hover {
            text-decoration: underline;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }
        .wallet {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .wallet h2 {
            color: #ff5e62;
            margin: 0 0 10px;
        }
        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .action-card {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 200px;
            text-align: center;
            cursor: pointer;
            transition: transform 0.3s;
        }
        .action-card:hover {
            transform: translateY(-5px);
        }
        .action-card h3 {
            color: #ff5e62;
            margin: 10px 0;
        }
        @media (max-width: 768px) {
            .action-card {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="javascript:window.location.href='dashboard.php'">Dashboard</a>
        <a href="javascript:window.location.href='transfer.php'">Transfer</a>
        <a href="javascript:window.location.href='bill_payment.php'">Bill Payment</a>
        <a href="javascript:window.location.href='transactions.php'">Transactions</a>
        <a href="javascript:window.location.href='account.php'">Account</a>
        <a href="javascript:window.location.href='logout.php'">Logout</a>
    </div>
    <div class="container">
        <div class="wallet">
            <h2>Wallet Balance</h2>
            <p style="font-size: 2em; color: #333;">PKR <?php echo number_format($wallet['balance'], 2); ?></p>
        </div>
        <div class="actions">
            <div class="action-card" onclick="window.location.href='transfer.php'">
                <h3>Send Money</h3>
                <p>Transfer funds instantly</p>
            </div>
            <div class="action-card" onclick="window.location.href='bill_payment.php'">
                <h3>Pay Bills</h3>
                <p>Utility and subscriptions</p>
            </div>
            <div class="action-card" onclick="window.location.href='bill_payment.php'">
                <h3>Mobile Recharge</h3>
                <p>Top up your mobile</p>
            </div>
            <div class="action-card" onclick="window.location.href='transactions.php'">
                <h3>Transaction History</h3>
                <p>View all transactions</p>
            </div>
        </div>
    </div>
</body>
</html>
