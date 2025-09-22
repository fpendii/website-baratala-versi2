@extends('layout.direktur-template')

@section('title', 'Laporan Keuangan')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row gy-6">

        <!-- Ringkasan Keuangan -->
        <div class="col-md-12 col-lg-4">
            <div class="card">
                <div class="card-body text-nowrap">
                    <h5 class="card-title mb-0 flex-wrap text-nowrap">Total Pendapatan</h5>
                    <p class="mb-2">Bulan ini</p>
                    <h4 class="text-primary mb-0">Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</h4>
                    <p class="mb-2">Total Pengeluaran Rp{{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
                    <p class="mb-2">Laba Bersih Rp{{ number_format($labaBersih, 0, ',', '.') }}</p>
                </div>
                <img src="/image/icon-uang.png" class="position-absolute bottom-0 end-0 me-5 mb-5"
                     width="83" alt="pendapatan" />
            </div>
        </div>

        <!-- Tabel Transaksi Keuangan -->
        <div class="col-12">
            <div class="card overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-truncate">Tanggal</th>
                                <th class="text-truncate">Pengguna</th>
                                <th class="text-truncate">Deskripsi</th>
                                <th class="text-truncate">Jenis</th>
                                <th class="text-truncate">Nominal</th>
                                <th class="text-truncate">Metode</th>
                                <th class="text-truncate">Bukti</th>
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
