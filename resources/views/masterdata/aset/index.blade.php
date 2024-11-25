@extends('layouts.frontend')

@section('content')
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <div class="page-header">
                <h5 class="m-b-10">List of Asset</h5>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Asset List</h5>
                            <div class="float-right">
                                <a href="{{ route('aset.create') }}" class="btn btn-success btn-sm btn-round has-ripple"><i
                                        class="feather icon-plus"></i>Add Aset</a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if ($assets->isEmpty())
                                <p>No assets found for your perusahaan.</p>
                            @else
                                <div class="table-responsive">
                                    <table id="simpletable" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Nama Aset</th>
                                                <th>Harga Perolehan</th>
                                                <th>Nilai Sisa</th>
                                                <th>Masa Manfaat (Tahun)</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($assets as $asset)
                                                <tr>
                                                    <td>{{ $asset->nama_asset }}</td>
                                                    <td>Rp{{ number_format($asset->harga_perolehan, 0, ',', '.') }}</td>
                                                    <td>Rp{{ number_format($asset->nilai_sisa, 0, ',', '.') }}</td>
                                                    <td>{{ $asset->masa_manfaat }}</td>
                                                    <td>
                                                        <!-- Kirimkan ID aset sebagai parameter -->
                                                        <a href="{{ route('aset.edit', $asset->id_assets) }}"
                                                            class="btn btn-info btn-sm">
                                                            <i class="feather icon-edit"></i>&nbsp;Edit
                                                        </a>
                                                        <a href="{{ route('aset.depreciation', $asset->id_assets) }}"
                                                            class="btn btn-success btn-sm">
                                                            <i class="feather icon-clipboard"></i> Depreciation
                                                        </a>
                                                        <form id="delete-form-{{ $asset->id_assets }}"
                                                            action="{{ route('aset.destroy', $asset->id_assets) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                onclick="confirmDelete('{{ $asset->id_assets }}')">
                                                                <i class="feather icon-trash-2"></i>&nbsp;Delete
                                                            </button>
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

    <script>
        function confirmDelete(assetId) {
            Swal.fire({
                title: 'Hapus data ini?',
                text: "Tindakan ini tidak bisa diubah!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus data ini!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById(`delete-form-${assetId}`);
                    if (form) {
                        form.submit();
                    } else {
                        console.error(`Form with ID delete-form-${assetId} not found.`);
                    }
                }
            });
        }
    </script>
@endsection
