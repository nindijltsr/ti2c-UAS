<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Pembayaran</title>
    <style>
        body {
            background-color: #f8baa1;
            font-family: Arial, sans-serif;
        }

        .invoice {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            margin-top: 100px;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .invoice-header h2 {
            margin: 0;
        }

        .order-details {
            margin-bottom: 20px;
        }

        .order-details table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-details th,
        .order-details td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .order-details th {
            background-color: #f2f2f2;
        }

        .order-summary {
            margin-top: 20px;
            text-align: right;
        }

        .thank-you {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>

<body>
    <?php
    session_start();

    if (!isset($_SESSION['user_id'])) {
        die("Anda harus login terlebih dahulu.");
    }

    include 'koneksiDB.php';

    $user_id = $_SESSION['user_id'];

    // Ambil informasi pesanan terbaru dari riwayat pesanan
    $sql = "SELECT order_id, item_name, item_price, quantity, order_date 
    FROM orders 
    WHERE user_id = '$user_id' 
    ORDER BY order_id DESC, order_date DESC 
    LIMIT 1";
    $result = $conn->query($sql);

    function formatRupiah($number)
    {
        return 'Rp ' . number_format($number, 2, ',', '.');
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $latest_order_id = $row['order_id'];
        $order_date = $row['order_date'];

        // Ambil semua pesanan di satu order ID yang sama
        $sql = "SELECT item_name, item_price, quantity 
        FROM orders 
        WHERE order_id = '$latest_order_id'";
        $result = $conn->query($sql);

    ?>
        <div class="invoice">
            <div class="invoice-header">
            <a href="riwayatPesanan.php?status=pending&order_id=<?= $latest_order_id ?>" style="text-decoration: none; color: #000; float: right;">×</a>
                <h2>Invoice Pembayaran</h2>
                <p>Order ID: <?= $latest_order_id ?></p>
            </div>
            <div class="order-details">
                <table>
                    <tr>
                        <th>Nama Pesanan</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Diskon</th>
                    </tr>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?= $row['item_name']; ?></td>
                            <td><?= formatRupiah($row['item_price']); ?></td>
                            <td><?= $row['quantity']; ?></td>
                            <td><?= formatRupiah($row['item_price'] * $row['quantity']); ?></td>
                            <td>
                                <?php
                                $promo = ''; 
                                if ($promo !== '') {
                                    echo $promo;
                                } else {
                                    echo '-';
                                }
                                ?>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>
            <div class="order-summary">
                <p>Total Harga: <?php
                                $total_harga = 0;
                                $result->data_seek(0); 
                                while ($row = $result->fetch_assoc()) {
                                    $total_harga += $row['item_price'] * $row['quantity'];
                                }
                                echo formatRupiah($total_harga);
                                ?></p>
                <p>Tanggal Pesanan: <?= date("d-m-Y H:i:s", strtotime($order_date)) ?></p>
            </div>
            <div class="thank-you">
                <p>Terima kasih telah berbelanja!</p>
            </div>
            <div class="bayar-button" style="text-align: center; margin-top: 20px;">
                <a href="bayarPesanan.php?order_id=<?= $latest_order_id ?>" style="text-decoration: none; color: #000; background-color: #4CAF50; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Bayar</a>
            </div>
        </div>
        </div>
    <?php
    } else {
        echo "<p>Tidak ada pesanan.</p>";
    }
    ?>
</body>

</html>