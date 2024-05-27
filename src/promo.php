<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/vendor/twbs/bootstrap/dist/css/bootstrap.min.css" />
    <title>Penawaran Khusus</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F5F4E6;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .container {
            text-align: center;
            width: calc(33.33% - 40px);
            margin: 5px;
            padding: 100px;
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
            color: white;
            position: absolute;
            top: 50%; /* Atur posisi vertikal */
            left: 50%;
            transform: translate(-50%, -50%); /* Atur teks ke tengah */
            padding-top: 60px; /* Tambahkan padding atas untuk menurunkan teks */
        }

        .container .btn {
            padding: 5px 10px;
            background-color: #969A36;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
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
            background-image: url("/assets-templates/img/promo/prm1.png");
        }

        .container:nth-child(2) {
            background-image: url("./assets-templates/img/promo/promo2.png");
        }

        .container:nth-child(3) {
            background-image: url("./assets-templates/img/promo/promo3.png");
        }

        .container:nth-child(4) {
            background-image: url("./assets-templates/img/promo/promo4.png");
        }

        .container:nth-child(5) {
            background-image: url("./assets-templates/img/promo/promo5.png");
        }

        .container:nth-child(6) {
            background-image: url("./assets-templates/img/promo/promo6.png");
        }
    </style>
</head>
<body>
    <div class="container" data-promo="10%">
        <p>Diskon 10% untuk menu steak</p>
        <a href="menu_makanan.html?promo=st10" class="btn">Pakai Diskon 10%</a>
    </div>
    <div class="container" data-promo="Buy 2 Get 1">
        <p>Beli 2 Gratis 1 untuk menu nasi goreng</p>
        <a href="menu_makanan.html?promo=nasgor21" class="btn">Pakai Beli 2 Gratis 1</a>
    </div>
    <div class="container" data-promo="5%">
        <p>Diskon 5% untuk menu mojito</p>
        <a href="menu_minuman.html?promo=mjt5" class="btn">Pakai Diskon 5%</a>
    </div>
    <div class="container" data-promo="5%">
        <p>Diskon 5% untuk menu jus</p>
        <a href="menu_minuman.html?promo=js5" class="btn">Pakai Diskon 5%</a>
    </div>
    <div class="container" data-promo="Buy 1 Get 1">
        <p>Beli 1 Gratis 1 untuk menu kentang</p>
        <a href="menu_makanan.html?promo=ktg11" class="btn">Pakai Beli 1 Gratis 1</a>
    </div>
    <div class="container" data-promo="Buy 1 Get 1">
        <p>Beli 1 Gratis 1 untuk menu americano</p>
        <a href="menu_minuman.html?promo=amrc11" class="btn">Pakai Beli 1 Gratis 1</a>
    </div>
    <script src="./vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
