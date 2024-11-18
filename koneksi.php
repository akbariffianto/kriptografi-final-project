<?php
    $hostname = "localhost"; 
    $username = "root";     
    $password = "";     
    $database = "course_online";

    $konek = new mysqli($hostname, $username, $password, $database);

    if($konek->connect_error){
        die("Maaf Koneksi Gagal: ". $konek->connect_error);
    }
?>
