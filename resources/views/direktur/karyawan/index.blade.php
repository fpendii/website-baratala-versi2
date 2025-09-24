@extends('layout.direktur-template')

@section('title', 'Daftar Karyawan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">Daftar Karyawan</h5>
    <a href="{{ route('direktur.karyawan.create') }}" class="btn btn-primary">Tambah Karyawan</a>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card overflow-hidden">
    <div class="table-responsive">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No. HP</th>
                    <th>Alamat</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($karyawan as $user)
                <tr>
                    <td>{{ $user->nama }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->no_hp }}</td>
                    <td>{{ $user->alamat }}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('direktur.karyawan.show', $user->id) }}" class="btn btn-sm btn-info">Detail</a>
                            <a href="{{ route('direktur.karyawan.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('direktur.karyawan.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer d-flex justify-content-center">
        {{ $karyawan->links() }}
    </div>
</div>
@endsection
