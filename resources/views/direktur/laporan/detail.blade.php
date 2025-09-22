@extends('layout.direktur-template')

@section('title', 'Detail Laporan Karyawan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">Detail Laporan Karyawan</h5>
    <a href="{{ url('/direktur/laporan') }}" class="btn btn-secondary btn-sm">Kembali</a>
</div>

<div class="card">
    <div class="card-body">
        <h6 class="card-title mb-2">Judul Laporan</h6>
        <p>{{ $laporan->judul }}</p>

        <h6 class="card-title mb-2">Karyawan</h6>
        <p>{{ $laporan->pengguna->nama ?? 'Tidak diketahui' }}</p>

        <h6 class="card-title mb-2">Deskripsi</h6>
        <p>{{ $laporan->deskripsi }}</p>

        <h6 class="card-title mb-2">Lampiran</h6>
        <p>
            @if($laporan->lampiran)
                <a href="{{ asset('storage/' . $laporan->lampiran) }}" target="_blank">Lihat Lampiran</a>
            @else
                <span class="text-muted">Tidak ada lampiran</span>
            @endif
        </p>

        <h6 class="card-title mb-2">Status</h6>
        <p>
            @if($laporan->status == 'pending')
                <span class="badge bg-warning rounded-pill">Pending</span>
            @elseif($laporan->status == 'diterima')
                <span class="badge bg-success rounded-pill">Diterima</span>
            @elseif($laporan->status == 'ditolak')
                <span class="badge bg-danger rounded-pill">Ditolak</span>
            @else
                <span class="badge bg-secondary rounded-pill">{{ ucfirst($laporan->status) }}</span>
            @endif
        </p>

        <h6 class="card-title mb-2">Keputusan</h6>
        <p>{{ $laporan->keputusan ?? '-' }}</p>

        <h6 class="card-title mb-2">Tanggal Dibuat</h6>
        <p>{{ $laporan->created_at ? $laporan->created_at->format('d M Y H:i') : '-' }}</p>

        <h6 class="card-title mb-2">Tanggal Diperbarui</h6>
        <p>{{ $laporan->updated_at ? $laporan->updated_at->format('d M Y H:i') : '-' }}</p>
    </div>
</div>
@endsection
