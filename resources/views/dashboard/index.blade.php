@extends('layout.app')

@section('title', 'Dashboard')

@section('content')

    <div class="row">
        <div class="col-lg-12 mb-5">
            <div class="card bg-primary text-white shadow-lg p-3 border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="flex-grow-1">
                            <h3 class="card-title text-white mb-2 fw-bold">
                                Selamat Datang Kembali, {{ Auth::user()->nama ?? 'Pengguna' }}!
                            </h3>
                            <p class="opacity-75 mb-0">
                                Ini adalah pusat kendali Anda. Akses cepat ke modul utama di bawah ini.
                            </p>
                            <small class="text-white-50 mt-2 d-block">
                                Tanggal Hari Ini: {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                            </small>
                        </div>
                        <i class="ri ri-briefcase-line ri-5x ms-4 text-white opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    ---

    {{-- Grup 1: Menu Tugas dan Administrasi Utama --}}
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="mb-3 text-muted">Akses Tugas Utama <i class="ri ri-rocket-line text-primary"></i></h4>
        </div>

        {{-- Jobdesk (Hanya Admin) --}}
        @if (auth()->user()->role == 'admin')
        <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
            <a href="/data-jobdesk" class="card shadow h-100 p-3 btn text-start bg-info text-white card-hover-scale">
                <i class="ri ri-task-line ri-2x mb-2 d-block"></i>
                <h6 class="mb-0 fw-bold">Kelola Data Jobdesk</h6>
                <small>Buat & alokasikan tugas.</small>
            </a>
        </div>
        @endif

        {{-- Surat Masuk --}}
        <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
            <a href="/surat-masuk" class="card shadow h-100 p-3 btn text-start bg-warning text-white card-hover-scale">
                <i class="ri ri-mail-line ri-2x mb-2 d-block"></i>
                <h6 class="mb-0 fw-bold">Surat Masuk</h6>
                <small>Periksa surat yang perlu ditindaklanjuti.</small>
            </a>
        </div>

        {{-- Rencana Kerja --}}
        <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
            <a href="/rencana" class="card shadow h-100 p-3 btn text-start bg-success text-white card-hover-scale">
                <i class="ri ri-calendar-check-line ri-2x mb-2 d-block"></i>
                <h6 class="mb-0 fw-bold">Rencana Kerja</h6>
                <small>Lihat dan atur jadwal kerja.</small>
            </a>
        </div>

        {{-- Laporan Jobdesk --}}
        <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
            <a href="/jobdesk" class="card shadow h-100 p-3 btn text-start bg-primary text-white card-hover-scale">
                <i class="ri ri-file-list-3-line ri-2x mb-2 d-block"></i>
                <h6 class="mb-0 fw-bold">Laporan Jobdesk</h6>
                <small>Buat dan kirim laporan pekerjaan.</small>
            </a>
        </div>

    </div>

    ---

    {{-- Grup 2: Menu Sistem dan Personal --}}
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3 text-muted">Akses Sistem & Personal <i class="ri ri-settings-3-line text-secondary"></i></h4>
        </div>

        {{-- Keuangan (Hanya Keuangan atau Direktur) --}}
        @if (auth()->user()->role == 'keuangan' || auth()->user()->role == 'direktur')
        <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
            <a href="/keuangan" class="card shadow h-100 p-3 btn text-start bg-danger text-white card-hover-scale">
                <i class="ri ri-wallet-3-line ri-2x mb-2 d-block"></i>
                <h6 class="mb-0 fw-bold">Keuangan</h6>
                <small>Akses data finansial perusahaan.</small>
            </a>
        </div>
        @endif

        {{-- Pengguna (Hanya Admin) --}}
        @if (auth()->user()->role == 'admin')
        <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
            <a href="/pengguna" class="card shadow h-100 p-3 btn text-start bg-secondary text-white card-hover-scale">
                <i class="ri ri-team-line ri-2x mb-2 d-block"></i>
                <h6 class="mb-0 fw-bold">Kelola Pengguna</h6>
                <small>Atur akun dan peran pengguna.</small>
            </a>
        </div>
        @endif

        {{-- Profil --}}
        <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
            <a href="/profil" class="card shadow h-100 p-3 btn text-start bg-dark text-white card-hover-scale">
                <i class="ri ri-user-line ri-2x mb-2 d-block"></i>
                <h6 class="mb-0 fw-bold">Profil Saya</h6>
                <small>Perbarui informasi pribadi.</small>
            </a>
        </div>

        {{-- Logout --}}
        <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
            <form action="/logout" method="POST" class="h-100">
                @csrf
                <button type="submit" class="card shadow h-100 p-3 btn text-start bg-light text-danger card-hover-scale">
                    <i class="ri ri-logout-box-r-line ri-2x mb-2 d-block"></i>
                    <h6 class="mb-0 fw-bold">Logout</h6>
                    <small class="text-muted">Keluar dari sistem.</small>
                </button>
            </form>
        </div>

    </div>

    {{-- Custom Style --}}
    <style>
        /* Efek Hover diubah untuk menaikkan kartu */
        .card-hover-scale {
            transition: all 0.2s ease-in-out;
        }
        .card-hover-scale:hover {
            transform: translateY(-5px); /* Sedikit naik */
            box-shadow: 0 10px 20px rgba(0,0,0,0.2) !important; /* Bayangan lebih jelas */
            text-decoration: none; /* Hilangkan garis bawah link */
        }
        /* Style untuk tombol/card */
        .btn.card {
            border-radius: 0.75rem; /* Sudut lebih membulat */
            border: none;
        }
    </style>
@endsection
