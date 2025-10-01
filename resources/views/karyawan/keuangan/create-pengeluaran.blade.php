@extends('layout.karyawan-template')

@section('title', 'Tambah Pengeluaran Kas')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Tambah Pengeluaran Kas</h5>
                </div>
                <div class="card-body">
                    <form id="pengeluaranForm" action="{{ url('karyawan/pengeluaran/store') }}" method="POST">
                        @csrf

                        <!-- Jenis Uang -->
                        <div class="mb-3">
                            <label for="jenis_uang" class="form-label">Jenis Uang</label>
                            <select class="form-select" name="jenis_uang" id="jenis_uang" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="kas">Kas</option>
                                <option value="bank">Bank</option>
                            </select>
                        </div>

                        <!-- Tanggal -->
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                        </div>

                        <!-- Penerima -->
                        <div class="mb-3">
                            <label for="penerima" class="form-label">Penerima</label>
                            <select name="penerima" id="penerima" class="form-select" required>
                                <option value="">-- Pilih Penerima --</option>
                                @foreach ($daftarKaryawan as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Keperluan -->
                        <div class="mb-3">
                            <label for="keperluan" class="form-label">Keperluan</label>
                            <textarea name="keperluan" id="keperluan" class="form-control" rows="3"
                                placeholder="Keperluan pengeluaran" required></textarea>
                        </div>

                        <!-- Nominal -->
                        <div class="mb-3">
                            <label for="nominal" class="form-label">Nominal</label>
                            <input type="number" name="nominal" id="nominal" class="form-control"
                                placeholder="Masukkan nominal" required>
                        </div>

                        <!-- Hidden field untuk opsi -->
                        <input type="hidden" name="status_persetujuan" id="status_persetujuan">

                        <div class="d-flex justify-content-between">
                            <a href="{{ url('karyawan/keuangan') }}" class="btn btn-secondary">Kembali</a>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#konfirmasiModal">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="konfirmasiModal" tabindex="-1" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="konfirmasiModalLabel">Konfirmasi Pengeluaran Kas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    Pilih opsi kebijakan keuangan untuk pengeluaran kas ini:
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="submitForm('kebijakan')">Kebijakan Keuangan</button>
                    <button type="button" class="btn btn-danger" onclick="submitForm('persetujuan')">Membutuhkan Persetujuan Direktur</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function submitForm(opsi) {
            document.getElementById('status_persetujuan').value = opsi;
            document.getElementById('pengeluaranForm').submit();
        }
    </script>
@endsection
