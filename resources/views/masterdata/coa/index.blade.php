@extends('layouts.frontend')

@section('content')
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <!-- Breadcrumb Section -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Data COA</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                            class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('coa.index') }}">COA</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Breadcrumb Section -->

            <!-- COA Data Display Section -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Data COA</h5>
                            <div class="float-right">
                                <a href="{{ route('coa.create') }}" class="btn btn-success btn-sm btn-round has-ripple"><i
                                        class="feather icon-plus"></i>Tambah COA</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="dt-responsive table-responsive">
                                <table id="simpletable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID Akun</th>
                                            <th>Nama Akun</th>
                                            <th>Nama Kelompok Akun</th>
                                            <th>Posisi</th>
                                            <th>Saldo Awal</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($coas as $coa)
                                            <tr>
                                                <td>{{ $coa->kode_akun }}</td>
                                                <td>{{ $coa->nama_akun }}</td>
                                                <td>{{ $coa->kelompokakun->nama_kelompok_akun }}</td>
                                                <td>{{ $coa->posisi_d_c }}</td>
                                                <td>{{ $coa->saldo_awal }}</td>
                                                <td>
                                                    @if ($coa->status !== 'seeder')
                                                        <a href="{{ route('coa.edit', $coa->id_coa) }}"
                                                            class="btn btn-info btn-sm"><i
                                                                class="feather icon-edit"></i>&nbsp;Edit</a>
                                                        <form action="{{ route('coa.destroy', $coa->id_coa) }}"
                                                            method="POST" class="d-inline"
                                                            id="delete-form-{{ $coa->id_coa }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-sm btn-danger"
                                                                onclick="confirmDelete({{ $coa->id_coa }})"><i
                                                                    class="feather icon-trash-2"></i>&nbsp;Delete</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of COA Data Display Section -->
        </div>
    </div>
    <script>
        function confirmDelete(coaId) {
            Swal.fire({
                title: 'hapus data ini?',
                text: "tindakan ini tidak bisa di ubah!!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ya, hapus data ini!',
                cancelButtonText: 'batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + coaId).submit();
                }
            });
        }
    </script>
@endsection
