@extends('layout.direktur-template')

@section('title', 'Dashboard')

@section('content')
<div class="card">
    <div class="row">
        <div class="col">
            <h5 class="card-header">Jobdesk</h5>
        </div>
        <div class="col">
            <div class="card-header text-end">
                <a href="{{ url('/direktur/jobdesk/create') }}" class="btn btn-primary">
                    <i class="icon-base ri ri-add-line icon-18px me-1"></i>
                    Tambah
                </a>
            </div>
        </div>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Judul Jobdesk</th>
                    <th>Deskripsi</th>
                    <th>Divisi</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach($jobdesks as $index => $jobdesk)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $jobdesk->judul_jobdesk }}</td>
                    <td>{{ $jobdesk->deskripsi }}</td>
                    <td>{{ $jobdesk->divisi }}</td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow shadow-none"
                                data-bs-toggle="dropdown">
                                <i class="icon-base ri ri-more-2-line icon-18px"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ url('/direktur/jobdesk/'.$jobdesk->id.'/edit') }}">
                                    <i class="icon-base ri ri-pencil-line icon-18px me-1"></i>
                                    Edit
                                </a>
                                <form action="{{ url('/direktur/jobdesk/'.$jobdesk->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="dropdown-item text-danger" type="submit">
                                        <i class="icon-base ri ri-delete-bin-6-line icon-18px me-1"></i>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
