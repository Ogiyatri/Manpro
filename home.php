<?php
$stmt = $koneksi->prepare('SELECT * FROM obat');
$stmt->execute();
$ambil = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?=template_header($userName, $date)?>

<style>
    .card-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(18rem, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .card {
        width: 100%;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.5s ease;
    }
    .card:hover {
        transform: scale(1.10);
    }

    .card-body {
        text-align: center;
        padding: 15px;
    }
    .btn-danger,
    .btn-warning {
        color: red;
        background-color: white;
        border: 1px solid red;
        transition: background-color 0.3s, color 0.3s, border-color 0.3s;
    }

    .btn-danger:hover,
    .btn-warning:hover {
        color: white;
        background-color: red;
        border-color: red;
    }
    .btn-danger,
    .btn-warning {
        color: red;
        background-color: white;
        border: 1px solid red;
        border-radius: 20px;
        transition: background-color 0.3s, color 0.3s, border-color 0.3s, border-radius 0.3s;
    }
    .btn-succes:hover {
        color: white;
        background-color: red;
        border-color: red;
    }

    .btn-success {
        color: green;
        background-color: white;
        border: 1px solid green;
        border-radius: 20px;
        transition: background-color 0.3s, color 0.3s, border-color 0.3s, border-radius 0.3s;
    }

    .btn-danger:hover,
    .btn-warning:hover {
        color: white;
        background-color: red;
        border-color: red;
        border-radius: 20px;
    }
    .search-container {
        display: flex;
        justify-content: flex-start;
        margin-bottom: 20px;

    }

    .search-input {
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-right: 30px;
    }

    .search-button {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #007bff;

        cursor: pointer;

    }


    .search-button:hover {
        background-color: #00563;

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
    .card img {
        width: 100%;
        height: 100px;
        object-fit: contain;
        max-width: 90%;

    }

    .card-body {
        text-align: center;
        padding: 15px;
    }
    .card-text {
        margin-bottom: 13px;
    }
    .output-title {
        margin-bottom: 20px;
        font-size: 24px;
        font-weight: bold;
        color: #E32636;


    }

    .card-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(18rem, 1fr));
        gap: 20px;
    }
    .card-body {
        text-align: center;
        padding: 15px;
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
    .btn-danger,
    .btn-warning {
        margin-top: 10px;
        margin-right: 5px;
        margin-left: 5px;
    }
    .product-quantity.low-stock {
        color: red;
    }
    .btn-small {
        width: 30px;
    }


</style>

<script>
    // Function to handle the form submission for incrementing and decrementing stock
    function updateStock(id_obat, action) {
        // Get the form data
        var formData = new FormData();
        formData.append('id_obat', id_obat);
        formData.append('action', action); // 'increment' or 'decrement'

        // Create an AJAX request
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'updatestock.php', true);

        // Define the callback function when the AJAX request is complete
        xhr.onload = function () {
            if (xhr.status === 200) {
                // Update the stock on the client side
                var stockElement = document.getElementById('stock_' + id_obat);
                stockElement.innerText = xhr.responseText; // Assuming the response contains the updated stock value
            }
        };

        // Send the form data
        xhr.send(formData);
    }
</script>

<div class="output-title">DATA PRODUK</div>
<input type="text" class="search-input" id="searchInput" placeholder="Search...">
<a href="index.php?page=keranjang" class="search-button btn btn-primary">🛒 Keranjang</a>

<div class="card-container">
    <?php
    foreach ($ambil as $pecah) {
        ?>
        <div class="card">
            <img src="../foto_produk/<?php echo $pecah['foto_obat']; ?>" class="card-img-top" alt="Product Image">
            <div class="card-body">
                <h5 class="card-title product-name"><?php echo $pecah['nama_obat']; ?></h5>
                <?php if (isset($pecah['stok'])) : ?>
                    <p class="card-text mb-2 product-quantity <?php echo ($pecah['stok'] < 5) ? 'low-stock' : ''; ?>">
                        Stock: <?php echo $pecah['stok']; ?><?php echo ($pecah['stok'] < 5) ? ' (Low)' : ''; ?>
                    </p>
                <?php endif; ?>
                <form action="index.php?page=updatestock" method="post">
                    <input type="hidden" name="id_obat" value="<?php echo $pecah['id_obat']; ?>">
                    <input type="hidden" name="change" value="1">
                    <button type="submit" class="btn btn-success btn-small">+</button>
                </form>
                <form action="index.php?page=updatestock" method="post">
                    <input type="hidden" name="id_obat" value="<?php echo $pecah['id_obat']; ?>">
                    <input type="hidden" name="change" value="-1">
                    <button type="submit" class="btn btn-danger btn-small">-</button>
                </form>
                <p class="card-text mb-2 product-price">Harga: Rp<?php echo number_format($pecah['harga'], 0, ',', '.'); ?></p>
                <a href="index.php?page=hapusproduk&id=<?php echo $pecah['id_obat'] ?>" class="btn btn-danger">Hapus</a>
                <a href="index.php?page=detail&id=<?php echo $pecah['id_obat'] ?>" class="btn btn-warning">Detail</a>
            </div>
        </div>
    <?php } ?>
</div>


<a href="index.php?page=tambahproduk" class="btn btn-primary">Tambah Data</a>

<script>
    var searchInput = document.getElementById('searchInput');

    searchInput.addEventListener('input', function () {
        searchProducts();
    });

    function searchProducts() {
        var searchText = searchInput.value.toLowerCase();
        var cards = document.querySelectorAll('.card');

        cards.forEach(function (card) {
            var cardTitle = card.querySelector('.card-title').innerText.toLowerCase();
            if (cardTitle.includes(searchText)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
</script>
