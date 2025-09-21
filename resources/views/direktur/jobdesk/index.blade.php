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
                        <th>Jobdesk</th>
                        <th>Desksripsi</th>
                        <th>Divisi</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <tr>
                        <td>
                            1 .
                            <span>Tours Project</span>
                        </td>
                        <td>Albert Cook</td>
                        <td>
                            <span>Tours Project</span>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow shadow-none"
                                    data-bs-toggle="dropdown">
                                    <i class="icon-base ri ri-more-2-line icon-18px"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ url('/direktur/jobdesk/edit/1') }}">
                                        <i class="icon-base ri ri-pencil-line icon-18px me-1"></i>
                                        Edit</a>
                                    <a class="dropdown-item" href="{{ url('/direktur/jobdesk/delete/1') }}">
                                        <i class="icon-base ri ri-delete-bin-6-line icon-18px me-1"></i>
                                        Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @endsection
