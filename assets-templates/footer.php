<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://kit.fontawesome.com/e92cb405cc.js" crossorigin="anonymous"></script>
    <style>
        body {
            margin: 0;
            font-family: 'Times New Roman', Times, serif; /* Change font to Times New Roman */
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        footer {
            background-color: #f8baa1;
            color: #000; /* Font color is black */
            padding: 5px 5px;
            text-align: center;
            margin-top: auto;
        }
        .footer-content {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .footer-content div {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 10px;
        }
        .footer-content a {
            margin: 0 10px;
            text-decoration: none;
            color: black; /* Ensure icon color is black */
        }
        .footer-content i {
            background-color: white; /* Icon background color is white */
            border-radius: 50%; /* Make the icons circular */
            padding: 10px; /* Add padding to increase the size of the circle */
            font-size: 24px; /* Increase icon size */
            margin-bottom: 5px; /* Space between icon and text */
        }
        .footer-heading {
            font-weight: bold; /* Make "Contact Us" text bold */
        }
        @media (min-width: 768px) {
            .footer-content {
                flex-direction: row;
                justify-content: center;
            }
            .footer-content div {
                margin: 0 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Content of the page -->

    <footer>
        <h3 class="footer-heading">Kontak Kami</h3>
        <div class="footer-content">
            <div>
                <i class="fa-solid fa-phone"></i>
                <span>08123459075</span>
            </div>
            <div>
                <i class="fa-solid fa-envelope"></i>
                <span>foodget@gmail.com</span>
            </div>
            <div>
                <i class="fa-brands fa-facebook"></i>
                <span>footget.id</span>
            </div>
            <div>
                <i class="fa-brands fa-instagram"></i>
                <span>@footget</span>
            </div>
            <div>
                <i class="fa-solid fa-location-dot"></i>
                <span>Jl. Pandean, Serayu, Kota Madiun</span>
            </div>
    </footer>
</body>
</html>