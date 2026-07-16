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


$id_orders = (int)$_GET['id_orders'];

if (deleteOrder($id_orders) > 0) {
    echo "
    <script>
    alert('orders deleted succesfully');
    document.location.href = 'orders.php';
    </script>
    ";
} else {
    echo "
    <script>
    alert('orders deleted failed');
    document.location.href = 'orders.php';
    </script>
    ";
}
