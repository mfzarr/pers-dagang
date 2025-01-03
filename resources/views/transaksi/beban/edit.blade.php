@extends('layouts.frontend')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Edit Pengeluaran Beban</h5>
                        </div>
                        <ul class="breadcrumb">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('beban.index') }}">Pengeluaran Beban</a></li>
                                <li class="breadcrumb-item"><a>Edit Beban</a></li>
                            </ul> 
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Form Edit Beban</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('beban.update', $beban->id_beban) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nama_beban">Nama Beban</label>
                        <input type="text" name="nama_beban" id="nama_beban" value="{{ old('nama_beban', $beban->nama_beban) }}" class="form-control" required>
                        @error('nama_beban')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" name="harga" id="harga" value="{{ old('harga', $beban->harga) }}" class="form-control" required>
                        @error('harga')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', $beban->tanggal) }}" class="form-control" required>
                        @error('tanggal')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="id_coa">Akun Beban</label>
                        <select name="id_coa" id="id_coa" class="form-control" required>
                            @foreach($coa as $akun)
                            <option value="{{ $akun->id_coa }}" {{ old('id_coa', $beban->id_coa) == $akun->id_coa ? 'selected' : '' }}>
                                {{ $akun->nama_akun }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_coa')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
