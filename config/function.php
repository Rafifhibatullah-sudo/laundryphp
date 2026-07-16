<?php 

//fungsi select untuk mengnambil data dengan query
function select(string $query)
{
    global $conn;

    $result = mysqli_query($conn, $query);
    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

function countTotal(array $data)
{
    $getProduct = select("SELECT * FROM products WHERE id_products = $data[product_id]")[0];

    $total = $getProduct['price'] * $data['qty'];

    return $total;

}

function createOrder(array $data)
{
    global $conn;

    //ambil data dari form
    $product_id     = strip_tags($data['product_id']);
    $name           = strip_tags($data['name']);
    $phone          = strip_tags($data['phone']);
    $qty            = strip_tags($data['qty']);
    $address        = strip_tags($data['address']);

   $total = countTotal($data);

    $query = "INSERT INTO orders (product_id, name, phone, qty, address, total) VALUES ('$product_id', '$name', '$phone', '$qty', '$address',  $total)";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn); //mengecheck apakah ada baris terpengaruh
}
