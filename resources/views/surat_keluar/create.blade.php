@extends('layout.app')

@section('title', 'Tambah Surat Keluar Baru')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 mb-0">
            <span class="text-muted fw-light">Surat Keluar /</span> Tambah Data
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
        <h5 class="card-header">Formulir Tambah Surat Keluar</h5>
        <div class="card-body">

            {{-- Tambah Surat --}}
            <form action="{{ route('surat-keluar.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Nomor Surat --}}
                <div class="mb-3">
                    <label class="form-label">Nomor Surat <span class="text-danger">*</span></label>

                    <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror" name="nomor_surat"
                        value="{{ old('nomor_surat', $nomor_surat ?? '') }}" required>

                    @error('nomor_surat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <input type="hidden" name="jenis_surat" value="{{ old('jenis_surat', $jenis ?? 'umum') }}">

                {{-- Tanggal Surat --}}
                <div class="mb-3">
                    <label class="form-label">Tanggal Surat <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('tgl_surat') is-invalid @enderror" name="tgl_surat"
                        value="{{ old('tgl_surat') }}" required>
                    @error('tgl_surat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tujuan --}}
                <div class="mb-3">
                    <label class="form-label">Tujuan Surat <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('tujuan') is-invalid @enderror" name="tujuan"
                        value="{{ old('tujuan') }}" placeholder="Contoh: Direktur Utama PT. Contoh Sejahtera" required>
                    @error('tujuan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>



                {{-- PERIHAL (ISI SURAT) DENGAN TINYMCE (TEMPLATIZED) --}}
                <div class="mb-4">
                    <label class="form-label">Perihal (Isi Surat) <span
                            class="text-danger">*</span></label>

                    <textarea class="form-control @error('perihal') is-invalid @enderror" rows="15" name="perihal" id="isi_surat"
                        required>
{{ old(
    'perihal',
    '
<div style="display: flex; align-items: center; border-bottom: 2px solid black; padding-bottom: 10px; margin-bottom: 15px;">
    <img src="' .
        asset('image/logo.png') .
        '" alt="Logo Perusahaan" style="width: 80px; height: auto; margin-right: 20px;">
    <div style="flex-grow: 1; text-align: center;">
        <p style="margin: 0; font-weight: bold; font-size: 14pt;">PERUSAHAAN DAERAH BARATALA TUNTUNG PANDANG</p>
        <p style="margin: 0; font-size: 10px;">Jl. Abadi No. 03 Pelaihari 70811 Telp/Fax. 0512-23445</p>
        <p style="margin: 0; font-size: 10px;">e-mail : perusda_baratala@yahoo.com</p>
    </div>
</div>

<div style="text-align: center; margin-bottom: 20px;">
    <strong>SURAT PERMOHONAN</strong><br>
    Nomor : BTTP- 1.058/Ops/XII/2025
</div>

Kepada Yth.<br>
<strong>Direktorat Jendral Minerba</strong><br>
<strong>Kementerian Energi dan Sumber Daya Mineral</strong><br>
<strong>Republik Indonesia</strong><br>
Di –<br>
&nbsp; &nbsp; &nbsp; &nbsp; Tempat<br>
<br>

Dengan hormat,<br><br>
<p style="border: 2px solid #ccc; padding: 15px; background-color: #f9f9f9;">
    Sehubungan dengan telah selesainya Uji Kompetensi pada tanggal 15 Agustus 2025, disampaikan permohonan untuk memperoleh kesempatan kembali dalam melakukan pengajuan pengesahan KTT definitif melalui sistem Perizinan Online Minerba.
    <br><br>
    Permohonan ini diajukan agar proses pengesahan dapat dilanjutkan sesuai ketentuan yang berlaku melalui Website Perizinan Online Minerba Kementerian ESDM RI.
</p>
<br>
Demikian surat permohonan ini disampaikan. Atas perhatian dan kebijaksanaan yang diberikan disampaikan terima kasih.<br><br>

<div style="margin-top: 30px;">
    Pelaihari, 3 Desember 2025<br>
    Hormat kami,<br><br><br><br>
    <p style="margin-bottom: 0;"><strong>H.Ihsanudin SH., MH</strong></p>
    Direktur Utama
</div>
',
) }}
                    </textarea>
                    @error('perihal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>
                {{-- Isi Surat Lengkap (EDITOR WORD) --}}
                {{-- <div class="mb-4">
                    <label class="form-label">Isi Surat Lengkap <span class="text-danger">*</span></label>

                    <textarea id="editor" class="form-control @error('isi_surat') is-invalid @enderror" name="isi_surat" rows="12"
                        required>{{ old('isi_surat') }}</textarea>

                    @error('isi_surat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div> --}}



                {{-- Lampiran Surat (FILE UPLOAD) --}}
                <div class="mb-4">
                    <label class="form-label">Lampiran Surat (PDF / JPG / PNG)</label>
                    <input type="file" class="form-control @error('lampiran') is-invalid @enderror" name="lampiran"
                        accept=".pdf,.jpg,.jpeg,.png">
                    <small class="text-muted">Opsional — unggah file surat jika tersedia.</small>
                    @error('lampiran')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Buttons --}}
                <button type="submit" class="btn btn-primary me-2">
                    <i class="icon-base ri ri-save-line icon-18px me-1"></i> Simpan Surat
                </button>

                <button type="reset" class="btn btn-outline-secondary">Reset Formulir</button>

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
                plugins: 'advlist autolink lists link image charmap print preview anchor code paste', // Tambahkan 'code' dan 'paste'
                toolbar_mode: 'floating',
                // Toolbar disederhanakan karena format utama sudah ditetapkan
                toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | numlist bullist | code',

                height: 600,
                menubar: false,

                // Mengatur style untuk konten editor
                content_style: 'body { font-family:Times New Roman,Times,serif; font-size:12pt; line-height: 1.5; margin: 30px; }',

                // Mengizinkan elemen HTML yang lebih kompleks (seperti DIV dan Style)
                extended_valid_elements: "div[style],p[style],hr[style],strong[style]",

                // Memungkinkan editing langsung pada area yang ditandai dengan kotak abu-abu
                setup: function(editor) {
                    editor.on('init', function() {
                        // Fokuskan kursor langsung ke area konten utama (opsional)
                        // editor.focus();
                    });
                }
            });
        });
    </script>
@endpush
