<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda belum login, silahkan login terlebih dahulu.'); window.location.href = 'login.php';</script>";
    exit();
}
if (!empty($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
    try{
        $koneksi->beginTransaction();

        $subtotal = floatval($_GET['subtotal']);
        $tanggal = date('Y-m-d');

        $stmt = $koneksi->prepare("INSERT INTO penjualan (tanggal, total_penjualan) VALUES (:tanggal, :subtotal)");
        $stmt->bindParam(':tanggal', $tanggal);
        $stmt->bindParam(':subtotal', $subtotal);
        $stmt->execute();

        $id_penjualan = $koneksi->lastInsertId();
        echo "<p>id : $id_penjualan</p>";
        foreach ($cart as $product_id => $quantity) {
            $stmt = $koneksi->prepare("SELECT harga FROM obat WHERE id_obat = :product_id");
            $stmt->bindParam(':product_id', $product_id);
            $stmt->execute();
            $currentPrice = $stmt->fetchColumn();

            $stmt = $koneksi->prepare("INSERT INTO detail_penjualan (id_penjualan, id_obat, quantity, harga) VALUES (:id_penjualan, :id_obat, :quantity, :harga)");
            $stmt->bindParam(':id_penjualan', $id_penjualan);
            $stmt->bindParam(':id_obat', $product_id);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':harga', $currentPrice);
            $stmt->execute();

            $stmt = $koneksi->prepare("UPDATE obat SET stok = stok - :quantity WHERE id_obat = :product_id");
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':product_id', $product_id);
            $stmt->execute();
        }
        $koneksi->commit();
        // Output success message and order details
        echo "<p>Checkout successful. Your order has been processed. Thank you for shopping!</p>";
        echo '<a href="index.php?page=report_page&id=' . $id_penjualan . '"><button>View Transaction Report</button></a>';

        unset($_SESSION['cart']);

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        $koneksi->rollBack();
    }
}
?>