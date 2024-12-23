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
                    <form method="POST" action="{{ route('coa.update', $coas->id_coa) }}">
                        @csrf
                        @method('PUT') <!-- This is important for PUT requests -->

                        <!-- Menampilkan pesan kesalahan untuk kode_akun -->
                        <div class="form-group">
                            <label for="kode_akun">Kode Akun:</label>
                            <input type="text" class="form-control @error('kode_akun') is-invalid @enderror" id="kode_akun" name="kode_akun"
                                value="{{ old('kode_akun', $coas->kode_akun) }}" required readonly>
                            @error('kode_akun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Menampilkan pesan kesalahan untuk nama akun -->
                        <div class="form-group">
                            <label for="nama_akun">Nama Akun:</label>
                            <input type="text" class="form-control @error('nama_akun') is-invalid @enderror" id="nama_akun" name="nama_akun"
                                value="{{ old('nama_akun', $coas->nama_akun) }}" required>
                            @error('nama_akun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Menampilkan pesan kesalahan untuk kelompok akun -->
                        <div class="form-group">
                            <label for="kelompok_akun">Kelompok Akun:</label>
                            <select class="form-control @error('kelompok_akun') is-invalid @enderror" id="kelompok_akun" name="kelompok_akun" required>
                                <option value="" selected hidden>Pilih Kelompok</option>
                                @foreach ($kelompokakun as $option)
                                    <option value="{{ $option->kelompok_akun }}"
                                        {{ old('kelompok_akun', $coas->kelompok_akun) == $option->kelompok_akun ? 'selected' : '' }}>
                                        {{ $option->nama_kelompok_akun }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kelompok_akun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Menampilkan pesan kesalahan untuk posisi -->
                        <div class="form-group">
                            <label for="posisi_d_c">Posisi:</label><br>
                            <input type="radio" id="Debit" name="posisi_d_c" value="Debit"
                                {{ old('posisi_d_c', $coas->posisi_d_c) == 'Debit' ? 'checked' : '' }}> Debit
                            <input type="radio" id="Kredit" name="posisi_d_c" value="Kredit"
                                {{ old('posisi_d_c', $coas->posisi_d_c) == 'Kredit' ? 'checked' : '' }}> Kredit
                            @error('posisi_d_c')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Menampilkan pesan kesalahan untuk saldo awal -->
                        <div class="form-group">
                            <label for="saldo_awal">Saldo Awal:</label>
                            <input type="number" class="form-control @error('saldo_awal') is-invalid @enderror" id="saldo_awal" name="saldo_awal"
                                value="{{ old('saldo_awal', $coas->saldo_awal) }}" step="0.01" required>
                            @error('saldo_awal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <input type="hidden" name="id_perusahaan" value="{{ auth()->user()->perusahaan->id_perusahaan }}">
                        
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-danger"
                                onclick="window.location='{{ route('coa.index') }}'">Back</button>
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

            // Logika untuk memilih posisi_d_c berdasarkan kelompok_akun
            if (kelompokAkun === 1) {
                debitRadio.checked = true;
            } else if (kelompokAkun >= 2 && kelompokAkun < 5) {
                kreditRadio.checked = true;
            } else if (kelompokAkun >= 5) {
                debitRadio.checked = true;
            }
        }

        // Memanggil fungsi ini ketika kelompok akun berubah
        document.getElementById("kelompok_akun").addEventListener("change", setPosisiDC);

        // Call the function on page load to set the initial state
        // document.addEventListener("DOMContentLoaded", setPosisiDC);
    </script>
@endsection
