@extends('layouts.frontend')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Data from Table: {{ ucfirst($table) }}</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Data Table</a></li>
                            <li class="breadcrumb-item"><a href="#!">Basic Initialization</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- DataTable for COA -->
            <div class="col-sm-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Data {{ ucfirst($table) }}</h5>
                        <div class="card-header-right">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#addmodal">Tambah Data</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="dt-responsive table-responsive">
                            <table id="userAccessMenuTable" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>Kelompok Akun</th>
                                        <th>Nama Kelompok Akun</th>
                                        <th>Header Akun</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($coaKelompoks as $item)
                                    <tr>
                                        <td>{{ $item->kelompok_akun }}</td>
                                        <td>{{ $item->nama_kelompok_akun }}</td>
                                        <td>{{ $item->header_akun }}</td>
                                        <!-- <td>{{ $item->nama }}</td> -->
                                        <td>
                                            <!-- Tombol Edit -->
                                            <button type="button" class="btn btn-warning edit-button" data-toggle="modal" data-target="#editmodal" data-id="{{ $item->id_coa }}">
                                                Edit
                                            </button>
                                        </td>
                                        <td>
                                            <!-- Tombol Delete -->
                                            <button type="button" class="btn btn-outline-danger delete-button" data-toggle="modal" data-target="#deletemodal" data-id="{{ $item->id_coa }}">
                                                Delete
                                            </button>
                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-right mt-3">
                            <!-- Align "Kembali" button to the right and link it to the dashboard -->
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- DataTable for COA end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>

<!-- Modal includes -->
@include('masterdata/' . $table . '/modal')
@include('masterdata/' . $table . '/edit')
@include('masterdata/' . $table . '/delete')
@endsection