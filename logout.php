<?php
session_start();

//menghancurkan $_SESSION["pelanggan"]
session_destroy();

echo "<script>alert('Anda Telah Logout');</script>";
echo "<script>location='index.php';</script>";

?>
