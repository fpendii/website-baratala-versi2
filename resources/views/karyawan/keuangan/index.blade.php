@extends('layout.karyawan-template')

@section('title', 'Laporan Keuangan')

@section('content')
    <div class="row gy-6">

        <!-- Ringkasan Uang Kas -->
        <div class="col-md-12 col-lg-4">
            <div class="card">
                <div class="card-body text-nowrap">
                    <h5 class="card-title mb-0">Uang Kas</h5>
                    <p class="mb-2">Kantor</p>
                    <h4 class="text-primary mb-0">Rp{{ number_format($uangKas->nominal, 0, ',', '.') }}</h4>
                </div>
                <img src="/image/icon-uang.png" class="position-absolute bottom-0 end-0 me-5 mb-5" width="83"
                    alt="kas" />
            </div>
        </div>

        <!-- Ringkasan Uang Masuk -->
        <div class="col-md-12 col-lg-4">
            <div class="card">
                <div class="card-body text-nowrap">
                    <h5 class="card-title mb-0">Uang Masuk</h5>
                    <p class="mb-2">Bulan ini</p>
                    <h4 class="text-success mb-0">Rp</h4>
                </div>
            </div>
        </div>

        <!-- Ringkasan Uang Keluar -->
        <div class="col-md-12 col-lg-4">
            <div class="card">
                <div class="card-body text-nowrap">
                    <h5 class="card-title mb-0">Uang Keluar</h5>
                    <p class="mb-2">Bulan ini</p>
                    <h4 class="text-danger mb-0">Rp{{ number_format($uangKeluar, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>

        <!-- Tabel Transaksi Keuangan -->
        <div class="col-12 mt-4">
            <div class="card overflow-hidden">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Daftar Transaksi</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ url('keuangan/export') }}" class="btn btn-outline-success btn-sm">
                            Export Excel
                        </a>
                        <a href="{{ url('karyawan/keuangan/pengeluaran/create') }}" class="btn btn-danger btn-sm">
                            + Pengeluaran Kas
                        </a>
                        <a href="{{ url('karyawan/keuangan/kasbon/create') }}" class="btn btn-warning btn-sm">
                            + Kasbon
                        </a>
                        <a href="{{ url('karyawan/keuangan/uang-masuk/create') }}" class="btn btn-success btn-sm">
                            + Uang Masuk
                        </a>
                    </div>
                </div>

                <div class="container">
                    <!-- Filter Transaksi -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <form action="{{ url('karyawan/keuangan') }}" method="GET" class="row g-2 align-items-end">
                                <div class="col-md-3">
                                    <label for="filter_tanggal" class="form-label">Tanggal</label>
                                    <input type="month" name="filter_tanggal" id="filter_tanggal" class="form-control"
                                        value="{{ request('filter_tanggal') }}">
                                </div>

                                <div class="col-md-3">
                                    <label for="filter_jenis" class="form-label">Jenis</label>
                                    <select name="filter_jenis" id="filter_jenis" class="form-select">
                                        <option value="">-- Semua Jenis --</option>
                                        <option value="uang_masuk"
                                            {{ request('filter_jenis') == 'uang_masuk' ? 'selected' : '' }}>Uang Masuk
                                        </option>
                                        <option value="pengeluaran"
                                            {{ request('filter_jenis') == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran
                                        </option>
                                        <option value="kasbon" {{ request('filter_jenis') == 'kasbon' ? 'selected' : '' }}>
                                            Kasbon</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="filter_pengguna" class="form-label">Penerima</label>
                                    <select name="filter_pengguna" id="filter_pengguna" class="form-select">
                                        <option value="">-- Semua Karyawan --</option>
                                        @foreach ($daftarKaryawan as $karyawan)
                                            <option value="{{ $karyawan->id }}"
                                                {{ request('filter_pengguna') == $karyawan->id ? 'selected' : '' }}>
                                                {{ $karyawan->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 d-flex align-items-end justify-content-end">
                                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
                <div class="table-responsive">

                    <table class="table table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th>Tanggal</th>
                                <th>Pengguna</th>
                                <th>Keperluan</th>
                                <th>Jenis</th>
                                <th>Nominal</th>
                                <th>Metode</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($laporanKeuangan as $laporan)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') }}</td>
                                    <td>{{ $laporan->pengguna->nama ?? '-' }}</td>
                                    <td>{{ $laporan->keperluan }}</td>
                                    <td>
                                        @switch($laporan->jenis)
                                            @case('uang_masuk')
                                                <span class="badge bg-success">Pemasukan</span>
                                            @break

                                            @case('pengeluaran')
                                                <span class="badge bg-danger">Pengeluaran</span>
                                            @break

                                            @default
                                                <span class="badge bg-warning">Kasbon</span>
                                        @endswitch
                                    </td>

                                    <td class="{{ $laporan->tipe == 'pendapatan' ? 'text-success' : 'text-danger' }}">
                                        Rp{{ number_format($laporan->nominal, 0, ',', '.') }}
                                    </td>
                                    <td>{{ ucfirst($laporan->jenis_uang) }}</td>
                                    <td>
                                        @if ($laporan->bukti_transaksi)
                                            <a href="{{ asset('storage/' . $laporan->bukti_transaksi) }}"
                                                target="_blank">Lihat</a>
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
                        <div class="container">
                            <div class="d-flex justify-content-end mt-3">
                                {{ $laporanKeuangan->links('pagination::bootstrap-5') }}
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    @endsection
