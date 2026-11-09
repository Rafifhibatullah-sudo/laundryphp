            <?php

            session_start();

            //  membatasi halaman sebelum login
            if (!isset($_SESSION["login"])) {
                echo "<script>
                        alert('login dulu kalau mau masuk');
                        document.location.href = 'login.php';
                      </script>";
                exit;
            }


            $title = "Orders"; // variable title untuk judul halaman
            require_once 'layout/header.php';

            $products = select("SELECT * FROM products WHERE status = '1' ORDER BY created_at DESC");

            //JOIN = menghubungkan
            // UBAH BARIS KODE INI:
            $orders = select("SELECT orders.*, products.title AS nama_produk FROM products JOIN orders ON products.id_products = orders.product_id ORDER BY orders.created_at DESC");

            ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"> Orders </h1>
                </div>

                <a href="orders-create.php" class="btn btn-primary btn-sm mb-2">Add Order</a>

                <button class="btn btn-info btn-sm mb-2 text-white" data-bs-toggle="modal"
                    data-bs-target="#downloadModal">Download</button>

                <div class="table-responsive small">
                    <table class="table table-striped table-bordered table-sm" id="ordersTable">
                        <thead>
                            <tr>
                                <th scope="col" width="1%">No</th>
                                <th scope="col">Name</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Qty / Total</th>
                                <th scope="col" width="1%">Payment</th>
                                <th scope="col">Address</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($orders as $index => $order) : ?>

                                <tr>
                                    <td class="text-center"><?= $index + 1; ?></td>
                                    <td><?= $order['name']; ?></td>
                                    <td><?= $order['phone']; ?></td>
                                    <td>
                                        <?= $order['qty']; ?>x / Rp. <?= number_format((float)($order['total'] ?? 0), 0, ',', '.'); ?>
                                    </td>
                                    <td><?= $order['payment_method']; ?></td>
                                    <td><?= $order['address']; ?></td>
                                    <td><?= date('d-m-Y H:i:s', strtotime($order['created_at'])); ?></td>
                                    <td class="text-center">
                                        <a href="orders-detail.php?id_orders=<?= $order['id_orders']; ?>"
                                            class="btn btn-sm btn-secondary mb-2">Detail</a>

                                        <a href="orders-edit.php?id_orders=<?= $order['id_orders']; ?>"
                                            class="btn btn-sm btn-success mb-2">Edit</a>

                                        <a href="orders-delete.php?id_orders=<?= $order['id_orders']; ?>"
                                            class="btn btn-sm btn-danger mb-2"
                                            onclick="return confirm('Are You Sure?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="downloadModal" data-bs-backdrop=" static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-info">
                                <h1 class="modal-title fs-5 text-white" id="staticBackdropLabel">Download Orders</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="orders-dowload.php" method="post" id="form-download">
                                    <div class="mb-3">
                                        <label for="start_date" class="form-label">Start Date</table>
                                            <input type="date" name="start_date" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="start_date" class="form-label">End Date</table>
                                            <input type="date" name="end_date" class="form-control" required>
                                    </div>
                                </form>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" name="download" form="form-download"
                                        class="btn btn-info text-white">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>

            </main>

            <script>
                $(document).ready(function() {
                    $('#ordersTable').DataTable();
                })
            </script>

            <?php require_once 'layout/footer.php'; ?>
            