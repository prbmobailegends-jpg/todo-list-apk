<?php
$host = "localhost";
$user = "root";      // user default XAMPP
$pass = "";          // password kosong (default)
$db   = "todo_app";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>