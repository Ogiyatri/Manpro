<?php

/*if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda belum login, silahkan login terlebih dahulu.'); window.location.href = 'login.php';</script>";
    exit();
}*/

// Check to make sure the id parameter is specified in the URL
if (isset($_GET['id'])) {
    // Prepare statement and execute, prevents SQL injection
    $stmt = $koneksi->prepare('SELECT * FROM obat WHERE id_obat = :id');
    $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();
    // Store the result so we can check if the record exists in the database
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the product exists (array is not empty)
    if (!$product) {
        // Product doesn't exist
        echo "<script>alert('Product does not exist!'); window.location.href = 'index.php';</script>";
        exit;
    }

    // Close the statement when done
    $stmt->closeCursor();
} else {
    // ID parameter was not specified
    echo "<script>alert('Product does not exist!'); window.location.href = 'index.php';</script>";
    exit;
}
?>

<?=template_header($userName, $date)?>
<style>
    .btn-primary {
        color: white;
        background-color: red;
        border: 1px solid red;
        border-radius: 5px;
        transition: background-color 0.3s, color 0.3s, border-color 0.3s, border-radius 0.3s;
    }

    .btn-primary:hover {
        color: white;
        background-color: darkred;
        border-color: darkred;
        border-radius: 5px;

    }
    .price {
        display: block;
        font-size: 22px;
        color: #999999;
    }
</style>


<div class="container " style="width: 75vw; padding-top: 5vh">
    <div class="row text-justify">
        <!-- Column for the image -->
        <div class="col-md-6">
            <img src="../foto_produk/<?=$product['foto_obat']?>" class="img-thumbnail" alt="<?=$product['nama_obat']?>">
        </div>
        <!-- Column for the product name, description, price, etc. -->
        <div class="col-md-6">
            <h1 class="name"><?=$product['nama_obat']?></h1>
            <span class="price">
                Rp<?=$product['harga']?>
            </span>
            <form action="index.php?page=keranjang" method="post" style="padding-top: 10px; padding-bottom: 10px">
                <input type="number" name="quantity" value="1" min="1" max="<?=$product['stok']?>" placeholder="Quantity" required>
                <input type="hidden" name="id_obat" value="<?=$product['id_obat']?>">
                <input type="submit" value="Add To Cart" class="btn-primary">
            </form>
            <div class="description">
                <?=$product['deskripsi']?>
            </div>
        </div>
    </div>
    <div style="padding-top: 50px">
        <div class="row">
            <div class="col-md-2">
                <a href="index.php" class="btn btn-primary">Return to Home Page</a>
            </div>
            <div class="col-md-10 text-left">
                <a href="index.php?page=ubahproduk&id=<?=$product['id_obat']?>" class="btn btn-primary">Edit Detail</a>
            </div>
        </div>
    </div>
</div>


