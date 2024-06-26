<?php
// Assuming you have already established a PDO connection ($koneksi)

if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda belum login, silahkan login terlebih dahulu.'); window.location.href = 'login.php';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_obat = $_POST["nama_obat"];
    $stok = $_POST["stok"];
    $harga = $_POST["harga"];
    $foto_obat = $_FILES["foto_obat"]["name"];
    $foto_tmp = $_FILES["foto_obat"]["tmp_name"];

    move_uploaded_file($foto_tmp, "../foto_produk/" . $foto_obat);

    // Use prepared statements to insert data into the database
    $stmt = $koneksi->prepare("INSERT INTO obat (nama_obat, stok, harga, foto_obat) VALUES (:nama_obat, :stok, :harga, :foto_obat)");
    $stmt->bindParam(':nama_obat', $nama_obat);
    $stmt->bindParam(':stok', $stok);
    $stmt->bindParam(':harga', $harga);
    $stmt->bindParam(':foto_obat', $foto_obat);
    $stmt->execute();

    echo "<script>alert('Produk berhasil ditambahkan.'); window.location.href = 'index.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Produk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            border-top: 5px solid red;
        }
        h2 {
            margin-top: 0;
            text-align: center;
            color: red;
        }
        form div {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        input[type="text"], input[type="number"], input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            background-color: red;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #cc0000;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: red;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        @media (max-height: 600px) {
            body {
                justify-content: flex-start;
                padding-top: 20px;
            }
            .container {
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Tambah Produk</h2>
        <form method="POST" enctype="multipart/form-data">
            <div>
                <label for="nama_obat">Nama Obat</label>
                <input type="text" id="nama_obat" name="nama_obat" required>
            </div>
            <div>
                <label for="stok">Stok</label>
                <input type="number" id="stok" name="stok" required>
            </div>
            <div>
                <label for="harga">Harga</label>
                <input type="number" id="harga" name="harga" required>
            </div>
            <div>
                <label for="foto_obat">Foto Obat</label>
                <input type="file" id="foto_obat" name="foto_obat" required>
            </div>
            <button type="submit">Tambah</button>
            <a href="index.php" class="back-link">Kembali</a>
        </form>
    </div>
</body>
</html>
