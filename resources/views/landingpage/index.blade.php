<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Perusahaan | BARATALA TUNTUNG PANDANG</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* Gaya ELEGAN BARU */
        :root {
            --primary-color: #0d1a26;
            /* Hitam Angkatan Laut */
            --secondary-color: #343a40;
            /* Abu-abu Gelap */
            --accent-color: #ffc107;
            /* Kuning/Emas Aksen */
            --light-bg: #f5f5f5;
        }

        body {
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-bg);
        }

        /* Top Bar */
        .top-bar {
            background-color: var(--primary-color);
            color: #dee2e6;
            font-size: 0.85rem;
            padding: 5px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Navbar Utama */
        .navbar-custom {
            background-color: rgba(13, 26, 38, 0.95);
            /* Sedikit transparan untuk elegan */
            border-bottom: 3px solid var(--accent-color);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .navbar-brand {
            color: white !important;
        }

        /* Button CTA */
        .cta-button {
            background-color: var(--accent-color);
            color: var(--primary-color);
            font-weight: 700;
            padding: 15px 50px;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.4);
        }

        .cta-button:hover {
            background-color: #e0a800;
            color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 193, 7, 0.6);
        }

        /* Lain-lain */
        .feature-icon,
        .text-warning {
            color: var(--accent-color) !important;
        }

        .vision-section {
            background-color: var(--primary-color);
            color: white;
        }

        .footer-custom {
            background-color: var(--primary-color);
        }

        .stat-box {
            background-color: white;
            border: none;
        }

        .service-card:hover {
            border-left: 4px solid var(--accent-color);
        }

        /* Judul Section yang Lebih Dramatis */
        .section-title {
            font-weight: 800;
            text-transform: uppercase;
            border-left: 5px solid var(--accent-color);
            padding-left: 15px;
            margin-bottom: 3rem;
        }

        /* Gambar Tim yang lebih elegan */
        .team-member img {
            filter: grayscale(50%);
            transition: filter 0.3s;
        }

        .team-member:hover img {
            filter: grayscale(0%);
        }

        .hero-title {
            font-size: 4rem;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.9);
        }

        /* Peningkatan Carousel */
        .carousel-item div.d-block {
            background-blend-mode: multiply;
            /* Memperkuat warna background */
            background-color: rgb(114, 114, 114);
            /* Warna dasar gelap */
        }
    </style>
</head>

