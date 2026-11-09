<?php




function countTotal(array $data)
{
    $getProduct = select("SELECT * FROM products WHERE id_products = $data[product_id]")[0];

    $total = $getProduct['price'] * $data['qty'];

    return $total;
}

function createOrder(array $data)
{
    global $conn;

    // Ambil data dari form
    $name           = strip_tags($data['name']);
    $product_id     = strip_tags($data['product_id']);
    $phone          = strip_tags($data['phone']);
    $address        = strip_tags($data['address']);
    $payment_method = strip_tags($data['payment_method']);
    $is_pay         = strip_tags($data['is_pay']);
    $qty            = strip_tags($data['qty']);

    $total = countTotal($data);

    // KODE YANG SUDAH DIPERBAIKI (Urutan kolom & VALUES sudah disamakan):
    $query = "INSERT INTO orders (product_id, name, phone, address, payment_method, is_pay, qty, total) VALUES ('$product_id', '$name', '$phone', '$address', '$payment_method', '$is_pay', '$qty', '$total')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn); 
}
function deleteOrder(int $id_orders)
{
    global $conn;

    $query = "DELETE FROM orders WHERE id_orders = $id_orders";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}



function updateOrder(array $data, int $id_orders)
{
    global $conn;

    //ambil data dari form
    $name     = strip_tags($data['name']);
    $phone     = strip_tags($data['phone']);
    $address            = strip_tags($data['address']);
    $product_id     = strip_tags($data['product_id']);
    $payment_method = strip_tags($data['payment_method']);
    $is_pay         = strip_tags($data['is_pay']);
    $qty            = strip_tags($data['qty']);


    $total = countTotal($data);

    $query = "UPDATE orders SET name = '$name', phone = '$phone', address = '$address', product_id = '$product_id', payment_method = '$payment_method', is_pay = '$is_pay',
    qty = '$qty',  total = '$total' WHERE id_orders = $id_orders";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn); //mengecheck apakah ada baris terpengaruh
}
