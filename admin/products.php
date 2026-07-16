<?php

session_start();
// membatasi halaman login
if (!isset($_SESSION['login'])) {
    echo "
    <script>
    alert('login sebelum masuk ya');
    document.location.href = 'login.php';
    
    </script>";
    exit;
}


$title = 'Products'; // variable title untuk judul halaman
require_once 'layout/header.php';


//DESC = desending -> urutan dari terbaru 
//ASC = asconding -> urutan dari terlama
$products = select("SELECT * FROM products ORDER BY created_at DESC");

?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"> <?= $title; ?> </h1>
    </div>

    <a href="products-create.php" class="btn btn-primary btn-sm mb-2">Add Product</a>

    <div class="table-responsive small">
        <table class="table table-striped table-bordered table-sm" id="productsTable">
            <thead>
                <tr>
                    <th scope="col" width="1%">No</th>
                    <th scope="col">Title</th>
                    <th scope="col" width="1%">Image</th>
                    <th scope="col">Price</th>
                    <th scope="col">Barcode</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($products as $index => $product) : ?>
                    <?php
                    if ($product['status'] == 1) {
                        $product['status'] = "<span class='badge bg-success'>Active</span>";
                    } else {
                        $product['status'] = "<span class='badge bg-danger'>Inactive</span>";
                    }

                    ?>
                    <tr>
                        <td class="text-center"><?= $index + 1; ?></td>
                        <td><?= $product['title']; ?></td>
                        <td>
                            <img src="assets/img/<?= $product['image']; ?>" style="width: 200px;" alt="tidak ada gambar">
                        </td>
                        <td><?= $product['price']; ?></td>
                        
                        <td class="text-center">
                            <img alt="barcode" src="barcode.php?codetype=Code128&size=15&text=<?= $product['barcode']; ?>&print=true" />
                        
                        </td>
                        
                        <td><?= $product['status']; ?></td>
                        <td><?= date('d-m-Y H:i:s', strtotime($product['created_at'])); ?></td>
                        <td class="text-center">
                            <a href="products-detail.php?id_products=<?= $product['id_products']; ?>" class="btn btn-sm btn-secondary mb-2">detail</a>

                            <a href="products-edit.php?id_products=<?= $product['id_products']; ?>" class="btn btn-sm btn-success mb-2">edit</a>

                            <a href="products-delete.php?id_products=<?= $product['id_products']; ?>" class="btn btn-sm btn-danger mb-2" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<script>
    $(document).ready(function() {
        $('#productsTable').DataTable();
    })
</script>

<?php require_once 'layout/footer.php'; ?>