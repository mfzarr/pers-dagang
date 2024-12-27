@extends('layouts.frontend')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Tambah Pengeluaran Beban</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('beban.index') }}">Pengeluaran Beban</a></li>
                            <li class="breadcrumb-item"><a>Tambah Beban</a></li>
                        </ul> 
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Form Tambah Beban</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('beban.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nama_beban">Nama Beban</label>
                        <input type="text" name="nama_beban" id="nama_beban" class="form-control @error('nama_beban') is-invalid @enderror" required>
                        @error('nama_beban')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" name="harga" id="harga" class="form-control @error('harga') is-invalid @enderror" required>
                        @error('harga')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror" required>
                        @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="id_coa">Akun Beban</label>
                        <select name="id_coa" id="id_coa" class="form-control @error('id_coa') is-invalid @enderror" required>
                            <option value="">Pilih Akun</option>
                            @foreach($coa as $akun)
                            <option value="{{ $akun->id_coa }}">{{ $akun->nama_akun }}</option>
                            @endforeach
                        </select>
                        @error('id_coa')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="id_perusahaan">Perusahaan</label>
                        <input type="hidden" name="id_perusahaan" id="id_perusahaan" value="{{ auth()->user()->id_perusahaan }}" class="form-control" readonly>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
