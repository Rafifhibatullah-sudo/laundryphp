<?php

include 'config/database.php';
include 'config/function.php';

$products = select("SELECT * FROM products");
if (isset($_POST['submit'])) {
    $createAction = createOrder($_POST);
    
    if ($createAction > -1) {
        // 1. Tentukan nomor WhatsApp admin (Gunakan kode negara, misal 62 untuk Indonesia)
        $nomorAdmin = "6282186993746"; // <-- Ganti dengan nomor WhatsApp kamu
        
        // 2. Ambil data dari form untuk dimasukkan ke dalam teks WA (Opsional, agar lebih detail)
        $namaPelanggan = isset($_POST['name']) ? $_POST['name'] : '';
        $alamatPelanggan = isset($_POST['address']) ? $_POST['address'] : '';
        
        // 3. Susun teks pesan WhatsApp
        $textPesan = "*Halo Admin LaundryPHP rafif!*%0A%0A" . 
                     "Saya sudah melakukan pemesanan lewat form di website dan ingin mengonfirmasi agar segera diproses oleh admin.%0A%0A" .
                     "• *Nama:* " . rawurlencode($namaPelanggan) . "%0A" .
                     "• *Alamat:* " . rawurlencode($alamatPelanggan) . "%0A%0A" .
                     "_Mohon bantuannya. Terima kasih!_";
        
        // 4. Gabungkan menjadi link WhatsApp API
        $linkWhatsApp = "https://api.whatsapp.com/send?phone=" . $nomorAdmin . "&text=" . $textPesan;
        
        echo "
            <script>
                alert('Pesanan berhasil dibuat! Klik OK untuk konfirmasi otomatis via WhatsApp.');
                window.open('" . $linkWhatsApp . "', '_blank'); // Membuka WA di tab baru
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Pesanan gagal dibuat');
                document.location.href = '';
            </script>
        ";
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaundryPHP Rafif - Jasa Laundry Profesional & Cepat</title>
    <meta name="description" content="LaundryPHP Rafif menawarkan jasa cuci setrika kilat, bersih, dan wangi dengan harga terjangkau. Pesan online sekarang lewat WhatsApp!">
    <meta name="keywords" content="laundry rafif, laundryphp, jasa laundry terdekat, cuci setrika, laundry kilat">
    <meta name="author" content="LaundryPHP Rafif">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top shadow">
            <div class="container">
                <a class="navbar-brand fw-bold" href="#">
                    <i class="bi bi-water me-2"></i>LaundryPHP Rafif
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto fw-semibold">
                        <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#katalog">Katalog Paket</a></li>
                        <li class="nav-item"><a class="nav-link" href="#order">Form Order</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact">Kontak</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <section id="home" class="jumbotron text-center text-md-start">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6" data-aos="fade-right">
                        <h1 class="display-4 fw-bold mb-3">Pakaian Bersih, Rapi & Wangi Tanpa Ribet!</h1>
                        <p class="lead mb-4">Serahkan cucian kotor Anda kepada LaundryPHP Rafif. Kami siap melayani dengan sepenuh hati, cepat, dan higienis.</p>
                        <a href="#order" class="btn btn-light btn-lg text-primary fw-bold px-4 py-2 shadow-sm">Pesan Sekarang <i class="bi bi-arrow-right"></i></a>
                    </div>
                    <div class="col-md-6 text-center d-none d-md-block" data-aos="fade-left">
                        <img src="https://images.unsplash.com/photo-1517677208171-0bc6725a3e60?auto=format&fit=crop&w=500&q=80" alt="Layanan LaundryPHP Rafif" class="img-fluid rounded-circle border border-4 border-white shadow">
                    </div>
                </div>
            </div>
        </section>

        <section id="katalog" class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5" data-aos="fade-up">
                    <h2 class="fw-bold">Katalog Paket Laundry</h2>
                    <p class="text-muted">Pilih paket laundry terbaik sesuai kebutuhan Anda</p>
                    <hr class="mx-auto bg-primary" style="width: 60px; height: 3px;">
                </div>


                <div class="row g-4">
                    <?php foreach ($products as $product) : ?>
                        <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
                            <div class="card h-100 card-paket shadow-sm text-center">
                                <div class="card-body p-4">
                                    <div class="fs-1 text-primary mb-3"><i class="bi bi-wind"></i></div>
                                    <h3 class="card-title h4 fw-bold"><?= $product['name']; ?></h3>
                                    <p class="card-text text-muted">Hanya dicuci dan dikeringkan (belum disetrika).</p>
                                    <h4 class="text-primary fw-bold mb-4">Rp. <?= number_format($product['price'], 0, ',', '.'); ?></h4>
                                    <button class="btn btn-outline-primary w-100 btn-pilih-paket" data-paket="<?= $product['id_products']; ?>">Pilih Paket</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section id="order" class="py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8" data-aos="fade-up">
                        <div class="card border-0 shadow p-4 p-md-5">
                            <div class="text-center mb-4">
                                <h2 class="fw-bold">Form Order Laundry</h2>
                                <p class="text-muted">Isi data di bawah ini untuk konfirmasi otomatis ke WhatsApp kami</p>
                            </div>
                            <!-- <form id="laundryForm"> -->
                            <form action="" method="POST">

                                <div class="mb-3">
                                    <label for="nama" class="form-label fw-bold">Nama Lengkap</label>
                                    <input type="text" name="name" class="form-control" id="nama" placeholder="Masukkan nama Anda" required>
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label fw-bold">address Penjemputan</label>
                                    <textarea name="address" class="form-control" id="address" rows="3" placeholder="Masukkan address lengkap penjemputan" required></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="pilihanPaket" class="form-label fw-bold">Pilih Paket</label>
                                        <select name="product_id" class="form-select" id="pilihanPaket" required>

                                            <option value="" disabled selected>-- Pilih Paket --</option>
                                            <?php foreach ($products as $product) : ?>
                                                <option value="<?= $product['id_products']; ?>">
                                                    <?= $product['title']; ?>
                                                    (Rp <?= number_format($product['price'], 0, ',', '.'); ?>/kg)

                                                </option>
                                            <?php endforeach; ?>

                                        </select>
                                    </div>

                                    <div class="col-6">
                                        <label for="qty" class="form-label small fw-bold text-secondary">Jumlah (pcs)</label>

                                        <input type="number" name="qty" class="form-control rounded-3 p-3 border-0 shadow-sm" id="qty" placeholder="Contoh: 2" min="1" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="estimasi" class="form-label fw-bold">Estimasi Berat (Kg)</label>
                                        <input type="number" class="form-control" id="estimasi" placeholder="Contoh: 5" min="1" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="phone" class="form-label fw-bold">phone Lengkap</label>
                                        <input type="tel" name="phone" class="form-control" id="phone" placeholder="Masukkan phone Anda" required>
                                    </div>
                                </div>
                                <button type="submit" name="submit" class="btn btn-success w-100 btn-lg mt-3 fw-bold shadow-sm">
                                    <!-- <i class="bi bi-whatsapp me-2"></i> -->Kirim Orderan Via WhatsApp
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="contact" class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5" data-aos="fade-up">
                    <h2 class="fw-bold">Hubungi Kami</h2>
                    <p class="text-muted">Kirimkan pertanyaan atau saran Anda kepada kami</p>
                    <hr class="mx-auto bg-primary" style="width: 60px; height: 3px;">
                </div>
                <div class="row g-4">
                    <div class="col-md-6" data-aos="fade-right">
                        <div class="bg-white p-4 rounded shadow-sm h-100">
                            <h3 class="h5 fw-bold mb-4">Hubungi Via Pesan</h3>
                            <form id="contactForm">
                                <div class="mb-3">
                                    <input type="text" class="form-control" placeholder="Nama" required id="contactName">
                                </div>
                                <div class="mb-3">
                                    <input type="email" class="form-control" placeholder="Email" required id="contactEmail">
                                </div>
                                <div class="mb-3">
                                    <textarea class="form-control" rows="4" placeholder="Pesan Anda" required id="contactMessage"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Kirim Pesan</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6" data-aos="fade-left">
                        <div class="bg-white p-4 rounded shadow-sm h-100 d-flex flex-column justify-content-between">
                            <div>
                                <h3 class="h5 fw-bold mb-3">Lokasi Kami</h3>
                                <div class="ratio ratio-16x9 mb-3 rounded overflow-hidden shadow-sm">
                                   <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.7392016651825!2d103.85423697437291!3d-2.89135443948576!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e3a8dad54afd5d3%3A0x7b7ecdb87d3560d7!2sRSUD%20Sekayu!5e0!3m2!1sid!2sid!4v1784003431961!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
                                </div>
                            </div>
                            <div>
                                <h4 class="h6 fw-bold mb-2">Sosial Media</h4>
                                <div class="d-flex gap-3">
                                    <a href="#" class="text-dark social-icon" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                                    <a href="#" class="text-dark social-icon" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                                    <a href="#" class="text-dark social-icon" aria-label="Twitter"><i class="bi bi-twitter-x"></i></a>
                                    <a href="#" class="text-dark social-icon" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-dark text-white py-4 mt-auto">
        <div class="container text-center">
            <p class="mb-2">&copy; <span id="year"></span> LaundryPHP Rafif. All Rights Reserved.</p>
            <small class="text-muted">Didesain dengan <i class="bi bi-heart-fill text-danger"></i> untuk kenyamanan pakaian Anda.</small>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        // Inisialisasi AOS (Animate on Scroll)
        AOS.init({
            duration: 800,
            once: true
        });

        // Set Tahun Dinamis untuk Footer Copyright
        $('#year').text(new Date().getFullYear());

        $(document).ready(function() {
            // Interaksi Menghubungkan Tombol Katalog ke Form Order
            $('.btn-pilih-paket').on('click', function() {
                let paketDipilih = $(this).attr('data-paket');
                $('#pilihanPaket').val(paketDipilih);

                // Animasi Scroll Halus ke Form Order menggunakan jQuery
                $('html, body').animate({
                    scrollTop: $("#order").offset().top - 80
                }, 600);
            });

            // Handler Form Order dan Redirect ke WhatsApp
            $('#laundryForm').on('submit', function(e) {
                e.preventDefault();

                // Ambil Nilai Input
                let nama = $('#nama').val();
                let alamat = $('#alamat').val();
                let paket = $('#pilihanPaket').val();
                let berat = $('#estimasi').val();

                // No WhatsApp Anda (Ganti dengan nomor WhatsApp kamu, pakai format 62 di depan)
                let noWhatsapp = "6282186993746";

                // Format Pesan WhatsApp
                let teksPesan = `Halo LaundryPHP Rafif, saya ingin mengorder jasa laundry:%0A%0A` +
                    `*Nama:* ${nama}%0A` +
                    `*Alamat Jemput:* ${alamat}%0A` +
                    `*Pilihan Paket:* ${paket}%0A` +
                    `*Estimasi Berat:* ${berat} Kg%0A%0A` +
                    `Mohon segera dikonfirmasi ya, terima kasih!`;

                // Efek animasi tombol sebelum dikirim
                let btn = $(this).find('button[type="submit"]');
                btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mengalihkan...');
                btn.prop('disabled', true);

                setTimeout(function() {
                    window.open(`https://api.whatsapp.com/send?phone=${noWhatsapp}&text=${teksPesan}`, '_blank');
                    // Reset Button
                    btn.html('<i class="bi bi-whatsapp me-2"></i>Kirim Orderan Via WhatsApp');
                    btn.prop('disabled', false);
                }, 1000);
            });

            // Handler Form Kontak (Simple Alert Demo)
            $('#contactForm').on('submit', function(e) {
                e.preventDefault();
                let name = $('#contactName').val();
                alert(`Terima kasih ${name}, pesan Anda berhasil dikirim! (Ini adalah demo simulasi)`);
                $('#contactForm')[0].reset();
            });
        });
    </script>
</body>

</html>