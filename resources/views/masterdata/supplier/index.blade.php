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
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('supplier.index') }}">Supplier</a></li>
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
                            <div class="float-right">
                                <a href="{{ route('supplier.create') }}"
                                    class="btn btn-success btn-sm btn-round has-ripple"><i class="feather icon-plus"></i>Add
                                    Supplier</a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if ($suppliers->isEmpty())
                                <p>No suppliers found for your perusahaan.</p>
                            @else
                                <div class="table-responsive">
                                    <table id="simpletable" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>No Telp</th>
                                                <th>Alamat</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($suppliers as $supplier)
                                                <tr>
                                                    <td>{{ $supplier->nama }}</td>
                                                    <td>{{ $supplier->no_telp }}</td>
                                                    <td>{{ $supplier->alamat }}</td>
                                                    <td>
                                                        @if ($supplier->status === 'Aktif')
                                                            <span class="badge badge-success">Aktif</span>
                                                        @else
                                                            <span class="badge badge-danger">Tidak Aktif</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('supplier.edit', $supplier->id_supplier) }}"
                                                            class="btn btn-info btn-sm"><i
                                                                class="feather icon-edit"></i>&nbsp;Edit</a>
                                                        <form id="delete-form-{{ $supplier->id_supplier }}"
                                                            action="{{ route('supplier.destroy', $supplier->id_supplier) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-sm btn-danger"
                                                                onclick="confirmDelete({{ $supplier->id_supplier }})"><i
                                                                    class="feather icon-trash-2"></i>&nbsp;Delete</button>
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
    <script>
        function confirmDelete(supplierId) {
            Swal.fire({
                title: 'Hapus data ini?',
                text: "Tindakan ini tidak bisa diubah!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus data ini!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form dengan id yang sesuai
                    document.getElementById('delete-form-' + supplierId).submit();
                }
            });
        }
    </script>

@endsection
