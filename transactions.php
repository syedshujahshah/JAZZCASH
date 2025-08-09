<?php
require_once 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='login.php';</script>";
}
$stmt = $pdo->prepare("SELECT * FROM transactions WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$transactions = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JazzCash Clone - Transactions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #ff5e62, #f7f7f7);
        }
        .container {
            max-width: 1200px;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }
        th {
            background: #ff5e62;
            color: #fff;
        }
        tr:hover {
            background: #f9f9f9;
        }
        @media (max-width: 768px) {
            table, th, td {
                display: block;
                width: 100%;
            }
            th, td {
                box-sizing: border-box;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Transaction History</h2>
        <table>
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Recipient</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
            <?php foreach ($transactions as $txn): ?>
            <tr>
                <td><?php echo $txn['created_at']; ?></td>
                <td><?php echo ucfirst($txn['type']); ?></td>
                <td><?php echo $txn['recipient_phone'] ?: $txn['recipient_iban'] ?: 'N/A'; ?></td>
                <td>PKR <?php echo number_format($txn['amount'], 2); ?></td>
                <td><?php echo ucfirst($txn['status']); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
