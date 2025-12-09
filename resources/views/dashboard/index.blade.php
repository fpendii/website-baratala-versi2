@extends('layout.app')

@section('title', 'Dashboard Direktur')

@section('content')
    <!-- Judul Utama Halaman -->
    {{-- Mengganti format py-3 menjadi mb-4 agar konsisten dengan template sebelumnya --}}
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="fw-bold">
                <span class="text-muted fw-light">Direktur /</span> Dashboard
            </h4>
        </div>
    </div>


    <!-- Greeting Card / Welcome Banner -->
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card bg-primary text-white shadow-lg">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="card-title text-white mb-2">Selamat Datang {{ auth()->user()->nama }}</h4>
                            <p class="mb-0">
                                Ringkasan harian dan metrik utama untuk pemantauan surat dan karyawan.
                            </p>
                        </div>
                        {{-- Icon Besar di Pojok --}}
                        <i class="ri ri-briefcase-line ri-4x ms-3 opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Key Metric Cards (Ringkasan Data Cepat) -->
    <div class="row">

        <div class="col-lg-3 col-md-6 col-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="card-title mb-0">
                            <h5 class="fw-semibold d-block mb-1">Surat Keluar</h5>
                            <small class="text-muted">Total Bulan Ini</small>
                        </div>
                        <span class="badge bg-label-warning p-2 rounded-circle">
                            <i class="ri ri-mail-send-fill ri-2x text-warning"></i>
                        </span>
                    </div>
                    {{-- Data Statistik --}}
                    <h3 class="mt-3 mb-0">32</h3>
                </div>
            </div>
        </div>

        {{-- Card 2: Total Surat Masuk Bulan Ini --}}
        <div class="col-lg-3 col-md-6 col-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="card-title mb-0">
                            <h5 class="fw-semibold d-block mb-1">Surat Masuk</h5>
                            <small class="text-muted">Total Bulan Ini</small>
                        </div>
                        <span class="badge bg-label-success p-2 rounded-circle">
                            <i class="ri ri-mail-open-fill ri-2x text-success"></i>
                        </span>
                    </div>
                    {{-- Data Statistik --}}
                    <h3 class="mt-3 mb-0">45</h3>
                </div>
            </div>
        </div>



        {{-- Card 3: Total Karyawan Aktif --}}
        <div class="col-lg-3 col-md-6 col-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="card-title mb-0">
                            <h5 class="fw-semibold d-block mb-1">Karyawan</h5>
                            <small class="text-muted">Jumlah Aktif</small>
                        </div>
                        <span class="badge bg-label-info p-2 rounded-circle">
                            <i class="ri ri-user-2-fill ri-2x text-info"></i>
                        </span>
                    </div>
                    {{-- Data Statistik --}}
                    <h3 class="mt-3 mb-0">128</h3>
                </div>
            </div>
        </div>

        {{-- Card 4: Surat Keluar Bulan Ini --}}

    </div>
    <!-- End Key Metric Cards -->



    <style>
        /* Menggunakan skema warna yang mirip dengan Bootstrap 5 untuk badge-label */
        .bg-label-primary {
            background-color: rgba(105, 108, 255, 0.16) !important;
            color: #696cff !important;
        }

        .bg-label-danger {
            background-color: rgba(255, 62, 29, 0.16) !important;
            color: #ff3e1d !important;
        }

        .bg-label-success {
            background-color: rgba(113, 221, 55, 0.16) !important;
            color: #71dd37 !important;
        }

        .bg-label-info {
            background-color: rgba(0, 208, 255, 0.16) !important;
            color: #00d0ff !important;
        }

        .bg-label-warning {
            background-color: rgba(255, 171, 0, 0.16) !important;
            color: #ffab00 !important;
        }

        .ri-2x {
            font-size: 1.5rem;
            /* Ukuran ikon di dalam badge */
        }

        .ri-4x {
            font-size: 3rem;
            /* Ukuran ikon di greeting card */
        }
    </style>
    {{-- Catatan: Pastikan Anda telah menyertakan library Remix Icon (ri) di file layout Anda untuk menampilkan ikon. --}}
@endsection
