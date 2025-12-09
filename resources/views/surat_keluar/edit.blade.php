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
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>Terjadi Kesalahan!</strong> Mohon periksa input Anda.
            <ul class="mt-2 mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <h5 class="card-header">Formulir Edit Surat Keluar</h5>
        <div class="card-body">

            <form action="{{ route('surat-keluar.update', $surat->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Nomor Surat --}}
                <div class="mb-3">
                    <label class="form-label">Nomor Surat</label>
                    <input type="text" id="nomor_surat" class="form-control @error('nomor_surat') is-invalid @enderror"
                        name="nomor_surat" value="{{ old('nomor_surat', $surat->nomor_surat) }}" required>
                    @error('nomor_surat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Jenis Surat --}}
                <input type="hidden" name="jenis_surat" value="{{ $surat->jenis_surat }}">

                {{-- Tanggal Surat --}}
                <div class="mb-3">
                    <label class="form-label">Tanggal Surat</label>
                    <input type="date" id="tgl_surat" class="form-control @error('tgl_surat') is-invalid @enderror"
                        name="tgl_surat"
                        value="{{ old('tgl_surat', \Carbon\Carbon::parse($surat->tgl_surat)->format('Y-m-d')) }}" required>

                    @error('tgl_surat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tujuan --}}
                <div class="mb-3">
                    <label class="form-label">Tujuan Surat</label>
                    <input type="text" class="form-control @error('tujuan') is-invalid @enderror" name="tujuan"
                        value="{{ old('tujuan', $surat->tujuan) }}" required>
                    @error('tujuan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Perihal --}}
                <div class="mb-3">
                    <label class="form-label">Perihal Surat</label>
                    <input type="text" class="form-control @error('perihal') is-invalid @enderror" name="perihal"
                        value="{{ old('perihal', $surat->perihal) }}" required>
                    @error('perihal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Pilih Metode Input Surat --}}
                <div class="mb-3">
                    <label class="form-label">Metode Input Surat</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="metode_input" id="metodeForm" value="form"
                            {{ old('metode_input', $surat->dok_surat ? 'upload' : 'form') == 'form' ? 'checked' : '' }}>
                        <label class="form-check-label" for="metodeForm">
                            Buat Surat di Form
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="metode_input" id="metodeUpload" value="upload"
                            {{ old('metode_input', $surat->dok_surat ? 'upload' : 'form') == 'upload' ? 'checked' : '' }}>
                        <label class="form-check-label" for="metodeUpload">
                            Upload Dokumen Surat (PDF)
                        </label>
                    </div>
                </div>

                {{-- Upload Dokumen --}}
                <div class="mb-4" id="uploadContainer"
                    style="display: {{ old('metode_input', $surat->dok_surat ? 'upload' : 'form') == 'upload' ? 'block' : 'none' }};">
                    <label class="form-label">Upload Dokumen Surat (PDF)</label>
                    <input type="file" name="lampiran" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                    @if ($surat->lampiran)
                        <small class="text-muted">Lampiran saat ini: <a href="{{ asset('storage/' . $surat->lampiran) }}"
                                target="_blank">Lihat</a></small>
                    @endif
                </div>



                {{-- Isi Surat --}}
                <div class="mb-4">
                    <label class="form-label">Isi Surat Lengkap</label>
                    <textarea id="isi_surat" name="konten_surat" class="form-control @error('konten_surat') is-invalid @enderror"
                        rows="20"
                        style="display: {{ old('metode_input', $surat->dok_surat ? 'upload' : 'form') == 'form' ? 'block' : 'none' }};">{{ old('konten_surat', $surat->konten_surat) }}</textarea>

                    @error('konten_surat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Buttons --}}
                <button type="submit" class="btn btn-primary me-2">
                    <i class="ri ri-save-line me-1"></i> Update Surat
                </button>

                <a href="{{ route('surat-keluar.index') }}" class="btn btn-outline-secondary">
                    Batal
                </a>

            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            tinymce.init({
                selector: '#isi_surat',
                plugins: 'advlist autolink lists link image charmap print preview anchor code paste',
                toolbar_mode: 'floating',
                toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | numlist bullist | code',
                height: 600,
                menubar: false,
                content_style: 'body { font-family:Times New Roman,Times,serif; font-size:12pt; line-height: 1.5; margin: 30px; }',
                extended_valid_elements: "div[style],p[style],hr[style],strong[style],span[id]",

                setup: function(editor) {
                    editor.on('init', function() {

                        const tglInput = document.getElementById('tgl_surat');
                        const nomorInput = document.getElementById('nomor_surat');

                        function updateIsiSurat() {
                            let content = editor.getContent();

                            // === Update Tanggal Surat ===
                            let tgl = new Date(tglInput.value);
                            if (!isNaN(tgl)) {
                                const options = {
                                    year: 'numeric',
                                    month: 'long',
                                    day: 'numeric'
                                };
                                const tglFormatted = tgl.toLocaleDateString('id-ID', options);

                                content = content.replace(/Pelaihari,\s*.*?<br>/,
                                    `Pelaihari, ${tglFormatted}<br>`);
                            }

                            // === Update Nomor Surat ===
                            const nomorVal = nomorInput.value || '';
                            content = content.replace(
                                /<span id="nomor_surat_text">.*?<\/span>/,
                                `<span id="nomor_surat_text">${nomorVal}</span>`
                            );

                            editor.setContent(content);
                        }

                        // Update pertama kali saat halaman dibuka
                        updateIsiSurat();

                        // Update ketika user mengubah tanggal atau nomor surat
                        tglInput.addEventListener('change', updateIsiSurat);
                        nomorInput.addEventListener('input', updateIsiSurat);
                    });
                }
            });
        });
    </script>
@endpush
