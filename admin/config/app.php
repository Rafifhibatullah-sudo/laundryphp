<?php
date_default_timezone_set('Asia/Jakarta');

include 'database.php'; // memanggil file database.php untuk koneksi
include 'function.php'; // memanggil file function.php untuk fungsi global

include 'controllers/products_controller.php';
include 'controllers/orders_controller.php';
include 'controllers/users_controller.php';