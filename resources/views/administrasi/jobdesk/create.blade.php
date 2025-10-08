@extends('layout.administrasi-template')

@section('title', 'Tambah Jobdesk')

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Jobdesk</h5>
        <small class="text-body-secondary float-end">Form Tambah Data Jobdesk</small>
    </div>
    <div class="card-body">
        <form action="{{ url('administrasi/jobdesk/store') }}" method="POST">
            @csrf

            {{-- FIELD: JUDUL JOBDESK --}}
            <div class="row mb-4">
                <label class="col-sm-2 col-form-label">Jobdesk</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="icon-base ri ri-task-line"></i></span>
                        <input
                            type="text"
                            class="form-control @error('judul_jobdesk') is-invalid @enderror"
                            name="judul_jobdesk"
                            placeholder="Masukkan Judul Jobdesk"
                            value="{{ old('judul_jobdesk') }}" {{-- Pertahankan input lama --}}
                            required
                        />
                        {{-- PESAN VALIDASI --}}
                        @error('judul_jobdesk')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- FIELD: DESKRIPSI --}}
            <div class="row mb-4">
                <label class="col-sm-2 col-form-label">Deskripsi</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="icon-base ri ri-file-text-line"></i></span>
                        <textarea
                            class="form-control @error('deskripsi') is-invalid @enderror"
                            name="deskripsi"
                            placeholder="Masukkan Deskripsi Jobdesk"
                            required>{{ old('deskripsi') }}</textarea>
                        {{-- PESAN VALIDASI --}}
                        @error('deskripsi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- FIELD: DIVISI --}}
            <div class="row mb-4">
                <label class="col-sm-2 col-form-label">Divisi</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="icon-base ri ri-group-line"></i></span>
                        <select
                            class="form-select @error('divisi') is-invalid @enderror"
                            name="divisi"
                            required
                        >
                            <option value="" disabled {{ old('divisi') == null ? 'selected' : '' }}>Pilih Divisi</option>
                            <option value="direktur" {{ old('divisi') == 'direktur' ? 'selected' : '' }}>Direktur</option>
                            <option value="kepala teknik" {{ old('divisi') == 'kepala teknik' ? 'selected' : '' }}>Kepala Teknik</option>
                            <option value="enginer" {{ old('divisi') == 'enginer' ? 'selected' : '' }}>Enginer</option>
                            <option value="produksi" {{ old('divisi') == 'produksi' ? 'selected' : '' }}>Produksi</option>
                            <option value="keuangan" {{ old('divisi') == 'keuangan' ? 'selected' : '' }}>Keuangan</option>
                        </select>
                        {{-- PESAN VALIDASI --}}
                        @error('divisi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row justify-content-end">
                <div class="col-sm-10">
                    <a href="{{ url('/administrasi/jobdesk') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
