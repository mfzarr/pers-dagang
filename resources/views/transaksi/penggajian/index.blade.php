@extends('layouts.frontend')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Daftar Penggajian</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item active">Penggajian</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>List Penggajian</h5>
                <a href="{{ route('penggajian.create') }}" class="btn btn-primary">Tambah Penggajian</a>
            </div>

            <div class="card-body">
                <!-- Search and Filter Form -->
                <form method="GET" action="{{ route('penggajian.index') }}" class="mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control"
                                placeholder="Cari Dengan No Transaksi Gaji"
                                value="{{ request('search') }}">
                        </div>
                        <div class="col-md-6">
                            <select name="filter" class="form-control" onchange="this.form.submit()">
                                <option value="">Filter by Karyawan</option>
                                <option value="lunas" {{ request('filter') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                                <option value="belum_lunas" {{ request('filter') == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
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
                                <th>No Transaksi Gaji</th>
                                <th>Tanggal Penggajian</th>
                                <th>Karyawan</th>
                                <th>Total Gaji Bersih</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($penggajian as $gaji)
                            <tr>
                                <td>{{ $gaji->no_transaksi_gaji }}</td>
                                <td>{{ $gaji->tanggal_penggajian }}</td>
                                <td>{{ $gaji->karyawan ? $gaji->karyawan->nama : 'N/A' }}</td>
                                <td>{{ $gaji->total_gaji_bersih }}</td>
                                <td>
                                    <a href="{{ route('penggajian.show', $gaji->id_gaji) }}" class="btn btn-info btn-sm">
                                        <i class="feather icon-eye"></i> Detail
                                    </a>
                                    <form action="{{ route('penggajian.destroy', $gaji->id_gaji) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('penggajian.destroy', $gaji->id_gaji) }}')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No penggajian found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="{{ $penggajian->previousPageUrl() }}" class="btn btn-outline-primary btn-sm {{ $penggajian->onFirstPage() ? 'disabled' : '' }}">&laquo; Previous</a>
                    <span>Page {{ $penggajian->currentPage() }} of {{ $penggajian->lastPage() }}</span>
                    <a href="{{ $penggajian->nextPageUrl() }}" class="btn btn-outline-primary btn-sm {{ $penggajian->hasMorePages() ? '' : 'disabled' }}">Next &raquo;</a>
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
        const form = document.getElementById('deleteForm');
        form.action = action;
        $('#deleteConfirmationModal').modal('show');
    }
</script>
@endsection