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

$title = 'product Detail'; // variable title untuk judul halaman
require_once 'layout/header.php';

$id_products = (int)$_GET['id_products'];

//JOIN = mengambungkan 2 table = 1 - 1 OK
$products = select("SELECT * FROM orders JOIN products ON products.id_products  WHERE products.id_products = $id_products")[0];


?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 bproduct-bottom">
        <h1 class="h2"> <?= $title; ?> </h1>
    </div>

    <table class="table table-bordered">
        <tr>
            <th>Product</th>
            <td>:<?= $products['title']; ?></td>
        </tr>

        <tr>
            <td width="50%">Foto</td>
            <td><a href="assets/img/<?= $products['image']; ?>">
                    <img src="assets/img/<?= $products['image']; ?>" alt="foto" width="40%">
                </a>
            </td>
        </tr>

        <tr>
            <th>price</th>
            <td>:Rp. <?= number_format($products['price'], 0, ',', '.'); ?></td>
        </tr>

        <tr>
            <th>status</th>
            <td>:<?= $products['status']; ?></td>
        </tr>

        <tr>
            <th>Created At</th>
            <td>:<?= $products['created_at']; ?></td>
        </tr>

        <tr>
            <th>video url</th>
            <td><iframe width="560" height="315" src="https://www.youtube.com/embed/ocXLxyBlTbY<?= $products['video_url'] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </td>
        </tr>


    </table>

    <div class="d-flex gap-2 justify-content-end">
        <a href="products.php" class="btn btn-secondary btn-sm mb-2">CANCEL OR KEMBALI</a>
        <a href="products-create.php" class="btn btn-primary btn-sm mb-2">Add products</a>
    </div>
</main>

<?php require_once 'layout/footer.php'; ?>