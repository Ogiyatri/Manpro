<?php

if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda belum login, silahkan login terlebih dahulu.'); window.location.href = 'login.php';</script>";
    exit();
}

if (isset($_GET['id'])) {
    $productID = $_GET['id'];
    
    // Disable foreign key checks
    $koneksi->query("SET FOREIGN_KEY_CHECKS=0");
    
    $query = $koneksi->query("DELETE FROM obat WHERE id_obat = '$productID'");
    
   
    $koneksi->query("SET FOREIGN_KEY_CHECKS=1");

    if ($query) {
        echo "<div class='alert alert-success'>Produk berhasil dihapus</div>";
    } else {
        echo "<div class='alert alert-danger'>Gagal menghapus produk</div>";
    }
    
    header("refresh:1;url=index.php?halaman=home");
} else {
    header("location: index.php?halaman=home");
    exit; 
}
?>
