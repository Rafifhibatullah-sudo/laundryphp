<?php

session_start();


include 'config/app.php';

global $conn;



if (isset($_POST['login'])) {
    // ambil input usename dan password
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // secret key
    $secret_key = "6LfiY0wtAAAAAM1mXhooreOTJ8yfZfdxcC3v_wAK";

    $verifikasi = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $_POST['g-recaptcha-response']);

    $response = json_decode($verifikasi);



    if ($response->success) {
        // check username
        $result = mysqli_query($conn, "SELECT * FROM users WHERE name = '$name'");
        //jika ada usernya

        if (mysqli_num_rows($result) == 1) {
            $hasil = mysqli_fetch_assoc($result);

            if (password_verify($password, $hasil['password'])) {
                // set sesion
                $_SESSION['login']      = true;
                $_SESSION['id_users']   = $hasil['id_users'];
                $_SESSION['name']       = $hasil['name'];
                $_SESSION['email']      = $hasil['email'];
                $_SESSION['password']   = $hasil['password'];
                $_SESSION['status']     = $hasil['status'];
                $_SESSION['created_at'] = $hasil['created_at'];

                // jika login benar arahkan ke file indx.php
                header("Location: index.php");
                exit;
            } else {
                // jika username9
                $error = true;
            }
        }
    } else {
        // jika tidak ada usernya login slah
        $errorRecaptcha = true;
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>ADMIN LOGIN</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">


    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Favicons -->
    <link rel="icon" href="assets/img/bootstrap-logo.svg">
    <meta name="theme-color" content="#7952b3">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="assets/css/signin.css" rel="stylesheet">
</head>

<body class="text-center">

    <main class="form-signin">
        <form action="" method="POST">
            <img class="mb-4" src="assets/img/bootstrap-logo.svg" alt="" width="72" height="57">
            <h1 class="h3 mb-3 fw-normal">ADMIN LOGIN</h1>

            <?php if (isset($error)) : ?>
                <div class="alert alert-danger text-center">
                    <b>Userame/password salah yaa</b>
                </div>
            <?php endif; ?>

            <?php if (isset($errorRecaptcha)) : ?>
                <div class="alert alert-danger text-center">
                    <b>recaptcha tidak valid</b>
                </div>
            <?php endif; ?>

            <div class="form-floating">
                <input type="text" name="name" class="form-control" id="floatingInput" placeholder="name" required>
                <label for="floatingInput">NAME</label>
            </div>
            <div class="form-floating">
                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                <label for="floatingPassword">PASSWORD</label>
            </div>

            <div class="mb-3">
                <div class="g-recaptcha" data-sitekey="6LfiY0wtAAAAAIA6GWIuyaJz4Xdfv1xn0Gpgh5ZV"></div>
            </div>

            <button class="w-100 btn btn-lg btn-primary" type="submit" name="login">loginkan</button>
            <p class="mt-5 mb-3 text-muted">COPTRIGHT&copy; RAFIF GANTENG <?= date('Y') ?></p>
        </form>
    </main>

    <script src="https://www.google.com/recaptcha/api.js"></script>

</body>

</html>