@extends('layouts.frontend')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Add Produk</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('produk.index') }}">Produk</a></li>
                            <li class="breadcrumb-item"><a>Add Produk</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Create Produk</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('produk.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="nama">Nama Produk</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="id_kategori_barang">Kategori Produk</label>
                                <select class="form-control @error('id_kategori_barang') is-invalid @enderror" id="id_kategori_barang" name="id_kategori_barang" required>
                                    <option value="" >-- Pilih Kategori --</option>
                                    @foreach($kategori_barang as $kategori)
                                        <option value="{{ $kategori->id_kategori_barang }}" {{ old('id_kategori_barang') == $kategori->id_kategori_barang ? 'selected' : '' }}>{{ $kategori->nama }}</option>
                                    @endforeach
                                </select>
                                @error('id_kategori_barang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>                            

                            <div class="form-group">
                                <label for="stok">Stok</label>
                                <input type="number" class="form-control @error('stok') is-invalid @enderror" id="stok" name="stok" value="{{ old('stok') }}" required>
                                @error('stok')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="harga">Harga Jual</label>
                                <input type="text" class="form-control format-number @error('harga') is-invalid @enderror" id="harga" name="harga" value="{{ old('harga') }}" required>
                                @error('harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="hpp">HPP</label>
                                <input type="text" class="form-control format-number @error('hpp') is-invalid @enderror" id="hpp" name="hpp" value="{{ old('hpp') }}" required>
                                @error('hpp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="{{ route('produk.index') }}" class="btn btn-danger">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
