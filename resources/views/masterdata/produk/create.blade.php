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
                            <li class="breadcrumb-item"><a href="#!">Add Produk</a></li>
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
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>

                            <div class="form-group">
                                <label for="id_kategori_barang">Kategori Produk</label>
                                <select class="form-control" id="id_kategori_barang" name="id_kategori_barang" required>
                                    <option value="" >-- Pilih Kategori --</option>
                                    @foreach($kategori_barang as $kategori)
                                        <option value="{{ $kategori->id_kategori_barang }}">{{ $kategori->nama }}</option>
                                    @endforeach
                                </select>
                            </div>                            

                            <div class="form-group">
                                <label for="stok">Stok</label>
                                <input type="number" class="form-control" id="stok" name="stok" required>
                            </div>

                            <div class="form-group">
                                <label for="harga_jual">Harga Jual</label>
                                <input type="text" class="form-control format-number" id="harga_jual" name="harga_jual" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="hpp">HPP</label>
                                <input type="text" class="form-control format-number" id="hpp" name="hpp" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Tidak Aktif">Tidak Aktif</option>
                                </select>
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
