@extends('layouts.frontend')

@section('content')
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">List of Presensi</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('presensi.index') }}">Presensi</a></li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Presensi List</h5>
                            <div class="float-right">
                                <a href="{{ route('presensi.create') }}"
                                    class="btn btn-success btn-sm btn-round has-ripple"><i class="feather icon-plus"></i>Add
                                    Karyawan</a>
                            </div>
                        </div>
                        <div class="card-body">
                            {{-- @if ($karyawans->isEmpty())
                                <p>No karyawan found for your perusahaan.</p>
                            @else --}}
                            <div class="table-responsive">
                                <table id="simpletable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Hadir</th>
                                            <th>Sakit</th>
                                            <th>Izin</th>
                                            <th>Alpha</th>
                                            <th>Terlambat</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($attendanceSummary as $date => $summary)
                                            <tr>
                                                <td>{{ $date }}</td>
                                                <td>{{ $summary['hadir'] }}</td>
                                                <td>{{ $summary['sakit'] }}</td>
                                                <td>{{ $summary['izin'] }}</td>
                                                <td>{{ $summary['alpha'] }}</td>
                                                <td>{{ $summary['terlambat'] }}</td>
                                                <td>
                                                    <a href="{{ route('presensi.show', $date) }}"
                                                        class="btn btn-icon btn-outline-primary"><i
                                                            class="feather icon-eye"></i>
                                                    </a>
                                                    <a href="{{ route('presensi.edit', $date) }}"
                                                        class="btn btn-icon btn-outline-success"><i
                                                            class="feather icon-edit"></i>
                                                    </a>
                                                    <form id="delete-form-{{ $date }}"
                                                        action="{{ route('presensi.destroy', $date) }}" method="POST"
                                                        style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-icon btn-outline-danger">
                                                            <i class="feather icon-trash-2"></i>
                                                        </button>
                                                    </form>
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
        </div>
    </div>

    {{-- <script>
        function confirmDelete(date) {
            var form = document.getElementById('delete-form-' + date);
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script> --}}
@endsection
