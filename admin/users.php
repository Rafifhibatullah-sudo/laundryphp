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

$title = 'Users'; // variable title untuk judul halaman
require_once 'layout/header.php';


//DESC = desending -> urutan dari terbaru 
//ASC = asconding -> urutan dari terlama
$users = select("SELECT * FROM users ORDER BY created_at DESC");

?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"> <?= $title; ?> </h1>
    </div>

    <a href="users-create.php" class="btn btn-primary btn-sm mb-2">Add Product</a>

    <div class="table-responsive small">
        <table class="table table-striped table-bordered table-sm" id="usersTable">
            <thead>
                <tr>
                    <th scope="col" width="1%">No</th>
                    <th scope="col">name</th>
                    <th scope="col">image</th>
                    <th scope="col" width="1%">Email</th>
                    <th scope="col">status</th>
                    <th scope="col">password</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($users as $index => $user) : ?>
                    <?php
                    if ($user['status'] == 'admin') {
                        $user['status'] = "<span class='badge bg-success'>Admin</span>";
                    } else {
                        $user['status'] = "<span class='badge bg-danger'>operator</span>";
                    }

                    ?>
                    <tr>
                        <td class="text-center"><?= $index + 1; ?></td>
                        <td><?= $user['name']; ?></td>
                         <td>
                            <img src="assets/img/akun/<?= $user['image']; ?>" style="width: 200px;" alt="tidak ada gambar">
                        </td>
                        <td>
                            <?= $user['email']; ?>
                        </td>
                        <td><?= $user['status']; ?></td>
                        <td>password rahasia</td>
                        <td><?= date('d-m-Y H:i:s', strtotime($user['created_at'])); ?></td>
                        <td class="text-center">
                            <a href="users-edit.php?id_users=<?= $user['id_users']; ?>" class="btn btn-sm btn-success mb-2" >edit</a>

                            <a href="users-delete.php?id_users=<?= $user['id_users']; ?>" class="btn btn-sm btn-danger mb-2" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<script>
    $(document).ready(function(){
        $('#usersTable').DataTable();
    })
</script>

<?php require_once 'layout/footer.php'; ?>