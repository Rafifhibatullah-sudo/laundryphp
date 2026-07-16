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


$title = 'Products Create'; // variable title untuk judul halaman
require_once 'layout/header.php';

$products = select("SELECT * FROM products WHERE status = '1' ORDER BY created_at DESC");


if (isset($_POST['submit'])) {
    if (create($_POST) >  0) {
        echo "
                    <script>
                        alert('Product created succesfully');
                        document.location.href = 'products.php';
                    </script> //pindah ke prpducts
                    ";
    } else {
        echo "
        <script>
                    alert('Product'created failed');
                    document.location.href =  'products.php';
                    </script>";
    }
}



?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"> <?= $title; ?> </h1>
    </div>

    <div>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-2">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" class="form-control" placeholder="Masukan title produk" required>
            </div>

            <div class="mb-2">
                <label for="price" class="form-label">Price</label>
                <input type="number" name="price" min="0" class="form-control" placeholder="Masukan price produk" required>
            </div>

            <div class="mb-2">
                <label for="status" class="form-label">status</label>
                <select class="form-select" name="status" required>
                    <option value="" hidden>-choose-</option>
                    <option value="1">Active</option>
                    <option value="0">InActive</option>
                </select>
            </div>

            
            <div class="mb-2">
                <label for="title" class="form-label">Procut Image</label>
                <input type="file" name="image" class="form-control" accept="image/*">
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