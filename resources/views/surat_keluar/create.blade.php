@extends('layout.app')

@section('title', 'Tambah Surat Keluar Baru')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 mb-0">
            <span class="text-muted fw-light">Surat Keluar /</span> Tambah Data
        </h4>
        {{-- Tombol Kembali ke Daftar --}}
        <a href="{{ route('surat-keluar.index') }}" class="btn btn-outline-secondary">
            <i class="icon-base ri ri-arrow-left-line icon-18px me-1"></i> Kembali
        </a>
    </div>

    {{-- ALERT UNTUK PESAN VALIDASI GAGAL --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Terjadi Kesalahan!</strong> Mohon periksa kembali input Anda.
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <h5 class="card-header">Formulir Tambah Surat Keluar</h5>
        <div class="card-body">

            {{-- Formulir Tambah Data --}}
            {{-- Action mengarah ke route 'surat-keluar.store' untuk menyimpan data baru --}}
            <form action="{{ route('surat-keluar.store') }}" method="POST">
                @csrf

                {{-- Nomor Surat --}}
                <div class="mb-3">
                    <label for="nomor_surat" class="form-label">Nomor Surat <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror" id="nomor_surat"
                        name="nomor_surat" value="{{ old('nomor_surat') }}" placeholder="Contoh: B/123/XII/2025" required>
                    @error('nomor_surat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tanggal Surat --}}
                <div class="mb-3">
                    <label for="tgl_surat" class="form-label">Tanggal Surat <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('tgl_surat') is-invalid @enderror" id="tgl_surat"
                        name="tgl_surat" value="{{ old('tgl_surat') }}" required>
                    @error('tgl_surat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tujuan Surat --}}
                <div class="mb-3">
                    <label for="tujuan" class="form-label">Tujuan Surat <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('tujuan') is-invalid @enderror" id="tujuan"
                        name="tujuan" value="{{ old('tujuan') }}" placeholder="Contoh: Direktur Utama PT. Contoh Sejahtera"
                        required>
                    @error('tujuan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Jenis Surat (Dropdown) --}}
                <div class="mb-3">
                    <label for="jenis_surat" class="form-label">Jenis Surat <span class="text-danger">*</span></label>
                    <select class="form-select @error('jenis_surat') is-invalid @enderror" id="jenis_surat"
                        name="jenis_surat" required>
                        <option value="" disabled selected>Pilih Jenis Surat</option>
                        <option value="umum" {{ old('jenis_surat') == 'umum' ? 'selected' : '' }}>Umum</option>
                        <option value="keuangan" {{ old('jenis_surat') == 'keuangan' ? 'selected' : '' }}>Keuangan
                        </option>
                        <option value="operasional" {{ old('jenis_surat') == 'operasional' ? 'selected' : '' }}>
                            Operasional</option>
                        {{-- Tambahkan jenis lain sesuai kebutuhan --}}
                    </select>
                    @error('jenis_surat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Perihal (Isi/Deskripsi Surat) --}}
                <div class="mb-4">
                    <label for="perihal" class="form-label">Perihal (Isi Surat) <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('perihal') is-invalid @enderror" id="perihal" name="perihal" rows="5"
                        placeholder="Masukkan perihal atau ringkasan isi surat secara detail..." required>{{ old('perihal') }}</textarea>
                    @error('perihal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol Simpan --}}
                <button type="submit" class="btn btn-primary me-2">
                    <i class="icon-base ri ri-save-line icon-18px me-1"></i> Simpan Surat
                </button>
                {{-- Tombol Reset --}}
                <button type="reset" class="btn btn-outline-secondary">
                    Reset Formulir
                </button>

            </form>
        </div>
    </div>
@endsection
