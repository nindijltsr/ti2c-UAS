<?php
    $hostname = "localhost";
    $username = "root";
    $password = "" ;
    $database_name = "nama_sb";

    $db = mysqli_connect($hostname, $username, $password, $database_name);

    if ($db->connect_error) {
        echo "Koneksi Database Rusak";
        die("ERROR!");
    }
?>