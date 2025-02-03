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
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('presensi.index') }}">Presensi</a></li>
                            <li class="breadcrumb-item active"><a>Edit Kehadiran</a></li>
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

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Status</th>
                                <th>Jam Masuk</th>
                                <th>Jam Keluar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attendance as $record)
                            <tr>
                                <td>{{ $record->karyawan->nama }}</td>
                                <td>
                                    <select name="status[{{ $record->id_karyawan }}]" class="form-control status-select" data-id="{{ $record->id_karyawan }}" required>
                                        <option value="hadir" @if($record->status == 'hadir') selected @endif>Hadir</option>
                                        <option value="izin" @if($record->status == 'izin') selected @endif>Izin</option>
                                        <option value="sakit" @if($record->status == 'sakit') selected @endif>Sakit</option>
                                        <option value="alpha" @if($record->status == 'alpha') selected @endif>Alpha</option>
                                        <option value="terlambat" @if($record->status == 'terlambat') selected @endif>Terlambat</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="time" name="jam_masuk[{{ $record->id_karyawan }}]" class="form-control jam-masuk" id="jam_masuk_{{ $record->id_karyawan }}" value="{{ $record->jam_masuk ? \Carbon\Carbon::parse($record->jam_masuk)->format('H:i') : '' }}">
                                </td>
                                <td>
                                    <input type="time" name="jam_keluar[{{ $record->id_karyawan }}]" class="form-control" value="{{ $record->jam_keluar ? \Carbon\Carbon::parse($record->jam_keluar)->format('H:i') : '' }}">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="{{ route('presensi.index') }}" class="btn btn-danger">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const statusSelects = document.querySelectorAll('.status-select');
        statusSelects.forEach(select => {
            select.addEventListener('change', function () {
                const id = this.getAttribute('data-id');
                const jamMasukInput = document.getElementById(`jam_masuk_${id}`);
                if (this.value === 'izin' || this.value === 'sakit' || this.value === 'alpha') {
                    jamMasukInput.value = '';
                } else {
                    jamMasukInput.disabled = false;
                }
            });

            // Trigger change event on page load to handle pre-selected values
            select.dispatchEvent(new Event('change'));
        });
    });
</script>
@endsection