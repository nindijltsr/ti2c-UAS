<?php
session_start();

include 'koneksiDB.php';

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Anda harus login terlebih dahulu.');
        window.location = 'halamanDaftar.php';</script>";
}

$user_id = $_SESSION['user_id'];

// + menu ke keranjang
if (isset($_GET['action']) && $_GET['action'] == 'add') {
    $name = urldecode($_GET['name']);
    $price = $_GET['price'];
    $quantity = isset($_GET['quantity']) ? intval($_GET['quantity']) : 1;
    $promo = isset($_GET['promo']) ? $_GET['promo'] : '';

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (!isset($_SESSION['cart'][$name])) {
        $_SESSION['cart'][$name] = ['name' => $name, 'price' => $price, 'quantity' => $quantity];
    } else {
        $_SESSION['cart'][$name]['quantity'] += $quantity;
    }

    header('Location: keranjang.php');
    exit;
}

// Hapus dari keranjang
if (isset($_GET['action']) && $_GET['action'] == 'remove') {
    $name = $_GET['name'];
    unset($_SESSION['cart'][$name]);
}

// - jumlah menu di kreanjang
if (isset($_GET['action']) && $_GET['action'] == 'decrease') {
    $name = $_GET['name'];
    if (isset($_SESSION['cart'][$name])) {
        $_SESSION['cart'][$name]['quantity']--;
        if ($_SESSION['cart'][$name]['quantity'] <= 0) {
            unset($_SESSION['cart'][$name]);
        }
    }
}

// Batal pesanan
if (isset($_GET['action']) && $_GET['action'] == 'clear') {
    unset($_SESSION['cart']);
}

// Simpan ke database
if (isset($_POST['place_order'])) {
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $order_id = uniqid();
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
        // Masukkan riwayat pesanan
        unset($_SESSION['cart']);
        echo "<script>alert('Order placed successfully');
        window.location = 'riwayatPesanan.php';</script>";
    }
}

// Function to format currency
function formatRupiah($number)
{
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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            height: 100vh;

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

        .order-summary,
        .order-action {
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

        .button-group a.btn,
        .button-group button {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #d40000;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 5px;
            width: auto;
            white-space: nowrap;
            text-decoration: none;
            margin-right: 10px;
        }

        .button-group a.btn:last-child,
        .button-group button:last-child {
            margin-right: 0;
        }

        #cancel-order {
            background-color: #d40000;
        }

        /* alert */
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
            $totalPrice = 0;

            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) : ?>
                <?php $totalPrice = 0; ?>
                <?php foreach ($_SESSION['cart'] as $item) : ?>
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
            <?php else : ?>
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

                if (promoCode === 'DISC25') {
                    applyPromo(0.25);
                } else if (promoCode === 'DISC50') {
                    applyPromo(0.5);
                } else if (promoCode === 'DISC75') {
                    applyPromo(0.75);
                } else if (promoCode === 'DISC90') {
                    applyPromo(0.9);
                } else {
                    alert('Kode promo tidak valid!');
                }
            });

            function applyPromo(discountRate) {
                var totalPriceElement = document.querySelector('.total-amount');
                var totalPrice = parseFloat(totalPriceElement.dataset.totalPrice);
                var discount = totalPrice * discountRate;
                var discountedPrice = totalPrice - discount;
                totalPriceElement.textContent = 'Total: ' + formatRupiah(discountedPrice);
            }

            function formatRupiah(number) {
                return 'Rp ' + number.toLocaleString('id-ID');
            }
        });
    </script>
    <script src="/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
    <?php include '../assets-templates/footer.php'; ?>
</html>