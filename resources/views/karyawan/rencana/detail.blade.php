@extends('layout.karyawan-template')

@section('title', 'Detail Rencana Kerja')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Detail Rencana Kerja</h5>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Judul Rencana</dt>
                <dd class="col-sm-9">{{ $tugas->judul_rencana }}</dd>

                <dt class="col-sm-3">Deskripsi</dt>
                <dd class="col-sm-9">{{ $tugas->deskripsi }}</dd>

                <dt class="col-sm-3">Tanggal Mulai</dt>
                <dd class="col-sm-9">{{ $tugas->tanggal_mulai }}</dd>

                <dt class="col-sm-3">Tanggal Selesai</dt>
                <dd class="col-sm-9">{{ $tugas->tanggal_selesai }}</dd>

                <dt class="col-sm-3">Status</dt>
                <dd class="col-sm-9">
                    <span class="badge bg-label-{{ $tugas->status == 'selesai' ? 'success' : ($tugas->status == 'sedang dikerjakan' ? 'warning' : 'secondary') }}">
                        {{ $tugas->status }}
                    </span>
                </dd>

                <dt class="col-sm-3">Jenis</dt>
                <dd class="col-sm-9">{{ ucfirst($tugas->jenis) }}</dd>

                <dt class="col-sm-3">Prioritas</dt>
                <dd class="col-sm-9">{{ $tugas->prioritas ?? '-' }}</dd>

                <dt class="col-sm-3">Lampiran</dt>
                <dd class="col-sm-9">
                    @if($tugas->lampiran)
                        <a href="{{ asset('storage/public/' . $tugas->lampiran) }}" target="_blank">Lihat Lampiran</a>
                    @else
                        Tidak ada
                    @endif
                </dd>

                <dt class="col-sm-3">Catatan</dt>
                <dd class="col-sm-9">{{ $tugas->catatan ?? '-' }}</dd>
            </dl>

            <a href="{{ route('karyawan.rencana.edit', $tugas->id) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('karyawan.rencana.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
