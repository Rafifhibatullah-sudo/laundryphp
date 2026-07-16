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

$title = 'users Edit'; // variable title untuk judul halaman
require_once 'layout/header.php';

$id_users = (int)$_GET['id_users'];
$user = select("SELECT * FROM users WHERE id_users = $id_users")[0];

if (isset($_POST['submit'])) {

    $updateAction = updateUser($_POST, $id_users);

    if ($updateAction >  -1) {
        echo "
                    <script>
                        alert('user created succesfully');
                        document.location.href = 'users.php';
                    </script> //pindah ke users
                    ";
    } else {
        echo "
                    alert('user'created failed');
                    document.location.href =  'users.php';
                    ";
    }
}



?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="margin-bottom: 100px;">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"> <?= $title; ?> </h1>
    </div>

    <div>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="text" name="oldImage" value="<?= $user['image']; ?>" hidden>

            <div class="mb-2">
                <label for="name" class="form-label">name</label>
                <input type="text" name="name" class="form-control" placeholder="Masukan nama user" value="<?= $user['name']; ?>">
            </div>

            <div class="mb-2">
                <label for="title" class="form-label">user Image</label>
                <input type="file" name="image" class="form-control" accept="image/*">

                <?php if ($user['image']) : ?>
                    <small>Previous Image</small>
                    <p>
                        <img src="assets/img/akun/<?= $user['image'] ?>" width="150px">
                    </p>
                    <?php else : ?>
                        <small>No Image</small>
                        <?php endif; ?>
            </div>


    <div class="mb-2">
        <label for="email" class="form-label">email</label>
        <input type="email" name="email" min="0" class="form-control" placeholder="Masukan email produk" value="<?= $user['email']; ?>">
    </div>

    <div class="mb-2">
        <label for="password" class="form-label">password</label>
        <input type="password" name="password" min="0" class="form-control" placeholder="Masukan password produk" value="<?= $user['password']; ?>">
    </div>


    <div class="mb-2">
        <label for="status" class="form-label">status</label>
        <select class="form-select" name="status">
            <option value="admin" <?= $user['status'] == 'admin' ? 'selected' : '' ?>>admin</option>
            <option value="operator" <?= $user['status'] == 'operator' ? 'selected' : '' ?>>operator</option>
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