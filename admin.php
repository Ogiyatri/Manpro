<?php

if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda belum login, silahkan login terlebih dahulu.'); window.location.href = 'login.php';</script>";
    exit();
}

$userRole = $_SESSION['role'] ?? '';
$userId = $_SESSION['user_id'] ?? '';
?>

<?=template_header($userName,$date )?>

<h4>Anda adalah : <?php echo ($userRole === 'User') ? 'Pegawai' : $userRole; ?></h4>

<style>
    .card-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
        gap: 20px;
        margin-top: 20px;
    }

    .card {
        flex: 1 1 calc(100% - 20px); 
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.5s ease;
        margin-bottom: 20px;
    }

    .card:hover {
        transform: scale(1.02);
    }

    .card-body {
        text-align: center;
        padding: 15px;
    }
     .btn-warning:hover {
        color: white;
        background-color: red;
        border-color: red;
    }
    .btn-warning {
        color: red;
        background-color: white;
        border: 1px solid red;
        border-radius: 20px; 
        transition: background-color 0.3s, color 0.3s, border-color 0.3s, border-radius 0.3s;
 
     
    }
    .output-title {
        margin-bottom: 20px;
        font-size: 24px;
        font-weight: bold;
        color: #E32636;
    }

    .product-name {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 5px;
        color: red;
    }

    .product-quantity,
    .product-price {
        font-size: 14px;
        margin-bottom: 5px;
    }

    .btn-small {
        width: 30px;
    }
</style>

<div class="card-container">
    <?php $nomor = 1; ?>

    <?php
    // Combined query to retrieve both admin and user data
    $stmt = $koneksi->prepare("SELECT uid, nama, telepon, admin FROM user");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    foreach ($data as $user) {
        $status = ($user['admin'] == 1) ? 'Admin' : 'User';

        ?>
        <div class="card">
            <div class="card-body">
                <div class="product-name">Nama : <?php echo $user['nama']; ?></div>
                <div class="product-quantity">Telepon : <?php echo $user['telepon']; ?></div>
                <div class="product-price">Status : <?php echo $status; ?></div>
                <?php if ($_SESSION['role'] === 'Admin') : ?>
                    <div class="text-right">
                        <a href="index.php?page=ubahadmin&id=<?php echo $user['uid']; ?>" class="btn btn-warning">Ubah</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php $nomor++; ?>
    <?php } ?>
</div>


<?php if ($userRole === 'Admin') : ?>
    <a href="index.php?page=tambahadmin" class="btn btn-warning">Tambah Admin atau Pegawai</a>
<?php endif; ?>
