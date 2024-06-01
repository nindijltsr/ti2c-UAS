<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css" />
    <title>Penawaran Khusus</title>
    <?php include '../assets-templates/header.php'; ?>
    <style>
        * {
            margin: 0;
            padding: 0;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #F5F4E6;
            display: flex;
            /* justify-content: center;
            align-items: center; */
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            padding: 0px;
        }

        header, footer {
            width: 100%;
            padding: 10px; /* Tambahkan padding untuk header dan footer */
            background-color: #333; /* Warna latar belakang header dan footer */
            color: #fff; /* Warna teks header dan footer */
            text-align: center; /* Teks di tengah */
        }

        .container-wrapper {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 16px;
            position: relative; /* Tambahkan posisi relatif */
            z-index: 1; /* Tambahkan indeks z */
        }

        .container {
            text-align: center;
            width: calc(50% - 8px);
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
            z-index: 2; /* Tambahkan indeks z lebih tinggi */
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

        /* Hide promo code by default */
        .promo-code {
            display: none;
            color: black;
            position: absolute;
            top: 50%; 
            left: 50%;
            transform: translate(-50%, -50%); 
        }
        
    </style>
</head>
<body>
<div class="container-wrapper">
        <div class="container" data-promo="10%">
            <p>Menu Steak</p>
            <a href="#" class="btn" onclick="showPromoCode('ST10')">Kode Promo</a>
            <div class="promo-code" id="promo-st10">Kode Promo: ST10</div>
        </div>
        <div class="container" data-promo="Buy 2 Get 1">
            <p>Menu Nasi Goreng</p>
            <a href="#" class="btn" onclick="showPromoCode('NASGOR21')">Kode Promo</a>
            <div class="promo-code" id="promo-nasgor21">Kode Promo: NASGOR21</div>
        </div>
        <div class="container" data-promo="5%">
            <p>Menu Mojito</p>
            <a href="#" class="btn" onclick="showPromoCode('MJT5')">Kode Promo</a>
            <div class="promo-code" id="promo-mjt5">Kode Promo: MJT5</div>
        </div>
        <div class="container" data-promo="5%">
            <p>Semua Varian Jus</p>
            <a href="#" class="btn" onclick="showPromoCode('JS5')">Kode Promo</a>
            <div class="promo-code" id="promo-js5">Kode Promo: JS5</div>
        </div>
        <div class="container" data-promo="Buy 1 Get 1">
            <p>Menu Kentang</p>
            <a href="#" class="btn" onclick="showPromoCode('KTG11')">Kode Promo</a>
            <div class="promo-code" id="promo-ktg11">Kode Promo: KTG11</div>
        </div>
        <div class="container" data-promo="Buy 1 Get 1">
            <p>Menu Kopi Americano</p>
            <a href="#" class="btn" onclick="showPromoCode('AMRC11')">Kode Promo</a>
            <div class="promo-code" id="promo-amrc11">Kode Promo: AMRC11</div>
        </div>
    </div>
    </div>

    <script>
  document.addEventListener('DOMContentLoaded', function() {
    var promoButtons = document.querySelectorAll('.btn');


    promoButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault(); 

            var promoCode = this.getAttribute('onclick').match(/'([^']+)'/)[1];

            showPromoCode(promoCode);
        });
    });
});

    function showPromoCode(promoCode) {
        document.querySelectorAll('.promo-code').forEach(function(promo) {
            promo.style.display = 'none';
        });

        var promoId = 'promo-' + promoCode.toLowerCase();
        var promoElement = document.getElementById(promoId);
        if (promoElement) {
            promoElement.style.display = 'block';
        } else {
            console.error("Promo code element not found!");
        }
    }
    </script>
    <script src="/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
