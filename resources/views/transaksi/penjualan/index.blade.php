@extends('layouts.frontend')

@section('content')
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Daftar Transaksi Penjualan</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('penjualan.index') }}">Penjualan</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5>Daftar Penjualan</h5>
                    <div class="float-right">
                        <a href="{{ route('penjualan.create') }}" class="btn btn-success btn-sm btn-round has-ripple"><i
                                class="feather icon-plus"></i>Add Penjualan</a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Search and Filter Form -->
                    <form method="GET" action="{{ route('penjualan.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Cari Berdasarkan No Transaksi" value="{{ request('search') }}">
                            </div>
                            <div class="col-md-6">
                                <select name="filter" class="form-control" onchange="this.form.submit()">
                                    <option value="">Filter Status</option>
                                    <option value="lunas" {{ request('filter') == 'lunas' ? 'selected' : '' }}>Lunas
                                    </option>
                                    <option value="belum_lunas" {{ request('filter') == 'belum_lunas' ? 'selected' : '' }}>
                                        Belum Lunas</option>
                                    <option value="selesai" {{ request('filter') == 'selesai' ? 'selected' : '' }}>Selesai
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-secondary">Cari</button>
                            </div>
                        </div>
                    </form>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No Transaksi</th>
                                    <th>Tanggal</th>
                                    <th>Pelanggan</th>
                                    <th>Dicatat Oleh</th>
                                    <th>Total</th>
                                    <th>Diskon</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($penjualan as $item)
                                    <tr>
                                        <td>{{ $item->no_transaksi_penjualan }}</td>
                                        <td>{{ $item->tgl_transaksi }}</td>
                                        <td>{{ $item->pelangganRelation->nama ?? 'N/A' }}</td>
                                        <td>{{ $item->userRelation->username ?? 'N/A' }}</td>
                                        <td>{{ number_format($item->total, 2) }}</td>
                                        <td>{{ $item->discount }}%</td>
                                        <td>
                                            @if ($item->status == 'Lunas')
                                                <span class="badge badge-success">Lunas</span>
                                            @elseif($item->status == 'Selesai')
                                                <span class="badge badge-primary">Selesai</span>
                                            @else
                                                <span class="badge badge-danger">Belum Lunas</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('penjualan.show', $item->id_penjualan) }}"
                                                class="btn btn-sm btn-info">Detail</a>

                                            @if ($item->status != 'Selesai')
                                                <a href="{{ route('penjualan.selesaikan', $item->id_penjualan) }}"
                                                    class="btn btn-sm btn-success">Selesaikan</a>
                                            @endif

                                            <form action="{{ route('penjualan.destroy', $item->id_penjualan) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada data penjualan.</td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <a href="{{ $penjualan->previousPageUrl() }}"
                            class="btn btn-outline-primary btn-sm {{ $penjualan->onFirstPage() ? 'disabled' : '' }}">&laquo;
                            Sebelumnya</a>
                        <span>Halaman {{ $penjualan->currentPage() }} dari {{ $penjualan->lastPage() }}</span>
                        <a href="{{ $penjualan->nextPageUrl() }}"
                            class="btn btn-outline-primary btn-sm {{ $penjualan->hasMorePages() ? '' : 'disabled' }}">Selanjutnya
                            &raquo;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
