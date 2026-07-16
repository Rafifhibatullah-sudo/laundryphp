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

$title = 'Order Create'; // variable title untuk judul halaman
require_once 'layout/header.php';

$products = select("SELECT * FROM products WHERE status = '1' ORDER BY created_at DESC");

if (isset($_POST['submit'])) {
    if (createOrder($_POST) >  0) {
        echo "
                    <script>
                        alert('order created succesfully');
                        document.location.href = 'orders.php';
                    </script> //pindah ke prpducts
                    ";
    } else {
        echo "
        <script>
                    alert('order created failed');
                    document.location.href =  'orders.php';
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
        <form action="" method="post">

            <div class="mb-2">
                <label for="name" class="form-label">username</label>
                <input type="text" name="name" min="0" class="form-control" placeholder="Masukan name order" required>
            </div>

            <div class="row">
                <div class="form-group col-6">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="tel" name="phone" min="0" class="form-control" placeholder="Masukan phone order" required>
                </div>

                <div class="form-group col-6">
                    <label for="product_id" class="form-label">product</label>
                    <select class="form-select" name="product_id" required>
                        <option value="" hidden>-choose-</option>
                        <?php foreach ($products as $product) : ?>
                            <option value="<?= $product['id_products']; ?>"><?= $product['title']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-6">
                    <label for="payment_method" class="form-label">payment method</label>
                    <select class="form-select" name="payment_method" required>
                        <option value="" hidden>-choose-</option>
                        <option value="cash">cash</option>
                        <option value="qris">qris</option>
                        <option value="bank">bank</option>
                        <option value="pending">pending</option>
                    </select>
                </div>

                <div class="form-group col-6">
                    <label for="is_pay" class="form-label">is_pay</label>
                    <select class="form-select" name="is_pay" required>
                        <option value="" hidden>-choose-</option>
                        <option value="cash">cash</option>
                        <option value="dp">dp</option>
                        <option value="pending">pending</option>
                    </select>
                </div>
            </div>

            <div class="mb-2">
                <label for="qty" class="form-label">qty</label>
                <input type="number" name="qty" min="0" class="form-control" placeholder="Masukan qty order" required>
            </div>

            <div class="mb-5">
                <label for="address" class="form-label">Alamat</label>
                <input type="text" name="address" min="0" class="form-control" placeholder="Masukan alamat order" required>
            </div>

            <div class="mt-4 d-flex gap-2 justify-content-end">
                <a href="orders.php" class="btn btn-danger">Cancel</a>

                <button type="submit" name="submit" class="btn btn-primary">Submit</button>

                <button type="reset" name="reset" class="btn btn-warning">reset</button>
            </div>


        </form>
    </div>
</main>


<?php require_once 'layout/footer.php'; ?>