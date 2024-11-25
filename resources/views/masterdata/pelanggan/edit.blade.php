@extends('layouts.frontend')

@section('content')
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Edit Pelanggan</h5>
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
                            <h5>Edit Pelanggan</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('pelanggan.update', $pelanggan->id_pelanggan) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        value="{{ $pelanggan->nama }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ $pelanggan->email }}">
                                </div>
                                <div class="form-group">
                                    <label for="no_telp">No Telp</label>
                                    <input type="number" class="form-control" id="no_telp" name="no_telp"
                                        value="{{ $pelanggan->no_telp }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                        <option value="Laki-Laki"
                                            {{ $pelanggan->jenis_kelamin == 'Laki-Laki' ? 'selected' : '' }}>Laki-laki
                                        </option>
                                        <option value="Perempuan"
                                            {{ $pelanggan->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tgl_daftar">Tanggal Daftar</label>
                                    <input type="date" class="form-control" id="tgl_daftar" name="tgl_daftar"
                                        value="{{ $pelanggan->tgl_daftar }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat" required>{{ $pelanggan->alamat }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="Aktif" {{ $pelanggan->status == 'Aktif' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="Tidak Aktif"
                                            {{ $pelanggan->status == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <a href="{{ route('pelanggan.index') }}" class="btn btn-danger">Back</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
