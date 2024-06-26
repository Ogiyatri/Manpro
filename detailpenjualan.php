<?php
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda belum login, silahkan login terlebih dahulu.'); window.location.href = 'login.php';</script>";
    exit();
}

$id_penjualan = $_GET['id'];

// Fetch penjualan details (assuming you need them)
$stmt = $koneksi->prepare("SELECT * FROM penjualan WHERE id_penjualan = :id_penjualan");
$stmt->bindParam(":id_penjualan", $id_penjualan);
$stmt->execute();
$penjualan = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch detail_penjualan details
$stmt = $koneksi->prepare("SELECT * FROM detail_penjualan WHERE id_penjualan = :id_penjualan");
$stmt->bindParam(":id_penjualan", $id_penjualan);
$stmt->execute();
$detail_penjualan = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch nama_obat and foto_obat from obat table for each id_obat
$obat = [];
foreach ($detail_penjualan as $detail) {
    $id_obat = $detail['id_obat'];
    $stmt = $koneksi->prepare("SELECT nama_obat, harga, foto_obat FROM obat WHERE id_obat = :id_obat");
    $stmt->bindParam(":id_obat", $id_obat);
    $stmt->execute();
    $obat[$id_obat] = [
        'nama_obat' => $stmt->fetchColumn(0), // Fetch nama_obat
        'harga' => $detail['harga'], // Use harga from detail_penjualan
        'quantity' => $detail['quantity'], // Use quantity from detail_penjualan
        'foto_obat' => $stmt->fetchColumn(2), // Fetch foto_obat
    ];
}
?>

<?=template_header($userName, $date)?>

<h2>Transaction Details</h2>

<p>Transaction Date: <?php echo $penjualan['tanggal']; ?></p>
<p>Transaction ID: <?php echo $id_penjualan; ?></p>
<table class="table table-bordered">
    <thead>
    <tr>
        <th>No</th>
        <th>ID Obat</th>
        <th>Nama Obat</th>
        <th>Harga Per QTY</th>
        <th>Jumlah</th>
        <th>Subtotal</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $nomor = 1;
    $total_amount = 0;
    foreach ($detail_penjualan as $detail) {
        $id_obat = $detail['id_obat'];
        $nama_obat = $obat[$id_obat]['nama_obat'];
        $harga = $detail['harga'];
        $quantity = $detail['quantity'];
        $subtotal = $harga * $quantity;
        $total_amount += $subtotal;

        echo "<tr>";
        echo "<td>$nomor</td>";
        echo "<td>$id_obat</td>";
        echo "<td>$nama_obat</td>";
        echo "<td>Rp. $harga</td>";
        echo "<td>$quantity</td>";
        echo "<td>Rp. $subtotal</td>";
        echo "</tr>";
        $nomor++;
    }
    ?>
    <tr class="total">
        <td colspan="5"><strong>Total Amount:</strong></td>
        <?php
        echo"<td colspan='1'><strong>Rp. $total_amount</strong></td>"
        ?>
    </tr>
    </tbody>
</table>

<a class="btn btn-primary" href="index.php?page=history">kembali</a>
<a class="btn btn-primary" href="index.php?page=home">Home</a>
