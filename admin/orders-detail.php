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


$title = 'Order Detail'; // variable title untuk judul halaman
require_once 'layout/header.php';

$id_orders = (int)$_GET['id_orders'];

//JOIN = mengambungkan 2 table = 1 - 1 OK
$orders = select("SELECT * FROM products JOIN orders ON products.id_products = orders.product_id  WHERE orders.id_orders = $id_orders")[0];

?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"> <?= $title; ?> </h1>
    </div>

    <table class="table table-bordered">
        <tr>
            <th>Username</th>
            <td>:<?= $orders['name']; ?></td>
        </tr>
        <tr>
            <th>Phone</th>
            <td><?= $orders['phone']; ?></td>
        </tr>
        <tr>
            <th>qty / total</th>
            <td>:<?= $orders['qty']; ?>x / Rp. <?=number_format($orders['total'], 0, ',', '.');  ?></td>
        </tr>
        <tr>
            <th>Payment</th>
            <td>:<?= $orders['payment_method']; ?></td>
        </tr>
        
        <tr>
            <th>Is pay</th>
            <td>:<?= $orders['is_pay']; ?></td>
        </tr>

        <tr>
            <th>Address</th>
            <td><?= $orders['address']; ?></td>
        </tr>

         <tr>
            <th>Created At</th>
            <td>:<?= $orders['created_at']; ?></td>
        </tr>
        
        <tr>
            <th>Updated At</th>
            <td>:<?= $orders['updated_at']; ?></td>
        </tr>
    </table>

    <div class="d-flex gap-2 justify-content-end">
    <a href="orders.php" class="btn btn-secondary btn-sm mb-2">CANCEL OR KEMBALI</a>
    <a href="orders-create.php" class="btn btn-primary btn-sm mb-2">Add orders</a>
    </div>
</main>

<?php require_once 'layout/footer.php'; ?>