<?php
session_start();

include 'koneksiDB.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Anda harus login terlebih dahulu.');
        window.location = 'halamanDaftar.php';</script>";
}

$user_id = $_SESSION['user_id'];

// Add item to cart
if (isset($_GET['action']) && $_GET['action'] == 'add') {
    $name = urldecode($_GET['name']);  // Decode the URL-encoded name
    $price = $_GET['price'];
    $quantity = isset($_GET['quantity']) ? intval($_GET['quantity']) : 1;  // Get the quantity from the form
    $promo = isset($_GET['promo']) ? $_GET['promo'] : '';  // Get the promo code if any

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check for promo "beli satu gratis satu"
    if ($promo === 'KTG11' || $promo === 'AMRC11') {
        $quantity = 2;  // Add two items
        $price = $price / 2;  // Each item will be half price, so effectively one is free
    }

    if (!isset($_SESSION['cart'][$name])) {
        $_SESSION['cart'][$name] = ['name' => $name, 'price' => $price, 'quantity' => $quantity];
    } else {
        $_SESSION['cart'][$name]['quantity'] += $quantity;
    }

    header('Location: keranjang.php');
    exit;
}

// Remove item from cart
if (isset($_GET['action']) && $_GET['action'] == 'remove') {
    $name = $_GET['name'];
    unset($_SESSION['cart'][$name]);
}

// Decrease item quantity in cart
if (isset($_GET['action']) && $_GET['action'] == 'decrease') {
    $name = $_GET['name'];
    if (isset($_SESSION['cart'][$name])) {
        $_SESSION['cart'][$name]['quantity']--;
        if ($_SESSION['cart'][$name]['quantity'] <= 0) {
            unset($_SESSION['cart'][$name]);
        }
    }
}

// Clear the cart
if (isset($_GET['action']) && $_GET['action'] == 'clear') {
    unset($_SESSION['cart']);
}

// Save order to database
if (isset($_POST['place_order'])) {
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $order_id = uniqid(); // Generate a unique order ID
        foreach ($_SESSION['cart'] as $item) {
            $name = $item['name'];
            $price = $item['price'];
            $quantity = $item['quantity'];
            $sql = "INSERT INTO orders (order_id, user_id, item_name, item_price, quantity, order_date) 
                    VALUES ('$order_id', '$user_id', '$name', '$price', '$quantity', NOW())";
            if (!$conn->query($sql)) {
                die("Error: " . $conn->error);
            }
        }
        // Clear the cart after saving
        unset($_SESSION['cart']);
        echo "<script>alert('Order placed successfully');
        window.location = 'riwayatPesanan.php';</script>";
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
            margin-top: 10px;
        }

        .button-group button {
            background-color: #d40000;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 5px;
            width: calc(33.33% - 5px);
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
            <?php 
            $totalPrice = 0; // Ensure $totalPrice is always defined

            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
                <?php $totalPrice = 0; ?>
                <?php foreach ($_SESSION['cart'] as $item): ?>
                    <div class="item">
                        <span><?= $item['name']; ?></span>
                        <span>
                            <a href="keranjang.php?action=decrease&name=<?= urlencode($item['name']); ?>">-</a>
                            <?= $item['quantity']; ?>
                            <a href="keranjang.php?action=add&name=<?= urlencode($item['name']); ?>&price=<?= $item['price']; ?>">+</a>
                        </span>
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
            <input type="text" name="promo_code" placeholder="Masukkan Kupon/Kode Promo">
            <button id="apply-promo">Terapkan Kode Promo</button>
            <div class="total-amount" data-total-price="<?= $totalPrice; ?>">Total: <?= formatRupiah($totalPrice); ?></div>
            <form method="post" action="keranjang.php">
                <div class="button-group">
                    <a href="listMakanan.php" id="cancel-order" class="btn btn-danger">Tambah Pesanan</a>
                    <button type="submit" name="place_order" id="place-order" class="btn btn-danger">Pesan Sekarang</button>
                    <a href="keranjang.php?action=clear" id="cancel-order" class="btn btn-danger">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var inputPromo = document.querySelector('input[name="promo_code"]');
        var applyPromoButton = document.querySelector('#apply-promo');

        applyPromoButton.addEventListener('click', function() {
            var promoCode = inputPromo.value.trim();

            if (promoCode === 'ST10') {
                applyPromo('ST10', 0.1); // Potongan harga 10%
            } else if (promoCode === 'MJT5') {
                applyPromo('MJT5', 0.05); // Potongan harga 5%
            } else if (promoCode === 'KTG11') {
                applyPromoItem('KTG11');
            } else if (promoCode === 'AMRC11') {
                applyPromoItem('AMRC11');
            } else {
                alert('Kode promo tidak valid!');
            }
        });

        function applyPromo(promoCode, discountRate) {
            var totalPriceElement = document.querySelector('.total-amount');
            var totalPrice = parseFloat(totalPriceElement.dataset.totalPrice);
            var discount = totalPrice * discountRate;
            var discountedPrice = totalPrice - discount;
            totalPriceElement.textContent = 'Total: ' + formatRupiah(discountedPrice);
        }

        function applyPromoItem(promoCode) {
            var cartItems = <?php echo json_encode($_SESSION['cart']); ?>;
            var itemToIncrease = '';

            if (promoCode === 'KTG11') {
                itemToIncrease = 'Kentang Goreng'; // Nama item yang harus ditambah
            } else if (promoCode === 'AMRC11') {
                itemToIncrease = 'Americano'; // Nama item yang harus ditambah
            }

            if (itemToIncrease && cartItems[itemToIncrease]) {
                var price = cartItems[itemToIncrease]['price'] / 2;
                cartItems[itemToIncrease]['quantity'] += 2;
                cartItems[itemToIncrease]['price'] = price;
                updateCartOnServer(itemToIncrease, 2, price, promoCode);
            } else {
                alert('Item tidak ditemukan di keranjang.');
            }
        }

        function updateCartOnServer(itemName, quantity, price, promoCode) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'keranjang.php?action=add&name=' + encodeURIComponent(itemName) + '&quantity=' + quantity + '&price=' + price + '&promo=' + promoCode, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    window.location.reload();
                } else {
                    alert('Terjadi kesalahan saat memperbarui keranjang.');
                }
            };
            xhr.send();
        }

        function formatRupiah(number) {
            return 'Rp ' + number.toLocaleString('id-ID');
        }
    });
    </script>
    <script src="/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
     <?php include '../assets-templates/footer.php'; ?>
</body>
</html>