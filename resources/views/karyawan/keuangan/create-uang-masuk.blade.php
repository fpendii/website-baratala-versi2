@extends('layout.karyawan-template')

@section('title', 'Tambah Uang Kas')

@section('content')
    <div class="row">
        <div class="col-12">

            {{-- Alert Sukses --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            @endif

            {{-- Alert Error --}}
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            @endif

            {{-- Alert Validasi --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Tambah Pengeluaran Kas</h5>
                </div>
                <div class="card-body">
                    <form id="pengeluaranForm" action="{{ url('karyawan/keuangan/uang-masuk/store') }}" enctype="multipart/form-data" method="POST">
                        @csrf

                        <!-- Jenis Uang -->
                        <div class="mb-3">
                            <label for="jenis_uang" class="form-label">Jenis Uang</label>
                            <select class="form-select @error('jenis_uang') is-invalid @enderror" name="jenis_uang"
                                id="jenis_uang" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="kas" {{ old('jenis_uang') == 'kas' ? 'selected' : '' }}>Kas</option>
                                <option value="bank" {{ old('jenis_uang') == 'bank' ? 'selected' : '' }}>Bank</option>
                            </select>
                            @error('jenis_uang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tanggal -->
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal"
                                class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal') }}"
                                required>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Penerima -->
                        <div class="mb-3">
                            <label for="penerima" class="form-label">Penerima</label>
                            <select name="penerima" id="penerima"
                                class="form-select @error('penerima') is-invalid @enderror" required>
                                <option value="">-- Pilih Penerima --</option>
                                @foreach ($daftarKaryawan as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('penerima') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('penerima')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Keperluan -->
                        <div class="mb-3">
                            <label for="keperluan" class="form-label">Keperluan</label>
                            <textarea name="keperluan" id="keperluan" class="form-control @error('keperluan') is-invalid @enderror" rows="3"
                                placeholder="Keperluan pengeluaran" required>{{ old('keperluan') }}</textarea>
                            @error('keperluan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nominal -->
                        <div class="mb-3">
                            <label for="nominal" class="form-label">Nominal</label>
                            <input type="number" name="nominal" id="nominal"
                                class="form-control @error('nominal') is-invalid @enderror" placeholder="Masukkan nominal"
                                value="{{ old('nominal') }}" required>
                            @error('nominal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Lampiran -->
                        <div class="mb-3">
                            <label for="lampiran" class="form-label">Lampiran</label>
                            <input type="file" name="lampiran" id="lampiran"
                                class="form-control @error('lampiran') is-invalid @enderror" accept=".jpg,.jpeg,.png,.pdf">
                            <small class="text-muted">
                                Unggah berkas atau gambar terkait pengeluaran kas (misalnya nota atau bukti transfer).
                            </small>
                            @error('lampiran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ url('karyawan/keuangan') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-danger">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
