<?php
session_start();

include 'koneksiDB.php';

// Add item to cart
if (isset($_GET['action']) && $_GET['action'] == 'add') {
    $name = $_GET['name'];
    $price = $_GET['price'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (!isset($_SESSION['cart'][$name])) {
        $_SESSION['cart'][$name] = ['name' => $name, 'price' => $price, 'quantity' => 1];
    } else {
        $_SESSION['cart'][$name]['quantity'] += 1;
    }
}

// Remove item from cart
if (isset($_GET['action']) && $_GET['action'] == 'remove') {
    $name = $_GET['name'];
    unset($_SESSION['cart'][$name]);
}

// Clear the cart
if (isset($_GET['action']) && $_GET['action'] == 'clear') {
    unset($_SESSION['cart']);
}

// Save order to database
if (isset($_POST['place_order'])) {
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $name = $item['name'];
            $price = $item['price'];
            $quantity = $item['quantity'];
            $sql = "INSERT INTO orders (item_name, price, quantity, order_date) VALUES ('$name', '$price', '$quantity', NOW())";
            $conn->query($sql);
        }
        // Clear the cart after saving
        unset($_SESSION['cart']);
    }
}


// Function to format currency
function formatRupiah($number){
    return 'Rp ' . number_format($number, 2, ',', '.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Summary</title>
    <link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">

    <?php include '../assets-templates/header.php'; ?>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #d40000;
            color: white;
            padding: 10px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
        }

        header .logo {
            font-size: 20px;
            font-weight: bold;
        }

        header nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        header nav ul li {
            margin: 0 10px;
        }

        header nav ul li a {
            color: white;
            text-decoration: none;
        }

        .container {
            display: flex;
            justify-content: space-between;
            padding-top: 30px;
            padding: 50px;
            background-color: white;
            margin: 20px auto;
            width: 80%;
            border: 1px solid #ddd;
        }

        .order-summary, .order-action {
            width: 45%;
        }

        .order-summary h2 {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .order-summary .item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }

        .order-summary .summary {
            padding: 10px 0;
        }

        .order-summary .summary .total {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            font-weight: bold;
            color: #d40000;
        }

        .order-action {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            justify-content: space-between;
        }

        .order-action input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
        }

        .order-action .total-amount {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .button-group button {
            background-color: #d40000;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 5px;
            width: 48%;
        }

        #cancel-order {
            background-color: #d40000;
        }

        /* CSS untuk alert */
        .alert {
            position: fixed;
            top: 50px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            z-index: 9999;
            display: none;
            animation: slideIn 0.5s ease-in-out forwards;
        }

        .alert.show {
            display: block;
        }

        @keyframes slideIn {
            0% {
                transform: translate(-50%, -100%);
            }
            100% {
                transform: translate(-50%, 0%);
            }
        }
    </style>
</head>
<body>
<div class="container">
        <div class="order-summary">
            <h2>Ringkasan Pesanan</h2>
            <div class="item">
                <span>Nama Pesanan</span>
                <span>Jumlah</span>
                <span>Total</span>
            </div>
            <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
                <?php $totalPrice = 0; ?>
                <?php foreach ($_SESSION['cart'] as $item): ?>
                    <div class="item">
                        <span><?= $item['name']; ?></span>
                        <span><?= $item['quantity']; ?></span>
                        <span><?= formatRupiah($item['price'] * $item['quantity']); ?></span>
                        <?php $totalPrice += $item['price'] * $item['quantity']; ?>
                    </div>
                <?php endforeach; ?>
                <div class="summary">
                    <div class="total">
                        <span>Total</span>
                        <span><?= formatRupiah($totalPrice); ?></span>
                    </div>
                </div>
            <?php else: ?>
                <p>Keranjang kosong</p>
            <?php endif; ?>
        </div>
        <div class="order-action">
            <input type="text" placeholder="Masukkan Kupon/Kode Promo">
            <div class="total-amount">Total: <?= isset($totalPrice) ? formatRupiah($totalPrice) : 'Rp 0'; ?></div>
            <form method="post" action="keranjang.php">
                <div class="button-group">
                    <button type="submit" name="place_order" id="place-order">Pesan Sekarang</button>
                    <a href="keranjang.php?action=clear" id="cancel-order" class="btn btn-danger">Batal</a>
                </div>
            </form>
        </div>
    </div>
    <script src="/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
     <?php include '../assets-templates/footer.php'; ?>
</body>
</html>