@extends('layouts.frontend')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">List of Pelanggan</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Pelanggan</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Pelanggan List</h5>
                        <a href="{{ route('pelanggan.create') }}" class="btn btn-primary">Add Pelanggan</a>
                    </div>
                    <div class="card-body">
                        @if($pelanggans->isEmpty())
                            <p>No pelanggan found for your perusahaan.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>No Telp</th>
                                            <th>Alamat</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pelanggans as $pelanggan)
                                            <tr>
                                                <td>{{ $pelanggan->nama }}</td>
                                                <td>{{ $pelanggan->email }}</td>
                                                <td>{{ $pelanggan->no_telp }}</td>
                                                <td>{{ $pelanggan->alamat }}</td>
                                                <td>
                                                    <a href="{{ route('pelanggan.edit', $pelanggan->id_pelanggan) }}" class="btn btn-warning">Edit</a>
                                                    <form action="{{ route('pelanggan.destroy', $pelanggan->id_pelanggan) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
