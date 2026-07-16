
<?php

require_once 'config/function.php';


function create(array $data)
{
    global $conn;

    $title = strip_tags($data['title']);
    $price = strip_tags($data['price']);
    $barcode = rand(1000, 9999);
    $status = strip_tags($data['status']);


    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = upload();

        $query = "INSERT INTO products (title, price, barcode, status, image) VALUES ('$title', '$price', '$barcode', '$status', '$image')";
    } else {

        $query = "INSERT INTO products (title, price, barcode, status) VALUES ('$title', '$price', '$barcode', '$status')";
    }
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function delete(int $id_products)
{
    global $conn;

    $getImage = select("SELECT image FROM products WHERE id_products = $id_products")[0];

    if ($getImage['image'] != null) {
        unlink('assets/img/' . $getImage['image']);
    }

    $query = "DELETE FROM products WHERE id_products = $id_products";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function update(array $data, int $id_products) // fungsi untuk megubah data 
{
    global $conn;

    $title = strip_tags($data['title']);
    $price = strip_tags($data['price']);
    $status = strip_tags($data['status']);
    $oldImage  = strip_tags($data['oldImage']);

    $updated_at = date('Y-m-d H:i:s');

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = upload();
    } else {
        $image = $oldImage;
    }

    $query = "UPDATE products SET title = '$title', price = '$price', status = '$status', image = '$image', updated_at = '$updated_at' WHERE id_products = $id_products";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function upload()
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
                document.location.href = 'products-create.php';
              </script>";
        die();
    }

    // check ukuran file 2 MB
    if ($ukuranFile > 2048000) {
        // pesan gagal
        echo "<script>
                alert('Ukuran File Max 2 MB');
                document.location.href = 'products-create.php';
              </script>";
        die();
    }

    // generate nama file baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $extensifile;

    // pindahkan ke folder local
    move_uploaded_file($tmpName, 'assets/img/' . $namaFileBaru);
    return $namaFileBaru;
}
