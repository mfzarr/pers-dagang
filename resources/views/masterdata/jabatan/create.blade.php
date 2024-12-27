@extends('layouts.frontend')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Tambah Jabatan</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('jabatan.index') }}">Jabatan</a></li>
                            <li class="breadcrumb-item">Tambah Jabatan</li>
                        </ul>    
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>Add Jabatan</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('jabatan.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                        @if ($errors->has('nama'))
                            <span class="text-danger">{{ $errors->first('nama') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="asuransi">Asuransi</label>
                        <input type="text" name="asuransi" id="asuransi" class="form-control">
                        @if ($errors->has('asuransi'))
                            <span class="text-danger">{{ $errors->first('asuransi') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="tarif">Gaji</label>
                        <input type="text" name="tarif" id="tarif" class="form-control">
                        @if ($errors->has('tarif'))
                            <span class="text-danger">{{ $errors->first('tarif') }}</span>
                        @endif
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('jabatan.index') }}" class="btn btn-danger">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Fungsi untuk memformat angka dengan ribuan
    function formatNumber(input) {
        let value = input.value.replace(/[^0-9]/g, ''); // Hapus karakter non-angka
        input.value = new Intl.NumberFormat('id-ID').format(value); // Format ribuan
    }

    // Event listener untuk input asuransi
    const asuransiInput = document.getElementById('asuransi');
    asuransiInput.addEventListener('input', function () {
        formatNumber(asuransiInput);
    });

    // Event listener untuk input tarif tetap
    const tarifTetapInput = document.getElementById('tarif');
    tarifTetapInput.addEventListener('input', function () {
        formatNumber(tarifTetapInput);
    });
</script>
@endsection
