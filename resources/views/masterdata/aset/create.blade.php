@extends('layouts.frontend')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Tambah Aset</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>Add Aset</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('aset.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nama_asset">Nama Aset</label>
                        <input type="text" name="nama_asset" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="harga_perolehan">Harga Perolehan</label>
                        <input type="text" name="harga_perolehan" id="harga_perolehan" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="nilai_sisa">Nilai Sisa</label>
                        <input type="text" name="nilai_sisa" id="nilai_sisa" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="masa_manfaat">Masa Manfaat (Tahun)</label>
                        <input type="number" name="masa_manfaat" class="form-control" required>
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
    function formatNumber(input) {
        let value = input.value.replace(/[^0-9]/g, ''); // Hapus karakter non-angka
        input.value = new Intl.NumberFormat('id-ID').format(value); // Format ribuan
    }

    // Event listener untuk input asuransi
    const asuransiInput = document.getElementById('harga_perolehan');
    asuransiInput.addEventListener('input', function () {
        formatNumber(asuransiInput);
    });

    // Event listener untuk input tarif tetap
    const tarifTetapInput = document.getElementById('nilai_sisa');
    tarifTetapInput.addEventListener('input', function () {
        formatNumber(tarifTetapInput);
    });
</script>
@endsection
