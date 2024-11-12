{{-- resources/views/layouts/transaksi/index.blade.php --}}
@extends('layouts.frontend')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">List of Pembelian</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Pembelian</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Pembelian List</h5>
                        <a href="{{ route('pembelian.create') }}" class="btn btn-primary">Add Pembelian</a>
                    </div>
                    <div class="card-body">
                        @if($pembelian->isEmpty())
                        <p>No pembelian found for your perusahaan.</p>
                        @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No Transaksi Pembelian</th>
                                        <th>Tanggal Pembelian</th>
                                        <th>Supplier</th>
                                        <th>Tipe Pembayaran</th>
                                        <th>Total Dibayar</th>
                                        <th>Total</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pembelian as $item)
                                    <tr>
                                        <td>{{ $item->no_transaksi_pembelian }}</td>
                                        <td>{{ $item->tanggal_pembelian }}</td>
                                        <td>{{ $item->supplierRelation->nama ?? 'N/A' }}</td>
                                        <td>{{ $item->tipe_pembayaran }}</td>
                                        <td>{{ $item->total_dibayar }}</td>
                                        <td>{{ $item->total }}</td>
                                        <td>
                                            <form action="{{ route('pembelian.destroy', $item->id_pembelian) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
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