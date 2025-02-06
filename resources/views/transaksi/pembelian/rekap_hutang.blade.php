@extends('layouts.frontend')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5>Rekap Hutang</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item active">Rekap Hutang</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>List Hutang</h5>
                <button class="btn btn-warning float-right" data-toggle="modal" data-target="#updateTenggatModal">
                    Ubah Tenggat
                </button>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('rekap_hutang') }}" class="mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="month" name="month" class="form-control"
                                value="{{ request('month', now()->format('Y-m')) }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-secondary">Filter</button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No Transaksi</th>
                                <th>Supplier</th>
                                <th>Total Hutang</th>
                                <th>Total Dibayar</th>
                                <th>Sisa Hutang</th>
                                <th>Tenggat Pelunasan</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pembelian as $item)
                            <tr>
                                <td>{{ $item->no_transaksi_pembelian }}</td>
                                <td>{{ $item->supplierRelation->nama ?? 'N/A' }}</td>
                                <td>{{ number_format($item->rekap->total_hutang, 2, ',', '.') }}</td>
                                <td>{{ number_format($item->rekap->total_dibayar, 2, ',', '.') }}</td>
                                <td>{{ number_format($item->rekap->sisa_hutang, 2, ',', '.') }}</td>
                                <td>{{ $item->rekap->tenggat_pelunasan->format('Y-m-d') }}</td>
                                <td><a href="#" class="btn btn-info btn-sm">Detail</a></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">No hutang found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Updating Tenggat -->
<div class="modal fade" id="updateTenggatModal" tabindex="-1" role="dialog" aria-labelledby="updateTenggatLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateTenggatLabel">Ubah Tenggat Pelunasan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('rekap_hutang.update_bulk') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="id">Pilih Transaksi</label>
                        <select name="id" id="id" class="form-control">
                            @foreach($pembelian as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->no_transaksi_pembelian }} - {{ $item->supplierRelation->nama ?? 'N/A' }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tenggat_pelunasan">Tenggat Pelunasan Baru</label>
                        <input type="date" name="tenggat_pelunasan" id="tenggat_pelunasan" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection