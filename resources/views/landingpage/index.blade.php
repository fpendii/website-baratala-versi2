<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mitra Pertambangan Premium - [Nama Perusahaan]</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* Palet Warna: Hitam (#212529), Abu Gelap (#343a40), Emas Aksen (#FFC107) */

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        .cta-button {
            background-color: #ffc107; /* Emas Aksen */
            color: #212529; /* Hitam */
            font-weight: 700;
            padding: 15px 50px;
            border-radius: 50px; /* Bentuk Pill */
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.4);
        }
        .cta-button:hover {
            background-color: #e0a800;
            color: #212529;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 193, 7, 0.6);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: #ffc107; /* Emas Aksen */
            margin-bottom: 1rem;
        }

        .service-card {
            border-left: 4px solid transparent;
            transition: border-color 0.3s, transform 0.3s;
            background-color: white;
            min-height: 220px; /* Menjaga tinggi agar konsisten */
        }
        .service-card:hover {
            border-left: 4px solid #ffc107;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        }

        .footer-custom {
            background-color: #212529; /* Hitam Khas Industri */
        }

        /* Style untuk Carousel */
        .carousel-caption {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 15%; /* Memberi ruang di samping */
            text-align: center;
        }
        .text-shadow {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark position-absolute top-0 start-0 w-100 p-3" style="z-index: 1050;">
        <div class="container">
            <a class="navbar-brand fw-bold text-uppercase" href="#"> <img src="{{asset('image/logo.png')}}" style="width: 50px" alt="Baratala Logo"> BARATALA TUNTUNG PANDANG</a>
            <a href="#kontak" class="btn btn-warning btn fw-bold">Masuk</a>
        </div>
    </nav>

    <section id="hero-slider" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#hero-slider" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#hero-slider" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#hero-slider" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>

        <div class="carousel-inner" style="height: 90vh;">

            <div class="carousel-item active" data-bs-interval="5000">
                <div class="d-block w-100" style="background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.7)), url('{{ asset('image/mining-slide-1.jpg') }}'); background-size: cover; background-position: center; height: 90vh;">
                </div>
                <div class="carousel-caption">
                    <div class="col-lg-12">
                        <h1 class="display-1 fw-bolder mb-3 text-shadow">
                            EKSELENSI PERTAMBANGAN <span class="text-warning">BERKELANJUTAN</span>
                        </h1>
                        <p class="lead mb-5 fs-4">
                            Mitra strategis Anda dalam memastikan eksplorasi, produksi, dan kepatuhan standar K3/ESG global.
                        </p>
                        <a href="#kontak" class="cta-button text-decoration-none">
                            Dapatkan Konsultasi Strategis
                        </a>
                    </div>
                </div>
            </div>

            <div class="carousel-item" data-bs-interval="5000">
                <div class="d-block w-100" style="background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.7)), url('{{ asset('image/mining-slide-2.jpg') }}'); background-size: cover; background-position: center; height: 90vh;">
                </div>
                 <div class="carousel-caption">
                    <div class="col-lg-12">
                        <h1 class="display-1 fw-bolder mb-3 text-shadow">
                            OPTIMALKAN <span class="text-warning">HASIL</span> PRODUKSI
                        </h1>
                        <p class="lead mb-5 fs-4">
                            Pengelolaan operasional dengan teknologi mutakhir untuk efisiensi waktu dan volume.
                        </p>
                        <a href="#layanan" class="cta-button text-decoration-none">
                            Jelajahi Solusi Kami
                        </a>
                    </div>
                </div>
            </div>

            <div class="carousel-item" data-bs-interval="5000">
                <div class="d-block w-100" style="background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.7)), url('{{ asset('image/mining-slide-3.jpg') }}'); background-size: cover; background-position: center; height: 90vh;">
                </div>
                <div class="carousel-caption">
                    <div class="col-lg-12">
                        <h1 class="display-1 fw-bolder mb-3 text-shadow">
                            PRIORITAS <span class="text-warning">K3</span> DAN LINGKUNGAN
                        </h1>
                        <p class="lead mb-5 fs-4">
                            Kepatuhan tanpa kompromi terhadap standar HSE dan ESG global.
                        </p>
                        <a href="#keunggulan" class="cta-button text-decoration-none">
                            Lihat Komitmen Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#hero-slider" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#hero-slider" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </section>

    <section class="py-4 bg-dark text-white border-bottom border-warning border-3">
        <div class="container text-center">
            <p class="text-secondary mb-3 small text-uppercase fw-bold">Bersertifikasi dan Diakui</p>
            <div class="d-flex justify-content-center align-items-center flex-wrap gap-4">
                <span class="badge bg-secondary text-light p-2 fw-normal">ISO 9001:2015</span>
                <span class="badge bg-success text-dark p-2 fw-normal">Proper Hijau</span>
                <img src="{{ asset('image/logo-client-1.svg') }}" alt="Client 1" style="height: 35px; opacity: 0.7; filter: invert(1);">
            </div>
        </div>
    </section>

    <section id="keunggulan" class="py-5 bg-white">
        <div class="container">
            <h2 class="text-center mb-5 fw-bold text-dark">Mengapa Kami Lebih Unggul?</h2>
            <div class="row text-center g-4">
                <div class="col-md-3">
                    <i class="bi bi-gear-wide-connected feature-icon"></i>
                    <h3 class="h5 fw-bold mb-2 text-dark">Inovasi Teknologi</h3>
                    <p class="text-secondary small">Adopsi AI dan *remote sensing* untuk akurasi cadangan mineral.</p>
                </div>
                <div class="col-md-3">
                    <i class="bi bi-shield-lock feature-icon"></i>
                    <h3 class="h5 fw-bold mb-2 text-dark">Standar K3 Internasional</h3>
                    <p class="text-secondary small">Zero accident rate dan kepatuhan HSE yang tanpa kompromi.</p>
                </div>
                <div class="col-md-3">
                    <i class="bi bi-tree feature-icon"></i>
                    <h3 class="h5 fw-bold mb-2 text-dark">Komitmen ESG</h3>
                    <p class="text-secondary small">Reklamasi lahan yang terukur dan program pengembangan masyarakat (CSR).</p>
                </div>
                <div class="col-md-3">
                    <i class="bi bi-currency-dollar feature-icon"></i>
                    <h3 class="h5 fw-bold mb-2 text-dark">Jaminan Hasil</h3>
                    <p class="text-secondary small">Efisiensi operasi yang memastikan *return on investment* (ROI) maksimal bagi mitra.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="layanan" class="py-5 bg-light border-top border-bottom">
        <div class="container">
            <h2 class="text-center mb-5 fw-bold text-dark">Portofolio Layanan Inti</h2>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card service-card p-3 h-100 shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-geo-alt-fill text-warning mb-3 d-block fs-4"></i>
                            <h4 class="card-title h5 fw-bold">Eksplorasi Geologi</h4>
                            <p class="card-text text-secondary small">Pengambilan data dan pemodelan 3D deposit mineral yang presisi.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card service-card p-3 h-100 shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-truck-flatbed text-warning mb-3 d-block fs-4"></i>
                            <h4 class="card-title h5 fw-bold">Operasi Penambangan</h4>
                            <p class="card-text text-secondary small">Manajemen rantai pasok dan produksi material curah secara efisien.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card service-card p-3 h-100 shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-ship-fill text-warning mb-3 d-block fs-4"></i>
                            <h4 class="card-title h5 fw-bold">Logistik & Distribusi</h4>
                            <p class="card-text text-secondary small">Jaminan pengiriman tepat waktu dari tambang ke pelabuhan dan konsumen akhir.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card service-card p-3 h-100 shadow-sm">
                        <div class="card-body">
                            <i class="bi bi-journal-check text-warning mb-3 d-block fs-4"></i>
                            <h4 class="card-title h5 fw-bold">Audit & Kepatuhan</h4>
                            <p class="card-text text-secondary small">Dukungan penuh dalam perizinan dan pemenuhan standar regulasi terbaru.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-white">
        <div class="container">
            <h2 class="text-center mb-5 fw-bold text-dark">Suara Klien Kami</h2>

            <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner mx-auto" style="max-width: 700px;">
                    <div class="carousel-item active text-center">
                        <blockquote class="blockquote fst-italic p-4 bg-light rounded shadow-sm">
                            <i class="bi bi-quote fs-2 text-warning"></i>
                            <p class="mb-0 fs-5">"Profesionalisme dan komitmen keselamatan tim [Nama Perusahaan] adalah yang terbaik. Proyek selesai tepat waktu, di bawah budget, dan tanpa insiden."</p>
                        </blockquote>
                        <figcaption class="blockquote-footer mt-3">
                            Bapak Antonius <cite title="Source Title">CEO, PT Maju Bersama Logistik</cite>
                        </figcaption>
                    </div>
                    <div class="carousel-item text-center">
                         <blockquote class="blockquote fst-italic p-4 bg-light rounded shadow-sm">
                            <i class="bi bi-quote fs-2 text-warning"></i>
                            <p class="mb-0 fs-5">"Pendekatan mereka terhadap reklamasi sangat inovatif. Kami bangga bermitra dengan perusahaan yang memprioritaskan lingkungan."</p>
                        </blockquote>
                        <figcaption class="blockquote-footer mt-3">
                            Ibu Rina <cite title="Source Title">Kepala Divisi Lingkungan, Sumber Daya Alam Tbk.</cite>
                        </figcaption>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark rounded-circle" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon bg-dark rounded-circle" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <div class="text-center mt-4">
                <a href="/studi-kasus" class="btn btn-outline-dark">Lihat Semua Studi Kasus</a>
            </div>
        </div>
    </section>

    <section id="kontak" class="py-5 bg-dark text-center">
        <div class="container">
            <h2 class="display-5 fw-bold text-warning mb-3">Tingkatkan Nilai Investasi Anda Sekarang</h2>
            <p class="lead text-white-50 mb-4">Mulai diskusi rahasia dengan tim ahli kami untuk analisis kelayakan proyek.</p>

            <a href="mailto:info@perusahaananda.com" class="cta-button bg-danger hover:bg-red-700 text-white text-decoration-none border border-light border-2 me-3">
                Hubungi Kami via Email
            </a>

            <button type="button" class="cta-button bg-info text-white text-decoration-none" data-bs-toggle="modal" data-bs-target="#contactModal">
                Minta Panggilan Balik
            </button>

            <p class="text-white-50 mt-3 small">Atau telepon: **+62 812 XXXX XXXX**</p>
        </div>
    </section>

    <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-warning">
            <h5 class="modal-title text-dark fw-bold" id="contactModalLabel">Formulir Permintaan Kemitraan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p class="small text-secondary">Kami akan menghubungi Anda dalam 1x24 jam kerja.</p>
            <form action="/submit-contact" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label small">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label small">Email Perusahaan</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="perusahaan" class="form-label small">Nama Perusahaan</label>
                    <input type="text" class="form-control" id="perusahaan" name="perusahaan" required>
                </div>
                 <div class="mb-3">
                    <label for="pesan" class="form-label small">Rincian Proyek Singkat</label>
                    <textarea class="form-control" id="pesan" name="pesan" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-warning w-100 fw-bold">Kirim Permintaan</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <footer class="footer-custom text-white-50 py-4">
        <div class="container text-center">
            <p class="mb-1 small">&copy; {{ date('Y') }} [Nama Perusahaan Anda] - Pertambangan & Eksplorasi.</p>
            <div class="small">
                <a href="/privacy" class="text-white-50 text-decoration-none mx-2">Kebijakan Privasi</a>
                |
                <a href="/terms" class="text-white-50 text-decoration-none mx-2">Syarat &amp; Ketentuan</a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
