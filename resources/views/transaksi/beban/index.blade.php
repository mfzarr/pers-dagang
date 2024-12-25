@extends('layouts.frontend')

@section('content')
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">List of Beban</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                            class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#!">Beban</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5>Beban List</h5>
                    <div class="float-right">
                        <a href="{{ route('beban.create') }}" class="btn btn-success btn-sm btn-round has-ripple"><i
                                class="feather icon-plus"></i>Add
                            Beban</a>
                    </div>
                </div>
                <div class="card-body">
                    @if ($beban->isEmpty())
                        <p>No bebans found for your perusahaan.</p>
                    @else
                        <div class="table-responsive">
                            <table id="simpletable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Beban</th>
                                        <th>Harga</th>
                                        <th>Tanggal</th>
                                        <th>Kode Akun</th>
                                        <th>Nama Akun</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($beban as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nama_beban }}</td>
                                            <td>{{ number_format($item->harga, 2) }}</td>
                                            <td>{{ $item->tanggal }}</td>
                                            <td>{{ $item->coa->kode_akun }}</td>
                                            <td>{{ $item->coa->nama_akun }}</td>
                                            <td>
                                                <a href="{{ route('beban.edit', $item->id_beban) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="feather icon-edit"></i>&nbsp;Edit
                                                </a>
                                                <form id="delete-form-{{ $item->id_beban }}"
                                                    action="{{ route('beban.destroy', $item->id_beban) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="confirmDelete({{ $item->id_beban }})">
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

    <script>
        function confirmDelete(bebanId) {
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
                    document.getElementById('delete-form-' + bebanId).submit();
                }
            });
        }
    </script>
@endsection
