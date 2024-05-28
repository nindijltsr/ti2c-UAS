<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Summary</title>
    <link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
</head>

<?php include '../assets-templates/header.php'; ?>

<body>
    <div class="container">
        <div class="order-summary">
            <h2>Ringkasan Pesanan</h2>
            <div class="item">
                <span>Seafood Noodle</span>
                <span>x 1</span>
                <span>Rp. 95,000</span>
            </div>
            <div class="summary">
                <div class="total">
                    <span>Total</span>
                    <span>Rp. 95,000</span>
                </div>
            </div>
        </div>
        <div class="order-action">
            <input type="text" placeholder="Masukkan Kupon/Kode Promo">
            <div class="total-amount">Rp. 95,000</div>
            <div class="button-group">
                <button>Pesan</button>
                <button id="cancel-order">Batalkan Pesanan</button>
            </div>
        </div>
    </div>
    <?php include '../assets-templates/footer.html'; ?>
    <script src="../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
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
</style>
