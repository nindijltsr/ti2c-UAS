<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <style>
        /* Style untuk tampilan keranjang belanja */
        body {
            font-family: Arial, sans-serif;
        }
        .cart {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 20px;
            max-width: 400px;
        }
        .cart h2 {
            text-align: center;
        }
        .cart ul {
            list-style-type: none;
            padding: 0;
        }
        .cart li {
            margin-bottom: 10px;
        }
        .cart .checkout-btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .cart .checkout-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <?php
    session_start();

    // Fungsi untuk menambahkan item ke keranjang belanja
    function addItemToCart($id, $name, $price) {
        $_SESSION['cart'][] = array('id' => $id, 'name' => $name, 'price' => $price);
    }

    // Fungsi untuk menghapus item dari keranjang belanja berdasarkan indeksnya
    function removeItemFromCart($index) {
        unset($_SESSION['cart'][$index]);
    }

    // Fungsi untuk menyelesaikan pembelian
    function checkout() {
        unset($_SESSION['cart']);
        // Di sini Anda bisa menambahkan logika untuk menyimpan pembelian ke database atau melakukan tindakan lain yang diperlukan
        return true; // Misalnya, pengembalian nilai true menunjukkan bahwa pembelian berhasil
    }

    // Aksi berdasarkan parameter yang diterima dari halaman HTML
    if(isset($_POST['action'])) {
        switch($_POST['action']) {
            case 'add':
                addItemToCart($_POST['id'], $_POST['name'], $_POST['price']);
                break;
            case 'remove':
                removeItemFromCart($_POST['index']);
                break;
            case 'checkout':
                $result = checkout();
                if($result) {
                    echo "Pembelian berhasil!";
                } else {
                    echo "Terjadi kesalahan saat melakukan pembelian.";
                }
                break;
        }
    }
    ?>

    <div class="cart">
        <h2>Keranjang Belanja</h2>
        <ul id="cart-items">
            <?php
            if(isset($_SESSION['cart'])) {
                foreach($_SESSION['cart'] as $index => $item) {
                    echo "<li>{$item['name']} - Rp {$item['price']} <form method='post' style='display:inline;'><input type='hidden' name='index' value='$index'><input type='hidden' name='action' value='remove'><button type='submit'>Hapus Item</button></form></li>";
                }
            }
            ?>
        </ul>
        <p>Total Item: <span id="total-items"><?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : '0'; ?></span></p>
        <form method="post">
            <input type="hidden" name="action" value="checkout">
            <button class="checkout-btn">Selesaikan Pembelian</button>
        </form>
    </div>
</body>
</html>
