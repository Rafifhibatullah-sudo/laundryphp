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

require_once 'config/app.php';


$id_products = (int)$_GET['id_products'];

if (delete($id_products) > 0) {
    echo "
    <script>
    alert('Product deleted succesfully');
    document.location.href = 'products.php';
    </script>
    ";
} else {
    echo "
    <script>
    alert('Product deleted failed');
    document.location.href = 'products.php';
    </script>
    ";
}
