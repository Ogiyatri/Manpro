<?php

if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda belum login, silahkan login terlebih dahulu.'); window.location.href = 'login.php';</script>";
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $koneksi->prepare("SELECT * FROM user WHERE uid = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        $tableName = 'user';
    } else {
        echo "Data not found";
        exit();
    }
    $stmt->closeCursor();
} else {
    // Redirect the user to the appropriate page if 'id' is not set
    header("Location: index.php?page=admin");
    exit();
}
?>

<?= template_header($userName, $date); ?>
<body>
    <h2>Edit Data</h2>

    <?php
    if (isset($_POST['update'])) {
        $nama = $_POST['nama'];
        $telepon = $_POST['telepon'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Validate and update data in the database
        // Use prepared statements to prevent SQL injection
        $stmt = $koneksi->prepare("UPDATE user SET nama = :nama, telepon = :telepon, password = :password WHERE uid = :id");
        $stmt->bindParam(':nama', $nama, PDO::PARAM_STR);
        $stmt->bindParam(':telepon', $telepon, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();


        // Show success message
        echo "<div class='alert alert-success'>Data updated successfully</div>";

        // Redirect to the appropriate page after updating
        header("refresh:2;url=index.php?page=");
        exit();
    }

    if (isset($_POST['delete'])) {
        // Delete data based on ID
        $stmt = $koneksi->prepare("DELETE FROM user WHERE uid = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();

        // Show success message
        echo "<div class='alert alert-info'>Data deleted successfully</div>";

        // Redirect to the appropriate page after deleting
        header("refresh:2;url=index.php?page=admin");
        exit();
    }

    ?>

    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control" name="nama" value="<?php echo $data['nama']; ?>">
        </div>
        <div class="form-group">
            <label>Telepon</label>
            <input type="tel" class="form-control" name="telepon" value="<?php echo $data['telepon']; ?>">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" name="password">
        </div>
        <button class="btn btn-primary" name="update">Update</button>
        <button class="btn btn-danger" name="delete">Delete</button>
    </form>

    <!-- Add your additional HTML or scripts here -->
</body>

</html>
