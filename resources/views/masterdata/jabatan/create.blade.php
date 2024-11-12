@extends('layouts.frontend')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
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
                    </div>
                    <div class="form-group">
                        <label for="asuransi">Asuransi</label>
                        <input type="number" name="asuransi" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="tarif_tetap">Tarif Tetap</label>
                        <input type="number" name="tarif_tetap" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="tarif_tidak_tetap">Tarif Tidak Tetap</label>
                        <input type="number" name="tarif_tidak_tetap" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
