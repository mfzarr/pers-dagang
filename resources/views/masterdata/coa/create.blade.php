@extends('layouts.frontend')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Tambah COA</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Tambah COA Baru</h5>
            </div>

            <div class="card-body">
                <!-- Make sure the form has the correct method and action -->
                <form method="POST" action="{{ route('coa.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="kode">Kode Akun:</label>
                        <input type="number" class="form-control" id="kode" name="kode" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_akun">Nama Akun:</label>
                        <input type="text" class="form-control" id="nama_akun" name="nama_akun" required>
                    </div>
                    <div class="form-group">
                        <label for="kelompok_akun">Kelompok Akun:</label>
                        <select class="form-control" id="kelompok_akun" name="kelompok_akun" required>
                            <option value="" selected hidden>Pilih Kelompok</option>
                            @foreach ($kelompokAkun as $option)
                                <option value="{{ $option->kelompok_akun }}">{{ $option->nama_kelompok_akun }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="posisi_d_c">Posisi Debit/Kredit:</label><br>
                        <input type="radio" id="Debit" name="posisi_d_c" value="Debit"> Debit
                        <input type="radio" id="Kredit" name="posisi_d_c" value="Kredit"> Kredit
                    </div>
                    <input type="hidden" id="saldo_awal" name="saldo_awal" value="0">
                    <input type="hidden" name="id_perusahaan" value="{{ auth()->user()->perusahaan->id_perusahaan }}">
                    <!-- Footer with buttons inside the form to ensure proper submission -->
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-danger" onclick="window.location='{{ route('coa.index') }}'">Back</button>
                  </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function setPosisiDC() {
        const kelompokAkun = parseInt(document.getElementById("kelompok_akun").value, 10);
        const debitRadio = document.getElementById("Debit");
        const kreditRadio = document.getElementById("Kredit");

        debitRadio.checked = false;
        kreditRadio.checked = false;

        if (kelompokAkun === 1) {
            debitRadio.checked = true;
        } else if (kelompokAkun >= 2 && kelompokAkun < 5) {
            kreditRadio.checked = true;
        } else if (kelompokAkun >= 5) {
            debitRadio.checked = true;
        }
    }

    document.getElementById("kelompok_akun").addEventListener("change", setPosisiDC);
</script>
@endsection
