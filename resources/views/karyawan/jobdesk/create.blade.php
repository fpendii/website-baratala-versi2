@extends('layout.karyawan-template')

@section('title', 'Tambah Laporan Jobdesk')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Tambah Laporan Jobdesk</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="#" enctype="multipart/form-data">
                @csrf

                <!-- Dropdown Jobdesk Dummy -->
                <div class="mb-3">
                    <label for="jobdesk_id" class="form-label">Pilih Jobdesk</label>
                    <select id="jobdesk_id" name="jobdesk_id" class="form-select" required>
                        <option value="">-- Pilih Jobdesk --</option>
                        <option value="1">Mengawasi Proses Pengeboran (Tambang)</option>
                        <option value="2">Membuat Laporan Mingguan (Keuangan)</option>
                        <option value="3">Mengoperasikan Alat Berat (Operasional)</option>
                        <option value="4">Pemeliharaan Mesin (Produksi)</option>
                        <option value="5">Rencana Strategi Perusahaan (Direktur)</option>
                    </select>
                </div>

                <!-- Judul Laporan -->
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Laporan</label>
                    <input type="text" id="judul" name="judul" class="form-control" placeholder="Masukkan judul laporan" required>
                </div>

                <!-- Deskripsi -->
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" class="form-control" rows="5" placeholder="Tuliskan deskripsi laporan" required></textarea>
                </div>

                <!-- Lampiran -->
                <div class="mb-3">
                    <label for="lampiran" class="form-label">Lampiran (Opsional)</label>
                    <input type="file" id="lampiran" name="lampiran" class="form-control" accept=".pdf,.doc,.docx,.jpg,.png">
                </div>

                <!-- Status -->
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-select" required>
                        <option value="dikerjakan">Dikerjakan</option>
                        <option value="tidak-dikerjakan">Tidak Dikerjakan</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Kirim Laporan</button>
                <a href="#" class="btn btn-outline-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
