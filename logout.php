<?php

if ($_SESSION['isLoggedIn']) {
    session_destroy();
} else {
    echo "<script>alert('Anda belum login, silahkan login terlebih dahulu.'); window.location.href = 'login.php';</script>";
    exit();
}

echo "<script>location='login.php';</script>";
?>
