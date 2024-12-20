@extends('layouts.frontend')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Edit COA</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Edit COA</h5>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('coa.update', $coa->id_coa) }}">
                    @csrf
                    @method('PUT') <!-- This is important for PUT requests -->
                    <div class="form-group">
                        <label for="kode">Kode Akun:</label>
                        <input type="text" class="form-control" id="kode" name="kode" value="{{ old('kode', $coa->kode) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_akun">Nama Akun:</label>
                        <input type="text" class="form-control" id="nama_akun" name="nama_akun" value="{{ old('nama_akun', $coa->nama_akun) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="kelompok_akun">Kelompok Akun:</label>
                        <select class="form-control" id="kelompok_akun" name="kelompok_akun" required>
                            <option value="" selected hidden>Pilih Kelompok</option>
                            @foreach ($kelompokAkun as $option)
                                <option value="{{ $option->kelompok_akun }}" {{ old('kelompok_akun', $coa->kelompok_akun) == $option->kelompok_akun ? 'selected' : '' }}>
                                    {{ $option->nama_kelompok_akun }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="posisi_d_c">Posisi:</label><br>
                        <input type="radio" id="Debit" name="posisi_d_c" value="Debit" {{ old('posisi_d_c', $coa->posisi_d_c) == 'Debit' ? 'checked' : '' }}> Debit
                        <input type="radio" id="Kredit" name="posisi_d_c" value="Kredit" {{ old('posisi_d_c', $coa->posisi_d_c) == 'Kredit' ? 'checked' : '' }}> Kredit
                    </div>
                    <div class="form-group">
                        <label for="saldo_awal">Saldo Awal:</label>
                        <input type="number" class="form-control" id="saldo_awal" name="saldo_awal" value="{{ old('saldo_awal', $coa->saldo_awal) }}" step="0.01" required>
                    </div>
                    <input type="hidden" name="id_perusahaan" value="{{ auth()->user()->perusahaan->id_perusahaan }}">
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

    // Call the function on page load to set the initial state
    document.addEventListener("DOMContentLoaded", setPosisiDC);
</script>
@endsection