@extends('layout.direktur-template')

@section('title', 'Laporan Karyawan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0">Laporan Karyawan</h5>
        <a href="{{ url('/direktur/laporan/tabel') }}" class="btn btn-primary">
            <i class="ri ri-table-2 me-1"></i> Tampilan Tabel
        </a>
    </div>

    <div class="row g-4">
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="fw-medium">Laporan Masalah Sistem</span>
                    <span class="badge bg-label-info">Dalam Proses</span>
                </div>
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-body-secondary">Dari: Siti Rahayu</h6>
                    <p class="card-text text-truncate">
                        Terdapat bug pada fitur input data yang menyebabkan error saat menyimpan informasi.
                    </p>
                    <a href="/direktur/laporan/detail/1" class="btn btn-primary btn-sm">Lihat Detail</a>
                </div>
                <div class="card-footer text-body-secondary">
                    Dikirim pada: 10 Sep 2025
                </div>
            </div>
        </div>
    </div>
@endsection
