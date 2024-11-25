@extends('layouts.frontend')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <h5 class="m-b-10">List of Jabatan</h5>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Jabatan List</h5>
                        <div class="float-right">
                            <a href="{{ route('jabatan.create') }}" class="btn btn-success btn-sm btn-round has-ripple"><i class="feather icon-plus"></i>Add Jabatan</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($jabatans->isEmpty())
                            <p>No jabatans found for your perusahaan.</p>
                        @else
                            <div class="table-responsive">
                                <table id="simpletable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Asuransi</th>
                                            <th>Gaji</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($jabatans as $jabatan)
                                            <tr>
                                                <td>{{ $jabatan->nama }}</td>
                                                <td>Rp{{ number_format($jabatan->asuransi, 0, ',', '.') }}</td>
                                                <td>Rp{{ number_format($jabatan->tarif_tetap, 0, ',', '.') }}</td>
                                                <td>
                                                    <a href="{{ route('jabatan.edit', $jabatan->id_jabatan) }}" class="btn btn-info btn-sm">
                                                        <i class="feather icon-edit"></i>&nbsp;Edit
                                                    </a>
                                                    <form id="delete-form-{{ $jabatan->id_jabatan }}" 
                                                          action="{{ route('jabatan.destroy', $jabatan->id_jabatan) }}" 
                                                          method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                                onclick="confirmDelete({{ $jabatan->id_jabatan }})">
                                                            <i class="feather icon-trash-2"></i>&nbsp;Delete
                                                        </button>
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
    function confirmDelete(jabatanId) {
        Swal.fire({
            title: 'Hapus data ini?',
            text: "Tindakan ini tidak bisa diubah!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus data ini!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form dengan ID yang sesuai
                document.getElementById('delete-form-' + jabatanId).submit();
            }
        });
    }
</script>
@endsection
