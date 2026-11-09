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



$title = 'orders Edit'; // variable title untuk judul halaman
require_once 'layout/header.php';

$id_orders = (int)$_GET['id_orders'];

$orders = select("SELECT * FROM orders WHERE id_orders = $id_orders")[0];

$products = select("SELECT * FROM products WHERE status = '1' ORDER BY created_at DESC");

if (isset($_POST['submit'])) {

    $updateAction = updateOrder($_POST, $id_orders);

    if ($updateAction >  -1) {
        echo "
                    <script>
                        alert('order edit succesfully');
                        document.location.href = 'orders.php';
                    </script> //pindah ke orders
                    ";
    } else {
        echo "
                    alert('order edit failed');
                    document.location.href =  'orders.php';
                    ";
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
                <label for="name" class="form-label">name</label>
                <input type="text" name="name" min="0" class="form-control" placeholder="Masukan name order" value="<?= $orders['name']; ?>">
            </div>

            <div class="row">
                <div class="form-group col-6">
                    <label for="phone" class="form-label">phone</label>
                    <input type="tel" name="phone" min="0" class="form-control" placeholder="Masukan phone order" value="<?= $orders['phone']; ?>">
                </div>

                <div class="form-group col-6">
                    <label for="product_id" class="form-label">product</label>
                    <select class="form-select" name="product_id" required>
                        <?php foreach ($products as $product) : ?>
                            <option value="<?= $product['id_products']; ?>" <?= $orders['product_id'] == $product['id_products'] ? 'selected' : '' ?>>
                                <?= $product['title']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-6">
                    <label for="payment_method" class="form-label">payment method</label>
                    <select class="form-select" name="payment_method" required>
                        <option value="cash" <?= $orders['payment_method'] == 'cash' ? 'selected' : '' ?>>cash</option>
                        <option value="qris" <?= $orders['payment_method'] == 'qris' ? 'selected' : '' ?>>qris</option>
                        <option value="bank" <?= $orders['payment_method'] == 'bank' ? 'selected' : '' ?>>bank</option>
                        <option value="pending" <?= $orders['payment_method'] == 'pending' ? 'selected' : '' ?>>pending</option>
                    </select>
                </div>

                <div class="form-group col-6">
                    <label for="is_pay" class="form-label">is_pay</label>
                    <select class="form-select" name="is_pay" required>
                        <option value="cash" <?= $orders['is_pay'] == 'cash' ? 'selected' : '' ?>>cash</option>
                        <option value="dp" <?= $orders['is_pay'] == 'dp' ? 'selected' : '' ?>>dp</option>
                        <option value="pending" <?= $orders['is_pay'] == 'pending' ? 'selected' : '' ?>>pending</option>
                    </select>
                </div>
            </div>

            <div class="mb-2">
                <label for="qty" class="form-label">qty</label>
                <input type="number" name="qty" min="0" class="form-control" placeholder="Masukan qty order" value="<?= $orders['qty']; ?>">
            </div>

            <div class="mb-2">
                <label for="address" class="form-label">Alamat</label>
                <input type="text" name="address" min="0" class="form-control" placeholder="Masukan alamat order" value="<?= $orders['address']; ?>">
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