@extends('layout.app')

@section('title', 'Edit Surat Keluar')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 mb-0">
            <span class="text-muted fw-light">Surat Keluar /</span> Edit Data
        </h4>

        <a href="{{ route('surat-keluar.index') }}" class="btn btn-outline-secondary">
            <i class="icon-base ri ri-arrow-left-line icon-18px me-1"></i> Kembali
        </a>
    </div>

    {{-- ALERT VALIDASI --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Terjadi Kesalahan!</strong> Mohon periksa kembali input Anda.
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <h5 class="card-header">Formulir Edit Surat Keluar</h5>
        <div class="card-body">

            <form action="{{ route('surat-keluar.update', $surat_keluar->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Nomor Surat --}}
                <div class="mb-3">
                    <label class="form-label">Nomor Surat <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror"
                        name="nomor_surat" value="{{ old('nomor_surat', $surat_keluar->nomor_surat) }}" required>

                    @error('nomor_surat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tanggal Surat --}}
                <div class="mb-3">
                    <label class="form-label">Tanggal Surat <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('tgl_surat') is-invalid @enderror"
                        name="tgl_surat" value="{{ old('tgl_surat', $surat_keluar->tgl_surat) }}" required>

                    @error('tgl_surat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tujuan --}}
                <div class="mb-3">
                    <label class="form-label">Tujuan Surat <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('tujuan') is-invalid @enderror"
                        name="tujuan" value="{{ old('tujuan', $surat_keluar->tujuan) }}" required>

                    @error('tujuan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Jenis Surat --}}
                <div class="mb-3">
                    <label class="form-label">Jenis Surat <span class="text-danger">*</span></label>
                    <select class="form-select @error('jenis_surat') is-invalid @enderror" name="jenis_surat" required>
                        <option disabled>Pilih Jenis Surat</option>
                        <option value="umum" {{ old('jenis_surat', $surat_keluar->jenis_surat) == 'umum' ? 'selected' : '' }}>Umum</option>
                        <option value="keuangan" {{ old('jenis_surat', $surat_keluar->jenis_surat) == 'keuangan' ? 'selected' : '' }}>Keuangan</option>
                        <option value="operasional" {{ old('jenis_surat', $surat_keluar->jenis_surat) == 'operasional' ? 'selected' : '' }}>Operasional</option>
                    </select>

                    @error('jenis_surat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Perihal --}}
                <div class="mb-4">
                    <label class="form-label">Perihal <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('perihal') is-invalid @enderror" name="perihal" rows="5" required>{{ old('perihal', $surat_keluar->perihal) }}</textarea>

                    @error('perihal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Lampiran --}}
                <div class="mb-4">
                    <label class="form-label">Lampiran Surat (PDF / JPG / PNG)</label>

                    {{-- Jika sudah ada lampiran, tampilkan --}}
                    @if ($surat_keluar->lampiran)
                        <div class="mb-2">
                            <span class="badge bg-info">Lampiran saat ini:</span>
                            <a href="{{ asset('storage/' . $surat_keluar->lampiran) }}" target="_blank" class="ms-1 text-primary">
                                Lihat Lampiran
                            </a>
                        </div>
                    @endif

                    <input type="file" class="form-control @error('lampiran') is-invalid @enderror"
                        name="lampiran" accept=".pdf,.jpg,.jpeg,.png">

                    <small class="text-muted">Biarkan kosong jika tidak ingin mengganti lampiran.</small>

                    @error('lampiran')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn btn-primary me-2">
                    <i class="icon-base ri ri-refresh-line icon-18px me-1"></i> Update Surat
                </button>

                <button type="reset" class="btn btn-outline-secondary">Reset Formulir</button>

            </form>
        </div>
    </div>
@endsection
