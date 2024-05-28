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
                <span>Nama Makanan</span>
                <span>Jumlah</span>
                <span>Total</span>
            </div>
            <div class="summary">
                <div class="total">
                    <span>Total</span>
                    <span>Harga</span>
                </div>
            </div>
        </div>
        <div class="order-action">
            <input type="text" placeholder="Masukkan Kupon/Kode Promo">
            <div class="total-amount">Potongan Harga </div>
            <div class="button-group">
                <button id="place-order">Pesan</button>
                <button id="cancel-order">Batalkan Pesanan</button>
            </div>
        </div>
    </div>
    <script src="../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Fungsi untuk menampilkan alert dengan animasi
            function showAlert(message) {
                var alertDiv = document.createElement('div');
                alertDiv.classList.add('alert');
                alertDiv.textContent = message;
                document.body.appendChild(alertDiv);
                setTimeout(function() {
                    alertDiv.classList.add('show');
                    setTimeout(function() {
                        alertDiv.classList.remove('show');
                        setTimeout(function() {
                            document.body.removeChild(alertDiv);
                        }, 500); // Ubah angka 500 sesuai dengan durasi animasi
                    }, 3000); // Tampilkan alert selama 3 detik, sesuaikan jika diperlukan
                }, 100); // Biarkan sedikit waktu agar elemen dapat ditambahkan sebelum animasi dimulai
            }

            // Menambahkan event listener untuk tombol "Pesan"
            document.getElementById("place-order").addEventListener("click", function() {
                showAlert("Pesanan berhasil dipesan!");
            });

            // Menambahkan event listener untuk tombol "Batalkan Pesanan"
            document.getElementById("cancel-order").addEventListener("click", function() {
                showAlert("Pesanan telah dibatalkan.");
            });
        });
    </script>
    <script src="/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
     <?php include '../assets-templates/footer.php'; ?>
</body>
</html>
