@extends('layout.karyawan-template')

@section('title', 'Edit Rencana Kerja')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Edit Rencana Kerja</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('karyawan.rencana.update', $tugas->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Judul Rencana -->
                <div class="mb-3">
                    <label for="judul_rencana" class="form-label">Judul Rencana</label>
                    <input type="text" id="judul_rencana" name="judul_rencana" class="form-control" value="{{ $tugas->judul_rencana }}" required>
                </div>

                <!-- Deskripsi -->
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" class="form-control" rows="5">{{ $tugas->deskripsi }}</textarea>
                </div>

                <!-- Tanggal Mulai -->
                <div class="mb-3">
                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                    <input type="date" id="tanggal_mulai" name="tanggal_mulai" class="form-control" value="{{ $tugas->tanggal_mulai }}" required>
                </div>

                <!-- Tanggal Selesai -->
                <div class="mb-3">
                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                    <input type="date" id="tanggal_selesai" name="tanggal_selesai" class="form-control" value="{{ $tugas->tanggal_selesai }}" required>
                </div>

                <!-- Status -->
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select">
                        <option value="belum dikerjakan" {{ $tugas->status == 'belum dikerjakan' ? 'selected' : '' }}>Belum Dikerjakan</option>
                        <option value="sedang dikerjakan" {{ $tugas->status == 'sedang dikerjakan' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                        <option value="selesai" {{ $tugas->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <input type="hidden" name="jenis" value="rencana" id="">

                <!-- Prioritas -->
                <div class="mb-3">
                    <label for="prioritas" class="form-label">Prioritas</label>
                    <select id="prioritas" name="prioritas" class="form-select">
                        <option value="" {{ !$tugas->prioritas ? 'selected' : '' }}>-- Pilih Prioritas --</option>
                        <option value="rendah" {{ $tugas->prioritas == 'rendah' ? 'selected' : '' }}>Rendah</option>
                        <option value="sedang" {{ $tugas->prioritas == 'sedang' ? 'selected' : '' }}>Sedang</option>
                        <option value="tinggi" {{ $tugas->prioritas == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                    </select>
                </div>

                <!-- Lampiran -->
                <div class="mb-3">
                    <label for="lampiran" class="form-label">Lampiran (Opsional)</label>
                    @if($tugas->lampiran)
                        <p>File saat ini: <a href="{{ asset('storage/' . $tugas->lampiran) }}" target="_blank">Lihat</a></p>
                    @endif
                    <input type="file" id="lampiran" name="lampiran" class="form-control" accept=".pdf,.doc,.docx,.jpg,.png">
                </div>

                <!-- Catatan -->
                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan (Opsional)</label>
                    <textarea id="catatan" name="catatan" class="form-control" rows="3">{{ $tugas->catatan }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Update Rencana</button>
                <a href="{{ route('karyawan.rencana.index') }}" class="btn btn-outline-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
