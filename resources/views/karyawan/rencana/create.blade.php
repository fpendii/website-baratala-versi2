@extends('layout.karyawan-template')

@section('title', 'Tambah Rencana Kerja')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Tambah Rencana Kerja</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('karyawan.rencana.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="judul_rencana" class="form-label">Judul Rencana</label>
                    <input type="text" id="judul_rencana" name="judul_rencana" class="form-control" placeholder="Masukkan judul rencana" required>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" class="form-control" rows="5" placeholder="Tuliskan deskripsi rencana kerja"></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                        <input type="date" id="tanggal_mulai" name="tanggal_mulai" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                        <input type="date" id="tanggal_selesai" name="tanggal_selesai" class="form-control" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-select" required>
                            <option value="belum dikerjakan">Belum Dikerjakan</option>
                            <option value="belum dikerjakan">On Progress</option>
                            <option value="selesai">Tidak Dikerjakan</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="prioritas" class="form-label">Prioritas</label>
                        <select id="prioritas" name="prioritas" class="form-select">
                            <option value="">-- Pilih Prioritas --</option>
                            <option value="rendah">Rendah</option>
                            <option value="sedang">Sedang</option>
                            <option value="tinggi">Tinggi</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="jenis" value="rencana" id="">



                <input type="hidden" name="pengguna" id="pengguna-hidden">

                <div class="mb-3">
                    <label for="lampiran" class="form-label">Lampiran (Opsional)</label>
                    <input type="file" id="lampiran" name="lampiran" class="form-control" accept=".pdf,.doc,.docx,.jpg,.png">
                </div>

                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan (Opsional)</label>
                    <textarea id="catatan" name="catatan" class="form-control" rows="3" placeholder="Tambahkan catatan"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Rencana</button>
                <a href="{{ route('karyawan.rencana.index') }}" class="btn btn-outline-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>

@endsection
