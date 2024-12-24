@extends('layouts.frontend')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Edit Data Kehadiran</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('presensi.index') }}">Presensi</a></li>
                            <li class="breadcrumb-item">Edit Data Kehadiran</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Edit Data Kehadiran</h5>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('presensi.update', $date) }}">

                    @csrf
                    @method('PUT')

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attendance as $record)
                            <tr>
                                <td>{{ $record->karyawan->nama }}</td>
                                <td>
                                    <select name="status[{{ $record->id_karyawan }}]" class="form-control" required>
                                        <option value="hadir" @if($record->status == 'hadir') selected @endif>Hadir</option>
                                        <option value="izin" @if($record->status == 'izin') selected @endif>Izin</option>
                                        <option value="sakit" @if($record->status == 'sakit') selected @endif>Sakit</option>
                                        <option value="alpha" @if($record->status == 'alpha') selected @endif>Alpha</option>
                                        <option value="terlambat" @if($record->status == 'terlambat') selected @endif>Terlambat</option>
                                    </select>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection