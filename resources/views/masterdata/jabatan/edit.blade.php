@extends('layouts.frontend')

@section('content')
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Edit Jabatan</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5>Edit Jabatan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('jabatan.update', $jabatan->id_jabatan) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" class="form-control" value="{{ $jabatan->nama }}" required>
                        </div>
                        <div class="form-group">
                            <label for="asuransi">Asuransi</label>
                            <input type="text" id="asuransi" class="form-control"
                                value="{{ number_format($jabatan->asuransi, 0, ',', '.') }}">
                            <input type="hidden" name="asuransi" id="asuransi_hidden" value="{{ $jabatan->asuransi }}">
                        </div>
                        <div class="form-group">
                            <label for="tarif_tetap">Tarif Tetap</label>
                            <input type="text" id="tarif_tetap" class="form-control"
                                value="{{ number_format($jabatan->tarif_tetap, 0, ',', '.') }}">
                            <input type="hidden" name="tarif_tetap" id="tarif_tetap_hidden" value="{{ $jabatan->tarif_tetap }}">
                        </div>
                        {{-- <div class="form-group">
                            <label for="tarif_tidak_tetap">Tarif Tidak Tetap</label>
                            <input type="text" id="tarif_tidak_tetap" class="form-control"
                                value="{{ number_format($jabatan->tarif_tidak_tetap, 0, ',', '.') }}">
                            <input type="hidden" name="tarif_tidak_tetap" id="tarif_tidak_tetap_hidden" value="{{ $jabatan->tarif_tidak_tetap }}">
                        </div> --}}
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{ route('jabatan.index') }}" class="btn btn-danger">Back</a>
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
