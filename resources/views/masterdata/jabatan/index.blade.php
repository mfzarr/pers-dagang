@extends('layouts.frontend')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <h5 class="m-b-10">List of Jabatan</h5>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Jabatan List</h5>
                        <a href="{{ route('jabatan.create') }}" class="btn btn-primary">Add Jabatan</a>
                    </div>
                    <div class="card-body">
                        @if($jabatans->isEmpty())
                            <p>No jabatans found for your perusahaan.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Asuransi</th>
                                            <th>Tarif Tetap</th>
                                            <th>Tarif Tidak Tetap</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($jabatans as $jabatan)
                                            <tr>
                                                <td>{{ $jabatan->nama }}</td>
                                                <td>Rp{{ number_format($jabatan->asuransi, 0, ',', '.') }}</td>                                                <td>Rp{{ number_format($jabatan->tarif_tetap, 0, ',', '.') }}</td>
                                                <td>Rp{{ number_format($jabatan->tarif_tidak_tetap, 0, ',', '.') }}</td>
                                                <td>
                                                    <a href="{{ route('jabatan.edit', $jabatan->id_jabatan) }}" class="btn btn-warning">Edit</a>
                                                    <form action="{{ route('jabatan.destroy', $jabatan->id_jabatan) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
