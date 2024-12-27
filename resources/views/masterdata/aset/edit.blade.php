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
                            <input type="text" name="nama_asset" class="form-control" value="{{ old('nama_asset', $asset->nama_asset) }}" required>
                            @if ($errors->has('nama_asset'))
                                <span class="text-danger">{{ $errors->first('nama_asset') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="harga_perolehan">Harga Perolehan</label>
                            <input type="text" name="harga_perolehan" id="harga_perolehan" class="form-control"
                                value="{{ old('harga_perolehan', number_format($asset->harga_perolehan, 0, ',', '.')) }}">
                            <input type="hidden" name="harga_perolehan" id="harga_perolehan_hidden" value="{{ $asset->harga_perolehan }}">
                            @if ($errors->has('harga_perolehan'))
                                <span class="text-danger">{{ $errors->first('harga_perolehan') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="nilai_sisa">Nilai Sisa</label>
                            <input type="text" name="nilai_sisa" id="nilai_sisa" class="form-control"
                                value="{{ old('nilai_sisa', number_format($asset->nilai_sisa, 0, ',', '.')) }}">
                            <input type="hidden" name="nilai_sisa" id="nilai_sisa_hidden" value="{{ $asset->nilai_sisa }}">
                            @if ($errors->has('nilai_sisa'))
                                <span class="text-danger">{{ $errors->first('nilai_sisa') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="masa_manfaat">Masa Manfaat (Tahun)</label>
                            <input type="number" name="masa_manfaat" class="form-control" value="{{ old('masa_manfaat', $asset->masa_manfaat) }}" required>
                            @if ($errors->has('masa_manfaat'))
                                <span class="text-danger">{{ $errors->first('masa_manfaat') }}</span>
                            @endif
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

        // Event listener untuk harga perolehan
        const hargaPerolehanInput = document.getElementById('harga_perolehan');
        const hargaPerolehanHidden = document.getElementById('harga_perolehan_hidden');
        hargaPerolehanInput.addEventListener('input', function () {
            formatAndSetHiddenField(hargaPerolehanInput, hargaPerolehanHidden);
        });

        // Event listener untuk nilai sisa
        const nilaiSisaInput = document.getElementById('nilai_sisa');
        const nilaiSisaHidden = document.getElementById('nilai_sisa_hidden');
        nilaiSisaInput.addEventListener('input', function () {
            formatAndSetHiddenField(nilaiSisaInput, nilaiSisaHidden);
        });
    </script>
@endsection
