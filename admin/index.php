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


$title = "Dashboard";
require_once 'layout/header.php';

$orderCash = select("SELECT * FROM orders WHERE payment_method = 'cash'");
$orderBank = select("SELECT * FROM orders WHERE payment_method = 'bank'");
$orderQris = select("SELECT * FROM orders WHERE payment_method = 'qris'");
$orderPending = select("SELECT * FROM orders WHERE payment_method = 'pending'");
$ordertotal = select("SELECT * FROM orders");


?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-4 border-bottom">
        <h1 class="h3 font-weight-bold text-gradient" style="font-weight: 700; letter-spacing: -0.5px;"><?= $title; ?></h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2"> 
                <button type="button" class="btn btn-sm btn-outline-secondary border-0 bg-light-subtle rounded-3 me-1"><i class="bi bi-share me-1"></i> Share</button> 
                <button type="button" class="btn btn-sm btn-outline-secondary border-0 bg-light-subtle rounded-3"><i class="bi bi-download me-1"></i> Export</button> 
            </div> 
            <button type="button" class="btn btn-sm btn-light border dropdown-toggle d-flex align-items-center gap-2 rounded-3 shadow-sm px-3"> 
                <i class="bi bi-calendar3"></i>
                This week
            </button>
        </div>
    </div> 

    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-body p-4">
            <canvas class="w-100" id="myChart" width="900" height="320"></canvas>
        </div>
    </div>

    <div class="d-flex align-items-center my-4">
        <h4 class="m-0" style="font-weight: 600; color: #2b303a; letter-spacing: -0.3px;">Order Types</h4>
        <div class="flex-grow-1 ms-3 border-top opacity-25"></div>
    </div>

    <div class="mb-5">
        <div class="row g-4">

            <div class="col-12 col-sm-6 col-xl-2-5 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 position-relative overflow-hidden transition-card" style="background: rgba(13, 110, 253, 0.04); border-left: 4px solid #0d6efd !important;">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="text-uppercase fw-bold text-muted small tracking-wider" style="font-size: 0.75rem;">Payment Cash</span>
                            <div class="p-2 bg-primary bg-opacity-10 rounded-3 text-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cash-stack" viewBox="0 0 16 16"><path d="M14 3H1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h13a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zM1 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h13a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H1z"/><path d="M2 5a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1H2zm14 8H3v1h13v-1z"/></svg>
                            </div>
                        </div>
                        <h2 class="display-5 fw-bold m-0 text-dark"><?= count($orderCash); ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-2-5 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 position-relative overflow-hidden transition-card" style="background: rgba(220, 53, 69, 0.04); border-left: 4px solid #dc3545 !important;">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="text-uppercase fw-bold text-muted small tracking-wider" style="font-size: 0.75rem;">Payment Bank</span>
                            <div class="p-2 bg-danger bg-opacity-10 rounded-3 text-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-bank" viewBox="0 0 16 16"><path d="m8 1.2 6.6 2.7H1.4L8 1.2zm7.5 4.3v.4H.5v-.4h15zM3 7h1v5H3V7zm3 0h1v5H6V7zm3 0h1v5H9V7zm3 0h1v5h-1V7zM.5 13.5h15v1H.5v-1z"/></svg>
                            </div>
                        </div>
                        <h2 class="display-5 fw-bold m-0 text-dark"><?= count($orderBank); ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-2-5 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 position-relative overflow-hidden transition-card" style="background: rgba(25, 135, 84, 0.04); border-left: 4px solid #198754 !important;">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="text-uppercase fw-bold text-muted small tracking-wider" style="font-size: 0.75rem;">Payment QRIS</span>
                            <div class="p-2 bg-success bg-opacity-10 rounded-3 text-success">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-qr-code-scan" viewBox="0 0 16 16"><path d="M0 .5A.5.5 0 0 1 .5 0h3a.5.5 0 0 1 0 1H1v2.5a.5.5 0 0 1-1 0v-3Zm12 0a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0V1h-2.5a.5.5 0 0 1-.5-.5ZM.5 12a.5.5 0 0 1 .5.5V15h2.5a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5v-3a.5.5 0 0 1 .5-.5Zm15 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1H15v-2.5a.5.5 0 0 1 .5-.5ZM4 4h1v1H4V4Z"/><path d="M7 2H2v5h5V2ZM3 3h3v3H3V3Zm2 8H4v1h1v-1Z"/><path d="M7 9H2v5h5V9ZM3 10h3v3H3v-3Zm9-8h-5v5h5V2Zm-1 1v3h-3V3h3ZM9 9h1v1H9V9Zm2 2h1v1h-1v-1Zm-2 2h1v1H9v-1Zm2-2h1v1h-1v-1Zm1-2h1v1h-1V9Zm1 2h1v1h-1v-1Zm-1 2h1v1h-1v-1Zm2-2h1v1h-1v-1Z"/></svg>
                            </div>
                        </div>
                        <h2 class="display-5 fw-bold m-0 text-dark"><?= count($orderQris); ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-xl-2-5 col-lg-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 position-relative overflow-hidden transition-card" style="background: rgba(255, 193, 7, 0.05); border-left: 4px solid #ffc107 !important;">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="text-uppercase fw-bold text-muted small tracking-wider" style="font-size: 0.75rem;">Pending Orders</span>
                            <div class="p-2 bg-warning bg-opacity-10 rounded-3 text-warning">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16"><path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.117.343l-.351.932zm2.19 1.48a7.002 7.002 0 0 0-.715-.657l.542-.841c.328.21.637.452.926.721l-.653.777zM14 4.496a7.01 7.01 0 0 0-.425-.794l.807-.591c.2.274.376.568.528.877l-.91.308zM15 7a7.004 7.004 0 0 0-.083-.984l.985-.166c.06.353.098.711.114 1.073H15zm-.083 1.984c.055.352.094.708.114 1.07l-.997.047a7.013 7.013 0 0 0-.117-.985l1-.132zm-.715 2.873c.158.29.298.591.417.901l-.934.356a6.993 6.993 0 0 0-.376-.783l.893-.474zM12.19 13.92a7.013 7.013 0 0 0 .662-.513l.676.736c-.287.264-.598.502-.93.71l-.408-.933zm-2.004.836c.338.077.68.134 1.025.17l-.105.994a8.032 8.032 0 0 1-1.144-.19l.224-.974zM7.5 2a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 8V2.5a.5.5 0 0 1 .5-.5z"/></svg>
                            </div>
                        </div>
                        <h2 class="display-5 fw-bold m-0 text-dark"><?= count($orderPending); ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-12 col-xl-2-5 col-lg-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 position-relative overflow-hidden transition-card" style="background: rgba(108, 117, 125, 0.04); border-left: 4px solid #6c757d !important;">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="text-uppercase fw-bold text-muted small tracking-wider" style="font-size: 0.75rem;">Total Orders</span>
                            <div class="p-2 bg-secondary bg-opacity-10 rounded-3 text-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-seam" viewBox="0 0 16 16"><path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/></svg>
                            </div>
                        </div>
                        <h2 class="display-5 fw-bold m-0 text-dark"><?= count($ordertotal); ?></h2>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

<style>
    /* Mengubah grid agar pas di layar lebar (5 kolom sejajar) */
    @media (min-width: 1200px) {
        .col-xl-2-5 {
            flex: 0 0 auto;
            width: 20%;
        }
    }
    
    /* Efek hover dinamis ala dashboard premium */
    .transition-card {
        transition: all 0.25s ease-in-out;
    }
    .transition-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1.5rem rgba(0,0,0,.08) !important;
    }
    
    /* Pewarnaan font text-dark agar tidak terlalu kaku hitam pekat */
    .text-dark {
        color: #2d3748 !important;
    }
</style>

<?php require_once 'layout/footer.php'; ?>