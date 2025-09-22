@extends('layout.direktur-template')

@section('title', 'Detail Laporan Jobdesk Karyawan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">Detail Laporan Jobdesk Karyawan</h5>
    @if(isset($halamnJobdeskKaryawan))
    <a href="/direktur/jobdesk-laporan/jobdesk-karyawan" class="btn btn-primary btn-sm">Kembali</a>
    @else
    <a href="/direktur/jobdesk-laporan" class="btn btn-secondary btn-sm">Kembali</a>
    @endif
</div>

@php
// Data dummy laporan jobdesk
$laporanJobdesk = [
    'id' => 1,
    'karyawan' => 'Albert Cook',
    'id_jobdesk' => 101,
    'judul_jobdesk' => 'Pengawasan Pengeboran',
    'jobdesk_deskripsi' => 'Mengawasi proses pengeboran agar sesuai standar keselamatan.',
    'divisi' => 'produksi',
    'deskripsi_laporan' => 'Semua pengeboran berjalan sesuai jadwal. Tidak ada insiden.',
    'lampiran' => 'laporan_1.pdf',
    'status' => 'dikerjakan',
    'created_at' => '2025-09-20 08:30',
    'updated_at' => '2025-09-20 12:15',
];
@endphp

<div class="card">
    <div class="card-body">
        <h6 class="card-title mb-2">Karyawan</h6>
        <p>{{ $laporanJobdesk['karyawan'] }}</p>

        <h6 class="card-title mb-2">Judul Jobdesk</h6>
        <p>{{ $laporanJobdesk['judul_jobdesk'] }}</p>

        <h6 class="card-title mb-2">Deskripsi Jobdesk</h6>
        <p>{{ $laporanJobdesk['jobdesk_deskripsi'] }}</p>

        <h6 class="card-title mb-2">Divisi</h6>
        <p>{{ ucfirst($laporanJobdesk['divisi']) }}</p>

        <h6 class="card-title mb-2">Deskripsi Laporan</h6>
        <p>{{ $laporanJobdesk['deskripsi_laporan'] }}</p>

        <h6 class="card-title mb-2">Lampiran</h6>
        <p>
            @if($laporanJobdesk['lampiran'])
                <a href="{{ asset('storage/' . $laporanJobdesk['lampiran']) }}" target="_blank">Lihat Lampiran</a>
            @else
                Tidak ada lampiran
            @endif
        </p>

        <h6 class="card-title mb-2">Status</h6>
        <p>
            @if($laporanJobdesk['status'] == 'dikerjakan')
                <span class="badge bg-label-primary rounded-pill">Dikerjakan</span>
            @else
                <span class="badge bg-label-danger rounded-pill">Belum Dikerjakan</span>
            @endif
        </p>

        <h6 class="card-title mb-2">Tanggal Dibuat</h6>
        <p>{{ \Carbon\Carbon::parse($laporanJobdesk['created_at'])->format('d M Y H:i') }}</p>

        <h6 class="card-title mb-2">Tanggal Diperbarui</h6>
        <p>{{ \Carbon\Carbon::parse($laporanJobdesk['updated_at'])->format('d M Y H:i') }}</p>
    </div>
</div>
@endsection
