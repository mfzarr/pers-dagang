@extends('layouts.frontend')

@section('content')
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Edit Supplier</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('supplier.index') }}">Supplier</a></li>
                                <li class="breadcrumb-item"><a>Edit Supplier</a></li>
                            </ul> 
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Edit Supplier</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('supplier.update', $supplier->id_supplier) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
                                        value="{{ old('nama', $supplier->nama) }}" required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="no_telp">No Telp</label>
                                    <input type="text" class="form-control @error('no_telp') is-invalid @enderror" id="no_telp" name="no_telp"
                                        value="{{ old('no_telp', $supplier->no_telp) }}" required>
                                    @error('no_telp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat"
                                        rows="3" required>{{ old('alamat', $supplier->alamat) }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="products">Produk</label>
                                    <select class="js-example-basic-multiple col-sm-12 @error('products') is-invalid @enderror" id="products" name="products[]" multiple="multiple" required>
                                        <optgroup label="Produk Aktif">
                                            @foreach($products as $product)
                                                @if($product->status == 'Aktif')
                                                    <option value="{{ $product->id_produk }}" {{ in_array($product->id_produk, old('products', $supplier->products->pluck('id_produk')->toArray())) ? 'selected' : '' }}>   {{ $product->nama }}</option>
                                                @endif
                                            @endforeach
                                        </optgroup>
                                    </select>
                                    @error('products')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="Aktif" {{ old('status', $supplier->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Tidak Aktif" {{ old('status', $supplier->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <a href="{{ route('supplier.index') }}" class="btn btn-danger">Back</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    
