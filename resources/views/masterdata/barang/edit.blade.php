@extends('layouts.frontend')

@section('content')
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12"></div>
                            <div class="page-header-title">
                                <h5 class="m-b-10">Edit Barang</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('barang.index') }}">Barang</a></li>
                                <li class="breadcrumb-item"><a>Edit Barang</a></li>
                            </ul>
    
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Edit Barang</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('barang.update', $barang1->id_barang1) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        value="{{ $barang1->nama }}" required>
                                    @if ($errors->has('nama'))
                                        <span class="text-danger">{{ $errors->first('nama') }}</span>
                                    @endif
                                </div>
                                {{-- <div class="form-group">
                                    <label for="detail">Detail</label>
                                    <textarea class="form-control" id="detail" name="detail" rows="3" required>{{ $barang1->detail }}</textarea>
                                    @if ($errors->has('detail'))
                                        <span class="text-danger">{{ $errors->first('detail') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="satuan">Satuan</label>
                                    <select class="form-control" id="satuan" name="satuan" required>
                                        <option value="Pcs" {{ $barang1->satuan == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                                        <option value="Ml" {{ $barang1->satuan == 'Ml' ? 'selected' : '' }}>Ml</option>
                                    </select>
                                    @if ($errors->has('satuan'))
                                        <span class="text-danger">{{ $errors->first('satuan') }}</span>
                                    @endif
                                </div> --}}
                                <div class="form-group">
                                    <label for="kategori">Kategori</label>
                                    <select class="form-control" id="kategori" name="kategori" required>
                                        <option value="" disabled selected>Select Kategori</option>
                                        <option value="Perlengkapan" {{ $barang1->kategori == 'Perlengkapan' ? 'selected' : '' }}>Perlengkapan</option>
                                        <option value="Peralatan" {{ $barang1->kategori == 'Peralatan' ? 'selected' : '' }}>Peralatan</option>
                                    </select>
                                    @if ($errors->has('kategori'))
                                        <span class="text-danger">{{ $errors->first('kategori') }}</span>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <a href="{{ route('barang.index') }}" class="btn btn-danger">Back</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
