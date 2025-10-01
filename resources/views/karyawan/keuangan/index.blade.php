@extends('layout.karyawan-template')

@section('title', 'Laporan Keuangan')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row gy-6">

        <!-- Ringkasan Uang Kas -->
        <div class="col-md-12 col-lg-4">
            <div class="card">
                <div class="card-body text-nowrap">
                    <h5 class="card-title mb-0">Uang Kas</h5>
                    <p class="mb-2">Kantor</p>
                    <h4 class="text-primary mb-0">Rp{{ number_format($totalPendapatan - $totalPengeluaran, 0, ',', '.') }}</h4>
                </div>
                <img src="/image/icon-uang.png" class="position-absolute bottom-0 end-0 me-5 mb-5"
                     width="83" alt="kas" />
            </div>
        </div>

        <!-- Ringkasan Uang Masuk -->
        <div class="col-md-12 col-lg-4">
            <div class="card">
                <div class="card-body text-nowrap">
                    <h5 class="card-title mb-0">Uang Masuk</h5>
                    <p class="mb-2">Bulan ini</p>
                    <h4 class="text-success mb-0">Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>

        <!-- Ringkasan Uang Keluar -->
        <div class="col-md-12 col-lg-4">
            <div class="card">
                <div class="card-body text-nowrap">
                    <h5 class="card-title mb-0">Uang Keluar</h5>
                    <p class="mb-2">Bulan ini</p>
                    <h4 class="text-danger mb-0">Rp{{ number_format($totalPengeluaran, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>

        <!-- Tabel Transaksi Keuangan -->
        <div class="col-12 mt-4">
            <div class="card overflow-hidden">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Transaksi</h5>
                    <div>
                        <a href="{{ url('karyawan/keuangan/pengeluaran/create') }}" class="btn btn-danger btn-sm">
                            + Tambah Pengeluaran Kas
                        </a>
                        <a href="{{ url('karyawan/keuangan/kasbon/create') }}" class="btn btn-warning btn-sm">
                            + Tambah Kasbon
                        </a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th>Tanggal</th>
                                <th>Pengguna</th>
                                <th>Deskripsi</th>
                                <th>Jenis</th>
                                <th>Nominal</th>
                                <th>Metode</th>
                                <th>Bukti</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($laporanKeuangan as $laporan)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') }}</td>
                                    <td>{{ $laporan->pengguna->nama ?? '-' }}</td>
                                    <td>{{ $laporan->deskripsi }}</td>
                                    <td>
                                        @if ($laporan->tipe == 'pendapatan')
                                            <span class="badge bg-success">Pendapatan</span>
                                        @else
                                            <span class="badge bg-danger">Pengeluaran</span>
                                        @endif
                                    </td>
                                    <td class="{{ $laporan->tipe == 'pendapatan' ? 'text-success' : 'text-danger' }}">
                                        Rp{{ number_format($laporan->nominal, 0, ',', '.') }}
                                    </td>
                                    <td>{{ $laporan->metode_pembayaran }}</td>
                                    <td>
                                        @if ($laporan->bukti_transaksi)
                                            <a href="{{ asset('storage/'.$laporan->bukti_transaksi) }}" target="_blank">Lihat</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada data keuangan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
