<h2>Ubah Produk</h2>

<?php

if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda belum login, silahkan login terlebih dahulu.'); window.location.href = 'login.php';</script>";
    exit();
}

$koneksi = new mysqli("localhost", "root", "", "farmasi");
if (isset($_GET['id'])) {
    $ambil = $koneksi->query("SELECT * FROM obat WHERE id_obat='$_GET[id]'");
    $pecah = $ambil->fetch_assoc();
?>
    <style>
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
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Nama Produk</label>
            <input type="text" name="nama" class="form-control" value="<?php echo isset($pecah['nama_obat']) ? $pecah['nama_obat'] : ''; ?>">
        </div>

        <div class="form-group">
            <label>Harga Rp</label>
            <input type="number" class="form-control" name="harga" value="<?php echo isset($pecah['harga']) ? $pecah['harga'] : ''; ?>">
        </div>

        <div class="form-group">
            <label>Stok</label>
            <input type="number" class="form-control" name="stok" value="<?php echo isset($pecah['stok']) ? $pecah['stok'] : ''; ?>">
        </div>
        
        <div class="form-group">
            <img src="../foto_produk/<?php echo isset($pecah['foto_obat']) ? $pecah['foto_obat'] : ''; ?>" width="200">
        </div>
        
        <div class="form-group">
            <label>Ganti Foto</label>
            <input type="file" name="foto" class="form-control">
        </div>
        
        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="10"><?php echo isset($pecah['deskripsi']) ? $pecah['deskripsi'] : ''; ?></textarea>
        </div>
        
        <button class="btn btn-primary" name="ubah">Ubah</button>
    </form>

<?php
    if (isset($_POST['ubah'])) {
        $namafoto = $_FILES['foto']['name'];
        $lokasifoto = $_FILES['foto']['tmp_name'];
        
        if (!empty($lokasifoto)) {
            $oldPhoto = isset($pecah['foto_obat']) ? $pecah['foto_obat'] : '';
            if ($oldPhoto != 'default.jpg') {
                unlink("../foto_produk/$oldPhoto");
            }

            move_uploaded_file($lokasifoto, "../foto_produk/$namafoto");

            $koneksi->query("UPDATE obat SET
                nama_obat = '$_POST[nama]',
                harga = '$_POST[harga]',
                stok = '$_POST[stok]',
                deskripsi = '$_POST[deskripsi]',
                foto_obat = '$namafoto'
                WHERE id_obat = '$_GET[id]'
            ");
        } else {
            $koneksi->query("UPDATE obat SET
                nama_obat = '$_POST[nama]',
                harga = '$_POST[harga]',
                stok = '$_POST[stok]',
                deskripsi = '$_POST[deskripsi]'
                WHERE id_obat = '$_GET[id]'
            ");
        }

        echo "<script>alert('Data produk telah diubah');</script>";
        echo "<script>location='index.php?halaman=index.php;</script>";
    }

} else {
    echo "ID parameter is not set.";
}
?>
