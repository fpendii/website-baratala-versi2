@extends('layout.direktur-template')

@section('title', 'Daftar Karyawan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0">Daftar Karyawan</h5>
    <a href="#" class="btn btn-primary btn-sm">Tambah Karyawan</a>
</div>

@php
// Dummy data karyawan
$karyawan = [
    [
        'name' => 'Jordan Stevenson',
        'email' => 'susanna.Lind57@gmail.com',
        'role' => 'Admin',
        'status' => 'Active',
        'avatar' => '../assets/img/avatars/1.png'
    ],
    [
        'name' => 'Siti Rahma',
        'email' => 'siti.rahma@example.com',
        'role' => 'Editor',
        'status' => 'Active',
        'avatar' => '../assets/img/avatars/3.png'
    ],
    [
        'name' => 'Budi Santoso',
        'email' => 'budi.santoso@example.com',
        'role' => 'Author',
        'status' => 'Inactive',
        'avatar' => '../assets/img/avatars/5.png'
    ],
];
@endphp

<div class="card overflow-hidden">
    <div class="table-responsive">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Avatar</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($karyawan as $user)
                <tr>
                    <td>
                        <div class="avatar avatar-sm">
                            <img src="{{ $user['avatar'] }}" alt="Avatar" class="rounded-circle">
                        </div>
                    </td>
                    <td>{{ $user['name'] }}</td>
                    <td>{{ $user['email'] }}</td>
                    <td>{{ $user['role'] }}</td>
                    <td>
                        @if($user['status'] == 'Active')
                            <span class="badge bg-label-success rounded-pill">Active</span>
                        @else
                            <span class="badge bg-label-secondary rounded-pill">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <a href="#" class="btn btn-sm btn-primary">Detail</a>
                        <a href="#" class="btn btn-sm btn-warning">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