<body>

    <div class="top-bar d-none d-md-block">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-start">
                    <i class="bi bi-clock me-2"></i> Jam Operasional Kantor: Senin - Jumat, 08:00 - 17:00 WITA
                </div>
                <div class="col-md-6 text-end">
                    <a href="mailto:info@baratala.co.id" class="text-white-50 text-decoration-none mx-2"><i
                            class="bi bi-envelope-fill me-1"></i> info@baratala.co.id</a>
                    <a href="tel:+628123456789" class="text-white-50 text-decoration-none mx-2"><i
                            class="bi bi-phone-fill me-1"></i> +62 812 XXXX XXXX</a>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark sticky-top navbar-custom p-3" style="z-index: 1050;">
        <div class="container">
            <a class="navbar-brand fw-bold text-uppercase" href="#">
                <img src="{{ asset('image/logo.png') }}" style="width: 40px" alt="Baratala Logo"> BARATALA TUNTUNG
                PANDANG
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="#operasi">Operasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="#bisnis-prospek">Bisnis</a></li>
                    <li class="nav-item"><a class="nav-link" href="#investor">Investor</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tim">Manajemen</a></li>
                    <li class="nav-item"><a class="nav-link" href="#berita">Berita</a></li>
                </ul>
                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-warning fw-bold ms-lg-3">Masuk</a>
            </div>
        </div>
    </nav>

    <section id="hero-slider" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner" style="height: 90vh;">
            <div class="carousel-item active" data-bs-interval="5000">
                <div class="d-block w-100"
                    style="background-image: url('{{ asset('image/mining-slide-1.jpg') }}'); background-size: cover; background-position: center; height: 90vh;">
                </div>
                <div class="carousel-caption">
                    <div class="col-lg-12">
                        <h1 class="hero-title fw-bolder mb-3 text-shadow">
                            BARATALA <span class="text-warning">TUNTUNG PANDANG</span>
                        </h1>
                        <p class="lead mb-5 fs-4 text-white-75">Perusahaan tambang terkemuka yang berbasis di Indonesia,
                            berkomitmen pada kualitas dan pertumbuhan berkelanjutan.</p>
                        <a href="#tentang" class="cta-button text-decoration-none">Kenali Kami Lebih Dekat</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item" data-bs-interval="5000">
                <div class="d-block w-100"
                    style="background-image: url('{{ asset('image/mining-slide-2.jpg') }}'); background-size: cover; background-position: center; height: 90vh;">
                </div>
                <div class="carousel-caption">
                    <div class="col-lg-12">
                        <h1 class="hero-title fw-bolder mb-3 text-shadow">FOKUS PADA <span
                                class="text-warning">INOVASI</span> DAN KUALITAS</h1>
                        <p class="lead mb-5 fs-4 text-white-75">Menciptakan nilai tambah optimal melalui teknologi
                            pertambangan modern dan operasi yang efisien.</p>
                        <a href="#operasi" class="cta-button text-decoration-none">Detail Operasi Kami</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item" data-bs-interval="5000">
                <div class="d-block w-100"
                    style="background-image: url('{{ asset('image/mining-slide-3.jpg') }}'); background-size: cover; background-position: center; height: 90vh;">
                </div>
                <div class="carousel-caption">
                    <div class="col-lg-12">
                        <h1 class="hero-title fw-bolder mb-3 text-shadow">PRIORITAS <span
                                class="text-warning">K3L</span> DAN SDM</h1>
                        <p class="lead mb-5 fs-4 text-white-75">Kepatuhan tanpa kompromi terhadap standar HSE dan
                            pengembangan sumber daya manusia.</p>
                        <a href="#k3l" class="cta-button text-decoration-none">Lihat Komitmen Kami</a>
                    </div>
                </div>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#hero-slider" data-bs-slide="prev"><span
                class="carousel-control-prev-icon" aria-hidden="true"></span><span
                class="visually-hidden">Previous</span></button>
        <button class="carousel-control-next" type="button" data-bs-target="#hero-slider"
            data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span
                class="visually-hidden">Next</span></button>
    </section>

    <section id="tentang" class="py-5 bg-white">
        <div class="container">
            <h2 class="section-title text-dark">Profil & Sejarah Perusahaan</h2>
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h3 class="text-secondary mb-4">Membangun Masa Depan Pertambangan Indonesia.</h3>
                    <p class="text-secondary">
                        BARATALA TUNTUNG PANDANG didirikan pada tahun **[Tahun Didirikan]** sebagai respon atas
                        kebutuhan industri akan mitra pertambangan yang fokus pada praktik **ESG** (Environmental,
                        Social, Governance) yang bertanggung jawab. Kami mengelola aset di **[Lokasi Utama, cth:
                        Kalimantan Timur]** dengan izin operasional yang lengkap.
                    </p>
                    <p class="text-secondary">
                        Kami mengintegrasikan teknologi pintar, kepatuhan ketat, dan pemberdayaan komunitas lokal untuk
                        mencapai keberhasilan jangka panjang.
                    </p>
                    <a href="#investor" class="btn btn-outline-dark mt-3">Lihat Tata Kelola Perusahaan</a>
                </div>
                <div class="col-lg-6">
                    <h4 class="fw-bold text-dark mb-3"><i class="bi bi-map-fill text-warning me-2"></i> Peta Wilayah
                        Operasi Utama</h4>
                    <div style="height: 400px;">
                       <iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d1391.8008590685292!2d114.88669565500732!3d-3.8064075642880026!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zM8KwNDgnMjMuMSJTIDExNMKwNTMnMTYuMyJF!5e1!3m2!1sid!2sid!4v1762739621582!5m2!1sid!2sid" width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <p class="small text-muted mt-2">Area Konsesi kami berlokasi strategis di [Sebutkan Detail Area
                        Industri].</p>
                </div>
            </div>
        </div>
    </section>

    <section id="statistik" class="py-5" style="background-color: var(--secondary-color);">
        <div class="container text-center">
            <h2 class="section-title text-white">Statistik Kunci Kami</h2>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="stat-box">
                        <h3 class="mb-1">20 Juta+</h3>
                        <p class="text-dark fw-bold small mb-0">Ton Material Diekstraksi</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-box">
                        <h3 class="mb-1">99.8%</h3>
                        <p class="text-dark fw-bold small mb-0">Tingkat Kepatuhan K3L</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-box">
                        <h3 class="mb-1">400+</h3>
                        <p class="text-dark fw-bold small mb-0">Hektar Lahan Direklamasi</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-box">
                        <h3 class="mb-1">100%</h3>
                        <p class="text-dark fw-bold small mb-0">Kepemilikan Alat Berat Terbaru</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 vision-section">
        <div class="container">
            <h2 class="section-title text-white">Visi & Misi Perusahaan</h2>
            <div class="row">
                <div class="col-md-6 mb-4 mb-md-0">
                    <h3 class="text-warning fw-bold mb-3"><i class="bi bi-eye-fill me-2"></i> Visi</h3>
                    <p class="lead">Menjadi perusahaan pertambangan *multinasional* terpercaya dan terdepan di Asia
                        Tenggara, diakui atas **keunggulan operasional** dan **praktik berkelanjutan**.</p>
                </div>
                <div class="col-md-6">
                    <h3 class="text-warning fw-bold mb-3"><i class="bi bi-flag-fill me-2"></i> Misi</h3>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-check-circle-fill text-warning me-2"></i> Menciptakan nilai optimal bagi
                            *stakeholder* melalui eksplorasi yang bertanggung jawab.</li>
                        <li><i class="bi bi-check-circle-fill text-warning me-2"></i> Menjaga standar K3L (Kesehatan,
                            Keselamatan Kerja, dan Lingkungan) kelas dunia.</li>
                        <li><i class="bi bi-check-circle-fill text-warning me-2"></i> Mengembangkan sumber daya manusia
                            yang kompeten dan berintegritas.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="operasi" class="py-5 bg-white">
        <div class="container">
            <h2 class="section-title text-dark">Tahapan Operasi Inti Kami (Kerja Lapangan)</h2>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="card service-card p-3 h-100 shadow-sm">
                        <div class="card-body"><i class="bi bi-geo-alt-fill text-warning mb-3 d-block fs-4"></i>
                            <h4 class="card-title h5 fw-bold">1. Mulut Tambang (Pit)</h4>
                            <p class="card-text text-secondary small">Ekskavasi dan penanganan material awal dengan
                                desain tambang yang aman dan efisien.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card service-card p-3 h-100 shadow-sm">
                        <div class="card-body"><i class="bi bi-truck-flatbed text-warning mb-3 d-block fs-4"></i>
                            <h4 class="card-title h5 fw-bold">2. Hauling & Transportasi</h4>
                            <p class="card-text text-secondary small">Pengangkutan material ke tempat penimbunan
                                (stockpile) dengan armada terawat.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card service-card p-3 h-100 shadow-sm">
                        <div class="card-body"><i class="bi bi-gear-fill text-warning mb-3 d-block fs-4"></i>
                            <h4 class="card-title h5 fw-bold">3. Processing Plant</h4>
                            <p class="card-text text-secondary small">Pencucian, penghancuran, dan penyesuaian ukuran
                                bijih (benefisiasi).</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card service-card p-3 h-100 shadow-sm">
                        <div class="card-body"><i class="bi bi-ship-fill text-warning mb-3 d-block fs-4"></i>
                            <h4 class="card-title h5 fw-bold">4. Pemuatan (Loading)</h4>
                            <p class="card-text text-secondary small">Pemuatan cepat dan akurat ke kapal di pelabuhan
                                khusus kami (pit-to-ship).</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="bisnis-prospek" class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title text-dark">Bisnis Inti, Produk & Prospek Usaha</h2>
            <div class="row g-4">
                <div class="col-lg-6">
                    <h3 class="h4 fw-bold text-dark mb-3 border-start border-warning border-3 ps-3">Produk dan
                        Distribusi</h3>
                    <p class="text-secondary">**BARATALA** fokus pada produksi **Bijih Besi (Iron Ore)** dengan kadar
                        [Sebutkan Kadar Utama, cth: Fe 62%] dan spesifikasi yang diminati pasar Asia. Kapasitas produksi
                        kami mencapai **[Sebutkan Kapasitas, cth: 5 Juta Ton]** per tahun.</p>
                    <p class="text-secondary small">Kami memiliki jaringan distribusi yang kuat dan terintegrasi dari
                        tambang hingga ke tujuan ekspor di [Sebutkan Target Pasar, cth: Cina, India, Korea Selatan].</p>
                    <a href="#kontak" class="btn btn-sm btn-outline-warning mt-2">Minta Spesifikasi Produk Lengkap</a>
                </div>
                <div class="col-lg-6">
                    <h3 class="h4 fw-bold text-dark mb-3 border-start border-warning border-3 ps-3">Prospek Usaha &
                        Kemitraan Modal</h3>
                    <p class="text-secondary">Dengan cadangan terbukti hingga [Sebutkan Angka, cth: 500 Juta Ton], kami
                        menjamin **pertumbuhan berkelanjutan** selama dua dekade ke depan. Kami terbuka untuk
                        **kemitraan modal** strategis yang sejalan dengan visi ekspansi pasar global.</p>
                    <p class="text-secondary small">Prioritas investasi kami adalah teknologi ramah lingkungan untuk
                        efisiensi jangka panjang.</p>
                    <a href="#kontak" class="btn btn-sm btn-outline-warning mt-2">Hubungi Tim Investor Relations</a>
                </div>
            </div>
        </div>
    </section>

    <section id="investor" class="py-5" style="background-color: var(--secondary-color);">
        <div class="container">
            <h2 class="section-title text-white">Tata Kelola Perusahaan & Transparansi Laporan</h2>
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="card p-4 h-100 shadow-lg border-0">
                        <h3 class="h4 fw-bold text-dark mb-3"><i class="bi bi-shield-check text-warning me-2"></i>
                            Tata Kelola Perusahaan (GCG)</h3>
                        <p class="text-secondary">Kami berkomitmen pada praktik Tata Kelola yang Baik (GCG) dengan
                            transparansi, akuntabilitas, tanggung jawab, independensi, dan kewajaran.</p>
                        <a href="/dokumen/gcg" class="btn btn-sm btn-dark mt-2">Baca Dokumen GCG</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card p-4 h-100 shadow-lg border-0">
                        <h3 class="h4 fw-bold text-dark mb-3"><i
                                class="bi bi-file-earmark-bar-graph text-warning me-2"></i> Dokumen & Laporan</h3>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2"><i class="bi bi-file-earmark-pdf text-danger me-2"></i> <a
                                    href="/laporan/tahunan-2024.pdf" class="text-dark fw-bold">Laporan Tahunan
                                    2024</a></li>
                            <li><i class="bi bi-cash text-success me-2"></i> <a href="/laporan/keuangan-q3-2025.pdf"
                                    class="text-dark fw-bold">Laporan Keuangan Kuartal III 2025</a></li>
                        </ul>
                        <a href="/laporan" class="btn btn-sm btn-dark mt-3">Arsip Semua Laporan</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="tim" class="py-5 bg-white">
        <div class="container text-center">
            <h2 class="section-title text-dark">Dewan Direksi & Tim Kepemimpinan</h2>
            <div class="row g-4 justify-content-center">
                 <div class="col-md-3 col-sm-6">
                    <div class="team-member">
                        <img src="{{ asset('image/direktur.jpg') }}" class="img-fluid rounded-circle mb-3 shadow"
                            style="width: 150px; height: 150px; object-fit: cover;" alt="COO">
                        <h4 class="h6 fw-bold mb-0 text-dark">Ihsanudin</h4>
                        <p class="small text-warning mb-2">Direktur Baratala</p>
                        {{-- <p class="small text-secondary fst-italic">"Efisiensi operasi adalah kunci daya saing global
                            kami."</p> --}}
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="team-member">
                        <img src="{{ asset('image/bupati.png') }}" class="img-fluid rounded-circle mb-3 shadow"
                            style="width: 150px; height: 150px; object-fit: cover;" alt="Bupati Tanah Laut">
                        <h4 class="h6 fw-bold mb-0 text-dark">H. Rahmat Trianto</h4>
                        <p class="small text-warning mb-2">Bupati Tanah Laut</p>
                        {{-- <p class="small text-secondary fst-italic">"Integritas adalah fondasi dari setiap Ton yang kami
                            produksi."</p> --}}
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="team-member">
                        <img src="{{ asset('image/nurhidayati.jpg') }}" class="img-fluid rounded-circle mb-3 shadow"
                            style="width: 150px; height: 150px; object-fit: cover;" alt="Direktur K3L">
                        <h4 class="h6 fw-bold mb-0 text-dark">Nurhidayati</h4>
                        <p class="small text-warning mb-2">Badan Pengawas</p>
                        {{-- <p class="small text-secondary fst-italic">"Keselamatan bukan prioritas, tapi nilai yang
                            tertanam."</p> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="berita" class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title text-dark">Berita dan Kegiatan Terbaru</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 news-card shadow-sm border-0">
                        <img src="{{ asset('image/gallery-5.jpg') }}" class="card-img-top"
                            style="height: 200px; object-fit: cover;" alt="CSR">
                        <div class="card-body">
                            <span class="badge bg-warning text-dark mb-2 fw-bold">CSR</span>
                            <h5 class="card-title fw-bold">Program Pemberdayaan Petani Lokal.</h5>
                            <p class="card-text small text-secondary">Baratala meluncurkan pelatihan intensif untuk
                                meningkatkan hasil panen masyarakat sekitar tambang.</p>
                            <a href="#" class="text-warning small text-decoration-none fw-bold">Baca
                                Selengkapnya <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 news-card shadow-sm border-0">
                        <img src="{{ asset('image/gallery-2.jpg') }}" class="card-img-top"
                            style="height: 200px; object-fit: cover;" alt="Operasional">
                        <div class="card-body">
                            <span class="badge bg-warning text-dark mb-2 fw-bold">Operasional</span>
                            <h5 class="card-title fw-bold">Pencapaian Rekor Produksi Kuartal Ini.</h5>
                            <p class="card-text small text-secondary">Divisi Operasi berhasil melampaui target bulanan
                                sebesar 15% berkat optimasi Hauling.</p>
                            <a href="#" class="text-warning small text-decoration-none fw-bold">Baca
                                Selengkapnya <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 news-card shadow-sm border-0">
                        <img src="{{ asset('image/gallery-1.jpg') }}" class="card-img-top"
                            style="height: 200px; object-fit: cover;" alt="Teknologi">
                        <div class="card-body">
                            <span class="badge bg-warning text-dark mb-2 fw-bold">Teknologi</span>
                            <h5 class="card-title fw-bold">Implementasi Sistem Pemantauan Otomatis IoT.</h5>
                            <p class="card-text small text-secondary">Peningkatan efisiensi dan keamanan dengan
                                pemasangan sensor pintar di seluruh pit area.</p>
                            <a href="#" class="text-warning small text-decoration-none fw-bold">Baca
                                Selengkapnya <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="/berita-kegiatan" class="btn btn-outline-dark">Lihat Semua Berita & Kegiatan</a>
            </div>
        </div>
    </section>

    <section id="kontak" class="py-5" style="background-color: var(--primary-color);">
        <div class="container text-center">
            <h2 class="display-5 fw-bold text-warning mb-3">Siap Menjalin Kemitraan Jangka Panjang?</h2>
            <p class="lead text-white-50 mb-4">Hubungi tim kami hari ini untuk berdiskusi lebih lanjut mengenai peluang
                investasi dan kerjasama.</p>

            <a href="/unduh-profil.pdf" target="_blank"
                class="cta-button bg-danger text-white text-decoration-none border border-light border-2 me-3">
                <i class="bi bi-cloud-arrow-down-fill me-2"></i> Unduh Profil PDF
            </a>

            <button type="button" class="cta-button bg-info text-white text-decoration-none" data-bs-toggle="modal"
                data-bs-target="#contactModal">
                Jadwalkan Pertemuan
            </button>
        </div>
    </section>

    <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-dark fw-bold" id="contactModalLabel">Formulir Permintaan Pertemuan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="small text-secondary">Isi detail Anda, kami akan segera menghubungi tim direksi.</p>
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
                            <label for="pesan" class="form-label small">Tujuan Pertemuan Singkat</label>
                            <textarea class="form-control" id="pesan" name="pesan" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-warning w-100 fw-bold">Kirim Permintaan
                            Pertemuan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer-custom text-white-50 py-4">
        <div class="container text-center">
            <div class="row g-3 justify-content-center mb-3">
                <div class="col-auto"><a href="#" class="text-white-50"><i
                            class="bi bi-linkedin fs-4"></i></a></div>
                <div class="col-auto"><a href="#" class="text-white-50"><i
                            class="bi bi-facebook fs-4"></i></a></div>
                <div class="col-auto"><a href="#" class="text-white-50"><i
                            class="bi bi-instagram fs-4"></i></a></div>
            </div>
            <p class="mb-1 small">&copy; {{ date('Y') }} BARATALA TUNTUNG PANDANG. All Rights Reserved.</p>
            <div class="small">
                <a href="/privacy" class="text-white-50 text-decoration-none mx-2">Kebijakan Privasi</a>
                |
                <a href="/terms" class="text-white-50 text-decoration-none mx-2">Syarat &amp; Ketentuan</a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

</body>

</html>
