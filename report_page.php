<?php
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

// Fetch nama_obat from obat table for each id_obat
$obat = [];
foreach ($detail_penjualan as $detail) {
    $id_obat = $detail['id_obat'];
    $stmt = $koneksi->prepare("SELECT nama_obat, harga FROM obat WHERE id_obat = :id_obat");
    $stmt->bindParam(":id_obat", $id_obat);
    $stmt->execute();
    $obat[$id_obat] = [
        'nama_obat' => $stmt->fetchColumn(0), // Fetch nama_obat
        'harga' => $detail['harga'], // Use harga from detail_penjualan
        'quantity' => $detail['quantity'], // Use quantity from detail_penjualan
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .invoice {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .invoice h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .invoice p {
            font-weight: lighter; /* Adjust font weight for the date */
            font-size: 15px;
        }
        .invoice table {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice th, .invoice td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .invoice th {
            text-align: left;
        }
        .invoice td {
            text-align: right;
        }
        .total {
            font-weight: bold;
        }
        .btn-primary {
            color: white;
            background-color: red;
            border: 1px solid red;
            border-radius: 20px;
            transition: background-color 0.3s, color 0.3s, border-color 0.3s, border-radius 0.3s;
        }

        .btn-primary:hover {
            color: white;
            background-color: darkred;
            border-color: darkred;
            border-radius: 20px;
        }

    </style>
</head>
<body>
<div class="invoice">
    <h1>Invoice</h1>
    <p>Transaction Date: <?php echo $penjualan['tanggal']; ?></p>
    <table>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
        </tr>
        <?php
        $total_amount = 0;
        foreach ($detail_penjualan as $detail) {
            $id_obat = $detail['id_obat'];
            $nama_obat = $obat[$id_obat]['nama_obat'];
            $harga = $detail['harga'];
            $quantity = $detail['quantity'];
            $subtotal = $harga * $quantity;
            $total_amount += $subtotal;

            echo "<tr>";
            echo "<td>$nama_obat</td>";
            echo "<td>Rp. $harga</td>";
            echo "<td>$quantity</td>";
            echo "<td>Rp. $subtotal</td>";
            echo "</tr>";
        }
        ?>
        <tr class="total">
            <td colspan="3"><strong>Total Amount:</strong></td>
            <?php
            echo"<td><strong>Rp. $total_amount</strong></td>"
            ?>
        </tr>
    </table>
    <br>
    <div class="buttons">
        <a class="btn-primary btn" href="index.php">Home</a>
        <a class="btn btn-primary" href="index.php?page=download_invoice">Download PDF</a>
    </div>

</div>
</body>
</html>
