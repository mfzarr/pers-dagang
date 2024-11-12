@extends('layouts.frontend')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">List of Supplier</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Supplier</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Supplier List</h5>
                        <a href="{{ route('supplier.create') }}" class="btn btn-primary">Add Supplier</a>
                    </div>
                    <div class="card-body">
                        @if($suppliers->isEmpty())
                            <p>No suppliers found for your perusahaan.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>No Telp</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($suppliers as $supplier)
                                            <tr>
                                                <td>{{ $supplier->nama }}</td>
                                                <td>{{ $supplier->alamat }}</td>
                                                <td>{{ $supplier->no_telp }}</td>
                                                <td>
                                                    <a href="{{ route('supplier.edit', $supplier->id_supplier) }}" class="btn btn-warning">Edit</a>
                                                    <form action="{{ route('supplier.destroy', $supplier->id_supplier) }}" method="POST" style="display:inline;">
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
