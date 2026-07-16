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


$title = 'users Create'; // variable title untuk judul halaman
require_once 'layout/header.php';

$suers = select("SELECT * FROM users WHERE status = '1' ORDER BY created_at DESC");

if (isset($_POST['submit'])) {
    if (createUser($_POST) >  0) {
        echo "
                    <script>
                        alert('user created succesfully');
                        document.location.href = 'users.php';
                    </script> //pindah ke prpducts
                    ";
    } else {
        echo "
        <script>
                    alert('user'created failed');
                    document.location.href =  'users.php';
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
                <label for="name" class="form-label">name</label>
                <input type="text" name="name" class="form-control" placeholder="Masukan name user" required>
            </div>

             
            <div class="mb-2">
                <label for="title" class="form-label">user Image</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>

            <div class="mb-2">
                <label for="email" class="form-label">email</label>
                <input type="email" name="email" min="0" class="form-control" placeholder="Masukan email produk" required>
            </div>

            <div class="mb-3">
                <label for="password">password</label>
                <input type="password" name="password" id="password" class="form-control" required minlength="6">
            </div>

            <div class="mb-2">
                <label for="status" class="form-label">status</label>
                <select class="form-select" name="status" required>
                    <option value="" hidden>-choose-</option>
                    <option value="admin">admin</option>
                    <option value="operator">operator</option>
                </select>
            </div>

            <div class="mt-4 d-flex gap-2 justify-content-end">
                <a href="users.php" class="btn btn-danger">Cancel</a>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                <button type="reset" name="reset" class="btn btn-warning">reset</button>
            </div>

        </form>
    </div>
</main>

<?php require_once 'layout/footer.php'; ?>