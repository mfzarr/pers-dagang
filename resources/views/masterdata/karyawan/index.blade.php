@extends('layouts.frontend')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">List of Karyawan</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Karyawan</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Karyawan List</h5>
                        <a href="{{ route('karyawan.create') }}" class="btn btn-primary">Add Karyawan</a>
                    </div>
                    <div class="card-body">
                        @if($karyawans->isEmpty())
                            <p>No karyawan found for your perusahaan.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>No Telp</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Alamat</th>
                                            <th>Gaji Pokok</th>
                                            <th>Akun Sistem</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($karyawans as $karyawan)
                                            <tr>
                                                <td>{{ $karyawan->nama }}</td>
                                                <td>{{ $karyawan->email }}</td>
                                                <td>{{ $karyawan->no_telp }}</td>
                                                <td>{{ $karyawan->jenis_kelamin }}</td>
                                                <td>{{ $karyawan->alamat }}</td>
                                                <td>{{ number_format($karyawan->tarif_tetap, 0, ',', '.') }}</td>
                                                <td>
                                                    @if($karyawan->id_user)
                                                        <i class="fas fa-check-circle text-success"></i>
                                                    @else
                                                        <i class="fas fa-times-circle text-danger"></i>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('karyawan.edit', $karyawan->id_karyawan) }}" class="btn btn-warning">Edit</a>
                                                    <form action="{{ route('karyawan.destroy', $karyawan->id_karyawan) }}" method="POST" style="display:inline;">
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
