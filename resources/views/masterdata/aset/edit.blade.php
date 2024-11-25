@extends('layouts.frontend')

@section('content')
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Edit Aset</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5>Edit Aset</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('aset.update', $asset->id_assets) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="nama_asset">Nama Aset</label>
                            <input type="text" name="nama_asset" class="form-control" value="{{ $asset->nama_asset }}" required>
                        </div>
                        <div class="form-group">
                            <label for="harga_perolehan">Harga Perolehan</label>
                            <input type="text" name="harga_perolehan" id="harga_perolehan" class="form-control"
                                value="{{ number_format($asset->harga_perolehan, 0, ',', '.') }}">
                            <input type="hidden" name="harga_perolehan" id="harga_perolehan_hidden" value="{{ $asset->harga_perolehan }}">
                        </div>
                        <div class="form-group">
                            <label for="nilai_sisa">Nilai Sisa</label>
                            <input type="text" name="nilai_sisa" id="nilai_sisa" class="form-control"
                                value="{{ number_format($asset->nilai_sisa, 0, ',', '.') }}">
                            <input type="hidden" name="nilai_sisa" id="nilai_sisa_hidden" value="{{ $asset->nilai_sisa }}">
                        </div>
                        <div class="form-group">
                            <label for="masa_manfaat">Masa Manfaat (Tahun)</label>
                            <input type="number" name="masa_manfaat" class="form-control" value="{{ $asset->masa_manfaat }}" required
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{ route('aset.index') }}" class="btn btn-danger">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk memformat angka dengan ribuan
        function formatAndSetHiddenField(input, hiddenField) {
            let value = input.value.replace(/[^0-9]/g, ''); // Hapus karakter non-angka
            input.value = new Intl.NumberFormat('id-ID').format(value); // Format angka
            hiddenField.value = value; // Simpan angka murni ke hidden field
        }

        // Event listener untuk asuransi
        const asuransiInput = document.getElementById('asuransi');
        const asuransiHidden = document.getElementById('asuransi_hidden');
        asuransiInput.addEventListener('input', function () {
            formatAndSetHiddenField(asuransiInput, asuransiHidden);
        });

        // Event listener untuk tarif tetap
        const tarifTetapInput = document.getElementById('tarif_tetap');
        const tarifTetapHidden = document.getElementById('tarif_tetap_hidden');
        tarifTetapInput.addEventListener('input', function () {
            formatAndSetHiddenField(tarifTetapInput, tarifTetapHidden);
        });

        // Opsional: Event listener untuk tarif tidak tetap (jika diperlukan)
        // const tarifTidakTetapInput = document.getElementById('tarif_tidak_tetap');
        // const tarifTidakTetapHidden = document.getElementById('tarif_tidak_tetap_hidden');
        // tarifTidakTetapInput.addEventListener('input', function () {
        //     formatAndSetHiddenField(tarifTidakTetapInput, tarifTidakTetapHidden);
        // });
    </script>
@endsection
