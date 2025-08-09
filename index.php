<?php
session_start();
if (isset($_SESSION['user_id'])) {
    echo "<script>window.location.href='dashboard.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JazzCash Clone - Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #ff5e62, #f7f7f7);
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 50px 0;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .header h1 {
            font-size: 3em;
            color: #ff5e62;
            margin: 0;
        }
        .header p {
            font-size: 1.2em;
            color: #666;
        }
        .services {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 40px 0;
        }
        .service-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 300px;
            text-align: center;
            padding: 20px;
            transition: transform 0.3s;
        }
        .service-card:hover {
            transform: translateY(-10px);
        }
        .service-card img {
            width: 60px;
            margin-bottom: 20px;
        }
        .service-card h3 {
            font-size: 1.5em;
            color: #ff5e62;
        }
        .service-card p {
            color: #666;
        }
        .cta {
            text-align: center;
            margin: 40px 0;
        }
        .cta button {
            background: #ff5e62;
            color: #fff;
            border: none;
            padding: 15px 30px;
            font-size: 1.2em;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .cta button:hover {
            background: #e04e52;
        }
        @media (max-width: 768px) {
            .service-card {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>JazzCash Clone</h1>
        <p>Your trusted digital wallet for payments, transfers, and recharges</p>
    </div>
    <div class="container">
        <div class="services">
            <div class="service-card">
                <img src="https://via.placeholder.com/60" alt="Money Transfer">
                <h3>Money Transfer</h3>
                <p>Send and receive money instantly using phone numbers or IBAN.</p>
            </div>
            <div class="service-card">
                <img src="https://via.placeholder.com/60" alt="Bill Payment">
                <h3>Bill Payment</h3>
                <p>Pay your utility bills and subscriptions with ease.</p>
            </div>
            <div class="service-card">
                <img src="https://via.placeholder.com/60" alt="Mobile Recharge">
                <h3>Mobile Recharge</h3>
                <p>Top up your mobile account or purchase packages.</p>
            </div>
        </div>
        <div class="cta">
            <button onclick="window.location.href='signup.php'">Get Started</button>
        </div>
    </div>
</body>
</html>
