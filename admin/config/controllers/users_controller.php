<?php

require_once 'config/function.php';

function createUser(array $data)
{
    global $conn;

    $name = strip_tags($data['name']);
    $email = strip_tags($data['email']);
    $password = strip_tags($data['password']);
    $status = strip_tags($data['status']);

    // enskripsi password  
    $password = password_hash($password, PASSWORD_DEFAULT);
    

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = uploadUser();

          $query = "INSERT INTO users (name, email, password, status, image ) VALUES ('$name', '$email', '$password', '$status', '$image')";
       
        } else {
 
               $query = "INSERT INTO users (name, email, password, status ) VALUES ('$name', '$email', '$password', '$status')";
    }


    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


function updateUser(array $data, int $id_users) // fungsi untuk megubah data 
{
    global $conn;

    $name = strip_tags($data['name']);
    $email = strip_tags($data['email']);
    $password = strip_tags($data['password']);
    $status = strip_tags($data['status']);
     $oldImage  = strip_tags($data['oldImage']);

      if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = uploadUser();
     } else {
        $image = $oldImage;
     }

      
    $query = "UPDATE users SET name = '$name', email = '$email', status = '$status',  image = '$image', password = '$password' WHERE id_users = $id_users";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function deleteUser(int $id_users)
{
    global $conn;

 $getImage = select("SELECT image FROM users WHERE id_users = $id_users")[0];

  if ($getImage['image'] != null) {
        unlink('assets/img/akun/' . $getImage['image']);
    }

    $query = "DELETE FROM users WHERE id_users = $id_users";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function uploadUser()
{
    $namaFile   = $_FILES['image']['name'];
    $ukuranFile = $_FILES['image']['size'];
    $error      = $_FILES['image']['error'];
    $tmpName    = $_FILES['image']['tmp_name'];

    // check file yang diupload
    $extensifileValid = ['jpg', 'jpeg', 'png'];
    $extensifile      = explode('.', $namaFile);
    $extensifile      = strtolower(end($extensifile));

    // check format/extensi file
    if (!in_array($extensifile, $extensifileValid)) {
        // pesan gagal
        echo "<script>
                alert('Format File Tidak Valid');
                document.location.href = 'users-create.php';
              </script>";
        die();
    }

    // check ukuran file 2 MB
    if ($ukuranFile > 2048000) {
        // pesan gagal
        echo "<script>
                alert('Ukuran File Max 2 MB');
                document.location.href = 'users-create.php';
              </script>";
        die();
    }

    // generate nama file baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $extensifile;

    // pindahkan ke folder local
    move_uploaded_file($tmpName, 'assets/img/akun/' . $namaFileBaru);
    return $namaFileBaru;
}

