<?php
session_start();

include 'koneksiDB.php';

// Query untuk mengambil semua pesanan dari tabel orders
$sql = "SELECT * FROM orders ORDER BY id DESC";
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
                    <th>ID</th>
                    <th>Nama Pesanan</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Tanggal Pesanan</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id']; ?></td>
                            <td><?= $row['item_name']; ?></td>
                            <td><?= formatRupiah($row['price']); ?></td>
                            <td><?= $row['quantity']; ?></td>
                            <td><?= $row['order_date']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Tidak ada pesanan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script src="../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <?php include '../assets-templates/footer.php'; ?>
</body>
</html>