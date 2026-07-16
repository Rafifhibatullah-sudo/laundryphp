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


$id_users = (int)$_GET['id_users'];

if (deleteUser($id_users) > 0) {
    echo "
    <script>
    alert('user deleted succesfully');
    document.location.href = 'users.php';
    </script>
    ";
} else {
    echo "
    <script>
    alert('user deleted failed');
    document.location.href = 'users.php';
    </script>
    ";
}
