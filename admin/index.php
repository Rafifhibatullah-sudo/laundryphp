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
            
            $title = 'Dashboard'; // variable title untuk judul halaman
            require_once 'layout/header.php';

            $orderCash = select("SELECT * FROM orders WHERE payment_method = 'cash'");
            $orderQris = select("SELECT * FROM orders WHERE payment_method = 'qris'");
            $orderBank = select("SELECT * FROM orders WHERE payment_method = 'bank'");
            $orderPending = select("SELECT * FROM orders WHERE payment_method = 'pending'");
            $orderTotal = select("SELECT * FROM orders");
            // $orderTotal = select("SELECT * FROM orders WHERE payment_method = 'total'");

            ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2"> <button type="button"
                                class="btn btn-sm btn-outline-secondary">Share</button> <button type="button"
                                class="btn btn-sm btn-outline-secondary">Export</button> </div> <button type="button"
                            class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-1">
                            <svg class="bi" aria-hidden="true">
                                <use xlink:href="#calendar3"></use>
                            </svg>
                            This week
                        </button>
                    </div>
                </div> <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>

                <hr>
                <h2>Orders Type</h2>

                <div class="row g-4">
                    <!-- Grid dengan gap yang proporsional -->

                    <!-- Card Cash -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card h-100 border-0 shadow-sm custom-card text-white position-relative overflow-hidden"
                            style="background: #1e293b; border-radius: 16px;">
                            <div
                                style="position: absolute; top: 0; left: 0; width: 100%; height: 4px; background: #3b82f6;">
                            </div>
                            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="text-uppercase tracking-wider fw-semibold mb-2"
                                        style="color: #94a3b8; font-size: 0.75rem; letter-spacing: 0.05em;">Payment Cash
                                    </h6>
                                    <h2 class="fw-bold mb-0" style="font-size: 2.25rem; color: #f8fafc;">
                                        <?= count($orderCash); ?></h2>
                                </div>
                                <div class="d-flex align-items-center justify-content-center rounded-4"
                                    style="width: 52px; height: 52px; background: rgba(59, 130, 246, 0.15); color: #3b82f6;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                        class="bi bi-cash-stack" viewBox="0 0 16 16">
                                        <path
                                            d="M1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1zm7 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4" />
                                        <path
                                            d="M0 5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V7a2 2 0 0 1-2-2z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card QRIS -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card h-100 border-0 shadow-sm custom-card text-white position-relative overflow-hidden"
                            style="background: #1e293b; border-radius: 16px;">
                            <div
                                style="position: absolute; top: 0; left: 0; width: 100%; height: 4px; background: #eab308;">
                            </div>
                            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="text-uppercase tracking-wider fw-semibold mb-2"
                                        style="color: #94a3b8; font-size: 0.75rem; letter-spacing: 0.05em;">Payment QRIS
                                    </h6>
                                    <h2 class="fw-bold mb-0" style="font-size: 2.25rem; color: #f8fafc;">
                                        <?= count($orderQris); ?></h2>
                                </div>
                                <div class="d-flex align-items-center justify-content-center rounded-4"
                                    style="width: 52px; height: 52px; background: rgba(234, 179, 8, 0.15); color: #eab308;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                        class="bi bi-qr-code-scan" viewBox="0 0 16 16">
                                        <path
                                            d="M0 .5A.5.5 0 0 1 .5 0h3a.5.5 0 0 1 0 1H1v2.5a.5.5 0 0 1-1 0zm12 0a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0V1h-2.5a.5.5 0 0 1-.5-.5M.5 12a.5.5 0 0 1 .5.5V15h2.5a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5v-3a.5.5 0 0 1 .5-.5zm15 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1H15v-2.5a.5.5 0 0 1 .5-.5M4 4h1v1H4zm2 2h2v1H6zm1-2h1v1H7z" />
                                        <path
                                            d="M2 2v2h2V2zm3 0v3H2V2zM2 7v2h2V7zm3 0v3H2V7zm10-5v2h2V2zm3 0v3h-3V2zm-3 5v2h2V7zm3 0v3h-3V7zM7 10h1v1H7zm1 1h1v1H8zm-1 1h1v1H7zm3-2h1v1h-1zm1 1h1v1h-1zm-1 1h1v1h-1zm3-2h1v1h-1zm1 1h1v1h-1zm-1 1h1v1h-1z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Bank -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card h-100 border-0 shadow-sm custom-card text-white position-relative overflow-hidden"
                            style="background: #1e293b; border-radius: 16px;">
                            <div
                                style="position: absolute; top: 0; left: 0; width: 100%; height: 4px; background: #10b981;">
                            </div>
                            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="text-uppercase tracking-wider fw-semibold mb-2"
                                        style="color: #94a3b8; font-size: 0.75rem; letter-spacing: 0.05em;">Payment Bank
                                    </h6>
                                    <h2 class="fw-bold mb-0" style="font-size: 2.25rem; color: #f8fafc;">
                                        <?= count($orderBank); ?></h2>
                                </div>
                                <div class="d-flex align-items-center justify-content-center rounded-4"
                                    style="width: 52px; height: 52px; background: rgba(16, 185, 129, 0.15); color: #10b981;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                        class="bi bi-bank" viewBox="0 0 16 16">
                                        <path
                                            d="m8 1.2 6.6 2.7A1.5 1.5 0 0 1 16 5.3V7a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V5.3a1.5 1.5 0 0 1 .8-1.4zM1.5 7h13v1h-13zM2 9h1v3H2zM5 9h1v3H5zM8 9h1v3H8zm3 9h1v3h-1zm3 0h1v3h-1zM.5 13a.5.5 0 0 1 .5-.5h14a.5.5 0 0 1 0 1H1a.5.5 0 0 1-.5-.5" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Pending -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card h-100 border-0 shadow-sm custom-card text-white position-relative overflow-hidden"
                            style="background: #1e293b; border-radius: 16px;">
                            <div
                                style="position: absolute; top: 0; left: 0; width: 100%; height: 4px; background: #f43f5e;">
                            </div>
                            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="text-uppercase tracking-wider fw-semibold mb-2"
                                        style="color: #94a3b8; font-size: 0.75rem; letter-spacing: 0.05em;">Pending</h6>
                                    <h2 class="fw-bold mb-0" style="font-size: 2.25rem; color: #f8fafc;">
                                        <?= count($orderPending); ?></h2>
                                </div>
                                <div class="d-flex align-items-center justify-content-center rounded-4"
                                    style="width: 52px; height: 52px; background: rgba(244, 63, 94, 0.15); color: #f43f5e;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                        class="bi bi-hourglass-split" viewBox="0 0 16 16">
                                        <path
                                            d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1zm2-13v1c0 1.661 1.07 3 2.5 3s2.5-1.339 2.5-3V2zm5 11c0-1.661-1.07-3-2.5-3s-2.5 1.339-2.5 3v1h5z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Total -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card h-100 border-0 shadow-sm custom-card text-white position-relative overflow-hidden"
                            style="background: #1e293b; border-radius: 16px;">
                            <div
                                style="position: absolute; top: 0; left: 0; width: 100%; height: 4px; background: #64748b;">
                            </div>
                            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                                <div>
                                    <h6 class="text-uppercase tracking-wider fw-semibold mb-2"
                                        style="color: #94a3b8; font-size: 0.75rem; letter-spacing: 0.05em;">Total Orders
                                    </h6>
                                    <h2 class="fw-bold mb-0" style="font-size: 2.25rem; color: #f8fafc;">
                                        <?= count($orderTotal); ?></h2>
                                </div>
                                <div class="d-flex align-items-center justify-content-center rounded-4"
                                    style="width: 52px; height: 52px; background: rgba(100, 116, 139, 0.2); color: #94a3b8;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                        class="bi bi-cart-check-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm-1.646-7.646-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708.708" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </main>

            <?php require_once 'layout/footer.php'; ?>