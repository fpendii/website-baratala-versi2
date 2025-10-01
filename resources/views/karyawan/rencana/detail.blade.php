@extends('layout.karyawan-template')

@section('title', 'Detail Rencana Kerja')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Rencana Kerja /</span> Detail
    </h4>

    <div class="row">

        {{-- KOLOM KIRI: DETAIL RENCANA KERJA --}}
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Detail Rencana Kerja</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Judul Rencana</dt>
                        <dd class="col-sm-8">{{ $tugas->judul_rencana }}</dd>

                        <dt class="col-sm-4">Deskripsi</dt>
                        <dd class="col-sm-8">{{ $tugas->deskripsi }}</dd>

                        <dt class="col-sm-4">Tanggal Mulai</dt>
                        <dd class="col-sm-8">{{ $tugas->tanggal_mulai }}</dd>

                        <dt class="col-sm-4">Tanggal Selesai</dt>
                        <dd class="col-sm-8">{{ $tugas->tanggal_selesai }}</dd>

                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">
                            <span class="badge bg-label-{{ $tugas->status == 'selesai' ? 'success' : ($tugas->status == 'sedang dikerjakan' ? 'warning' : 'secondary') }}">
                                {{ $tugas->status }}
                            </span>
                        </dd>

                        <dt class="col-sm-4">Jenis</dt>
                        <dd class="col-sm-8">{{ ucfirst($tugas->jenis) }}</dd>

                        <dt class="col-sm-4">Prioritas</dt>
                        <dd class="col-sm-8">{{ $tugas->prioritas ?? '-' }}</dd>

                        <dt class="col-sm-4">Lampiran</dt>
                        <dd class="col-sm-8">
                            @if($tugas->lampiran)
                                <a href="{{ asset('storage/public/' . $tugas->lampiran) }}" target="_blank">Lihat Lampiran</a>
                            @else
                                Tidak ada
                            @endif
                        </dd>

                        <dt class="col-sm-4">Catatan</dt>
                        <dd class="col-sm-8">{{ $tugas->catatan ?? '-' }}</dd>
                    </dl>

                    <div class="mt-4 pt-2 border-top">
                        <a href="{{ route('karyawan.rencana.edit', $tugas->id) }}" class="btn btn-warning">Edit</a>
                        <a href="{{ route('karyawan.rencana.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>


        {{-- KOLOM KANAN: PENGGUNA YANG DITUGASKAN (Read-Only) --}}
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Pengguna yang Ditugaskan</h5>
                </div>
                <div class="card-body">
                    @if($tugas->pengguna->isNotEmpty())
                        <ul class="list-unstyled mb-0">
                            @foreach($tugas->pengguna as $user)
                                <li class="mb-2 d-flex align-items-center">
                                    <i class='bx bx-user-circle me-2 text-primary'></i>
                                    <span>{{ $user->name }} ({{ $user->email }})</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Tidak ada pengguna lain yang ditugaskan pada rencana kerja ini.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
