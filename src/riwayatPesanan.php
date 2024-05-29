<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Anda harus login terlebih dahulu.");
}

include 'koneksiDB.php';

// Query untuk mengambil semua pesanan dari tabel orders
$user_id = $_SESSION['user_id']; // Pastikan pengguna telah login
$sql = "SELECT order_id, item_name, item_price, quantity, order_date 
        FROM orders 
        WHERE user_id = '$user_id' 
        ORDER BY order_id DESC, order_date DESC";
$result = $conn->query($sql);


function formatRupiah($number){
    return 'Rp ' . number_format($number, 2, ',', '.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan</title>
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
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border: 1px solid #ddd;
            width: 80%;
        }

        .order-history h2 {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .order-history table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-history table, th, td {
            border: 1px solid #ddd;
            padding: 10px;
        }

        .order-history th {
            background-color: #f7f7f7;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container order-history">
        <h2>Riwayat Pesanan</h2>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Nama Pesanan</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Tanggal Pesanan</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php 
                    $current_order_id = null;
                    while ($row = $result->fetch_assoc()): 
                        if ($row['order_id'] !== $current_order_id): 
                            $current_order_id = $row['order_id'];
                    ?>
                        <tr>
                            <td><?= $row['order_id']; ?></td>
                            <td><?= $row['item_name']; ?></td>
                            <td><?= formatRupiah($row['item_price']); ?></td>
                            <td><?= $row['quantity']; ?></td>
                            <td><?= $row['order_date']; ?></td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td></td>
                            <td><?= $row['item_name']; ?></td>
                            <td><?= formatRupiah($row['item_price']); ?></td>
                            <td><?= $row['quantity']; ?></td>
                            <td><?= $row['order_date']; ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Tidak ada pesanan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script src="/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <?php include '../assets-templates/footer.php'; ?>
</body>
</html>