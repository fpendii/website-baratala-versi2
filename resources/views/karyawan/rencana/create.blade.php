@extends('layout.karyawan-template')

@section('title', 'Tambah Rencana Kerja')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Tambah Rencana Kerja</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="#" enctype="multipart/form-data">
                @csrf

                <!-- Judul Rencana -->
                <div class="mb-3">
                    <label for="judul_rencana" class="form-label">Judul Rencana</label>
                    <input type="text" id="judul_rencana" name="judul_rencana" class="form-control" placeholder="Masukkan judul rencana" required>
                </div>

                <!-- Deskripsi -->
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" class="form-control" rows="5" placeholder="Tuliskan deskripsi rencana kerja" required></textarea>
                </div>

                <!-- Tanggal Mulai -->
                <div class="mb-3">
                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                    <input type="date" id="tanggal_mulai" name="tanggal_mulai" class="form-control" required>
                </div>

                <!-- Tanggal Selesai -->
                <div class="mb-3">
                    <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                    <input type="date" id="tanggal_selesai" name="tanggal_selesai" class="form-control" required>
                </div>

                <!-- Status -->
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select" required>
                        <option value="belum dikerjakan">Belum Dikerjakan</option>
                        <option value="sedang dikerjakan">Sedang Dikerjakan</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>

                <!-- Jenis -->
                <div class="mb-3">
                    <label for="jenis" class="form-label">Jenis</label>
                    <select id="jenis" name="jenis" class="form-select" required>
                        <option value="rencana">Rencana</option>
                        <option value="perintah">Perintah</option>
                    </select>
                </div>

                <!-- Prioritas -->
                <div class="mb-3">
                    <label for="prioritas" class="form-label">Prioritas</label>
                    <select id="prioritas" name="prioritas" class="form-select">
                        <option value="">-- Pilih Prioritas --</option>
                        <option value="rendah">Rendah</option>
                        <option value="sedang">Sedang</option>
                        <option value="tinggi">Tinggi</option>
                    </select>
                </div>

                <!-- Lampiran -->
                <div class="mb-3">
                    <label for="lampiran" class="form-label">Lampiran (Opsional)</label>
                    <input type="file" id="lampiran" name="lampiran" class="form-control" accept=".pdf,.doc,.docx,.jpg,.png">
                </div>

                <!-- Catatan -->
                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan (Opsional)</label>
                    <textarea id="catatan" name="catatan" class="form-control" rows="3" placeholder="Tambahkan catatan"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Rencana</button>
                <a href="#" class="btn btn-outline-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
