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

$title = 'Products Edit'; // variable title untuk judul halaman
require_once 'layout/header.php';

$id_products = (int)$_GET['id_products'];
$product = select("SELECT * FROM products WHERE id_products = $id_products")[0];

if (isset($_POST['submit'])) {

    $updateAction = update($_POST,$id_products);

    if($updateAction >  -1) {
        echo "
                    <script>
                        alert('Product created succesfully');
                        document.location.href = 'products.php';
                    </script> //pindah ke products
                    ";
    } else {
        echo "
                    alert('Product'created failed');
                    document.location.href =  'products.php';
                    ";
    }
}



?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="margin-bottom: 100px;">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"> <?= $title; ?> </h1>
    </div>

    <div>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="text" name="oldImage" value="<?= $product['image']; ?>" hidden>



            <div class="mb-2">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" class="form-control" placeholder="Masukan title produk" value="<?= $product['title']; ?>">
            </div>

            <div class="mb-2">
                <label for="price" class="form-label">Price</label>
                <input type="number" name="price" min="0" class="form-control" placeholder="Masukan price produk" value="<?= $product['price']; ?>">
            </div>

            <div class="mb-2">
                <label for="status" class="form-label">status</label>
                <select class="form-select" name="status">
                    <option value="1"<?= $product['status'] == 1 ? 'selected' : '' ?>>Active</option>
                    <option value="0"<?= $product['status'] == 0 ? 'selected' : '' ?>>InActive</option>
                </select>
            </div>

            <div class="mb-2">
                <label for="title" class="form-label">Prodcut Image</label>
                <input type="file" name="image" class="form-control" accept="image/*">

                <?php if ($product['image']) : ?>
                    <small>Previous Image</small>
                    <p>
                        <img src="assets/img/<?= $product['image'] ?>" width="150px">
                    </p>
                    <?php else : ?>
                        <small>No Image</small>
                        <?php endif; ?>
            </div>

         
            <div class="mt-4 d-flex gap-2 justify-content-end">
                <a href="products.php" class="btn btn-danger">Cancel</a>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                <button type="reset" name="reset" class="btn btn-warning">reset</button>
            </div>


        </form>
    </div>
</main>

<?php require_once 'layout/footer.php'; ?>