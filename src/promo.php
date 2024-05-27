<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css" />
    <title>Penawaran Khusus</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            background-color: #F5F4E6;
            display: flex;
            justify-content: center; /* Rata tengah secara horizontal */
            align-items: center; /* Rata tengah secara vertikal */
            flex-direction: column; /* Ubah ke kolom vertikal */
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .container {
            text-align: center;
            width: 90%; 
            max-width: 400px; 
            margin: 8px;
            padding: 80px; 
            background-color: #BB0A13;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-size: cover;
            background-position: center;
            position: relative;
            overflow: hidden;
        }

        .container img {
            width: 80%;
            max-width: 100px;
            border-radius: 50%;
            margin-bottom: 15px;
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
        }

        .container p {
            margin-bottom: 15px;
            color: whitesmoke;
            position: absolute;
            top: 50%; 
            left: 50%;
            transform: translate(-50%, -50%); 
            padding-top: 40px; 
        }

        .container .btn {
            padding: 7px 8px;
            background-color: #969A36;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
        }

        .container .btn:hover {
            background-color: #7a7e29;
        }

        /* Background images */
        .container:nth-child(1) {
            background-image: url("../assets-templates/img/promo/promo1.png");
        }

        .container:nth-child(2) {
            background-image: url("../assets-templates/img/promo/promo2.png");
        }

        .container:nth-child(3) {
            background-image: url("../assets-templates/img/promo/promo3.png");
        }

        .container:nth-child(4) {
            background-image: url("../assets-templates/img/promo/promo4.png");
        }

        .container:nth-child(5) {
            background-image: url("../assets-templates/img/promo/promo5.png");
        }

        .container:nth-child(6) {
            background-image: url("../assets-templates/img/promo/promo6.png");
        }
    </style>
</head>
<body>
    <div class="container" data-promo="10%">
        <p>Menu Steak</p>
        <a href="listMakanan.php" class="btn">Pakai Diskon 10%</a>
    </div>
    <div class="container" data-promo="Buy 2 Get 1">
        <p>Menu Nasi Goreng</p>
        <a href="listMakanan.php?promo=nasgor21" class="btn">Pesan</a>
    </div>
    <div class="container" data-promo="5%">
        <p>Menu Mojito</p>
        <a href="listMinuman.php?promo=mjt5" class="btn">Pesan</a>
    </div>
    <div class="container" data-promo="5%">
        <p>Semua Varian Jus</p>
        <a href="listMinuman.php?promo=js5" class="btn">Pesan</a>
    </div>
    <div class="container" data-promo="Buy 1 Get 1">
        <p>Menu Kentang</p>
        <a href="listMakanan.php?promo=ktg11" class="btn">Pesan</a>
    </div>
    <div class="container" data-promo="Buy 1 Get 1">
        <p>Menu Kopi Americano</p>
        <a href="listMinuman.php?promo=amrc11" class="btn">Pesan</a>
    </div>
    <script>
        document.querySelectorAll('.container .btn').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const promoCode = this.parentElement.getAttribute('data-promo');
                const isCheckout = this.innerText.includes('Pesan'); // Periksa apakah tombol adalah tombol "Pesan"
                const url = new URL(this.href);
                if (isCheckout) {
                    url.searchParams.set('promo', promoCode); // Tambahkan kode promonya hanya saat checkout
                }
                window.location.href = url.toString();
            });
        });
    </script>
    <script src="../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
