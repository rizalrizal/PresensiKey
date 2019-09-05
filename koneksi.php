<?php

   // Start Konfigurasi Koneksi Database
   $dbname     = 'presensikey';
   $dbusername = 'root';
   $dbpassword = '';
   $base_url = "http://localhost/presensiKEY";

   $dbh = new PDO("mysql:host=localhost;dbname=$dbname", $dbusername, $dbpassword);
   // End Konfigurasi Koneksi Database

   
   
?>