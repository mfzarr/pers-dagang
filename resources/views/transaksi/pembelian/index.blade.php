@extends('layouts.frontend')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Daftar Transaksi Pembelian</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item active">Pembelian</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>List Pembelian</h5>
                <a href="{{ route('pembelian.create') }}" class="btn btn-primary">Tambah Pembelian</a>
            </div>

            <div class="card-body">
                <!-- Search and Filter Form -->
                <form method="GET" action="{{ route('pembelian.index') }}" class="mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control"
                                placeholder="Cari Dengan No Transaksi"
                                value="{{ request('search') }}">
                        </div>
                        <div class="col-md-6">
                            <select name="filter" class="form-control" onchange="this.form.submit()">
                                <option value="">Filter by Transaksi</option>
                                <option value="lunas" {{ request('filter') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                                <option value="belum_lunas" {{ request('filter') == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                                <option value="produk" {{ request('filter') == 'produk' ? 'selected' : '' }}>Produk</option>
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
                                <th>No Transaksi Pembelian</th>
                                <th>Tanggal Pembelian</th>
                                <th>Supplier</th>

                                <!-- produk Column -->
                                @if(request('filter') == 'produk')
                                <th>Produk</th>
                                @endif

                                <th>Tipe Pembayaran</th>
                                <th>Total Dibayar</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pembelian as $item)
                            <tr>
                                <td>{{ $item->no_transaksi_pembelian }}</td>
                                <td>{{ $item->tanggal_pembelian }}</td>
                                <td>{{ $item->supplierRelation->nama ?? 'N/A' }}</td>

                                <!-- produk Column Content -->
                                @if(request('filter') == 'produk')
                                <td>
                                    <ul>
                                        @foreach($item->pembelianDetails as $detail)
                                        <li>{{ $detail->produkRelation->nama ?? 'N/A' }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                @endif

                                <td>{{ $item->tipe_pembayaran }}</td>
                                <td>{{ $item->total_dibayar }}</td>
                                <td>{{ $item->total }}</td>
                                <td>
                                    @if($item->total_dibayar >= $item->total)
                                    <span class="badge badge-success">Lunas</span>
                                    @else
                                    <span class="badge badge-danger">Belum Lunas</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('pembelian.detail', $item->id_pembelian) }}" class="btn btn-sm btn-info">Detail</a>

                                    <!-- Pelunasan Button -->
                                    @if($item->status === 'Belum Lunas')
                                    <form action="{{ route('pembelian.pelunasan.auto', $item->id_pembelian) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning">Pelunasan</button>
                                    </form>
                                    @endif

                                    <form action="{{ route('pembelian.destroy', $item->id_pembelian) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger"
                                            onclick="confirmDelete('{{ route('pembelian.destroy', $item->id_pembelian) }}')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>


                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">No pembelian found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <!-- Left Arrow (Previous Page) -->
                    <a href="{{ $pembelian->previousPageUrl() }}"
                        class="btn btn-outline-primary btn-sm {{ $pembelian->onFirstPage() ? 'disabled' : '' }}">
                        &laquo; Previous
                    </a>

                    <!-- Current Page Info -->
                    <span>Page {{ $pembelian->currentPage() }} of {{ $pembelian->lastPage() }}</span>

                    <!-- Right Arrow (Next Page) -->
                    <a href="{{ $pembelian->nextPageUrl() }}"
                        class="btn btn-outline-primary btn-sm {{ $pembelian->hasMorePages() ? '' : 'disabled' }}">
                        Next &raquo;
                    </a>
                </div>

                <!-- Delete Confirmation Modal -->
                <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi penghapusan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Anda akan menghapus item ini, lanjutkan?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <form id="deleteForm" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(action) {
        // Set the form action to the delete route
        const form = document.getElementById('deleteForm');
        form.action = action;

        // Show the confirmation modal
        $('#deleteConfirmationModal').modal('show');
    }
</script>
@endsection