<div class="modal fade" id="addmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data {{ $table }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addform" method="POST" action="{{ route('coas.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="kode">Kode Akun:</label>
                        <input type="text" class="form-control" id="kode" name="kode" required>
                    </div>
                    <div class="form-group">
                        <label for="nama_akun">Nama Akun:</label>
                        <input type="text" class="form-control" id="nama_akun" name="nama_akun" required>
                    </div>
                    <div class="form-group">
                        <label for="kelompok_akun">Kelompok Akun:</label>
                        <select class="form-control" id="kelompok_akun" name="kelompok_akun" required
                            onchange="setPosisiDC()">
                            <option value="" selected hidden>Select Kelompok</option>
                            @foreach ($kelompokAkun as $option)
                                <option value="{{ $option->kelompok_akun }}">{{ $option->nama_kelompok_akun }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="posisi_d_c">Posisi Debit/Kredit:</label>
                        <br>
                        <!-- Nonaktifkan inputan radio -->
                        <input type="radio" id="Debit" name="posisi_d_c_disabled" value="Debit" disabled>
                        <label for="Debit">Debit</label><br>
                        <input type="radio" id="Kredit" name="posisi_d_c_disabled" value="Kredit" disabled>
                        <label for="Kredit">Kredit</label><br>

                        <!-- Input hidden untuk mengirim nilai posisi_d_c -->
                        <input type="hidden" id="posisi_d_c" name="posisi_d_c" value="">
                    </div>

                    <!-- Sembunyikan inputan saldo awal -->
                    <div class="form-group" style="display: none;">
                        <input type="hidden" id="saldo_awal" name="saldo_awal" value="0">
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="confirmDataButton">Create Data</button>
            </div>
        </div>
    </div>
</div>

<script>
    function setPosisiDC() {
        // Ambil nilai kelompok_akun yang dipilih
        const kelompokAkun = parseInt(document.getElementById("kelompok_akun").value, 10);

        // Ambil elemen radio untuk posisi
        const debitRadio = document.getElementById("Debit");
        const kreditRadio = document.getElementById("Kredit");

        // Ambil elemen input hidden untuk posisi_d_c
        const posisiDCInput = document.getElementById("posisi_d_c");

        // Reset pilihan
        debitRadio.checked = false;
        kreditRadio.checked = false;
        posisiDCInput.value = ""; // Reset nilai input hidden

        // Logika untuk memilih posisi berdasarkan kelompok_akun
        if (kelompokAkun < 200) {
            debitRadio.checked = true;
            posisiDCInput.value = "Debit";
        } else if (kelompokAkun >= 200 && kelompokAkun < 500) {
            kreditRadio.checked = true;
            posisiDCInput.value = "Kredit";
        } else if (kelompokAkun >= 500) {
            debitRadio.checked = true;
            posisiDCInput.value = "Debit";
        }
    }

    $(document).ready(function() {
        $('#confirmDataButton').click(function() {
            var form = $('#addform');
            var formData = form.serialize();

            $.ajax({
                url: '{{ route('coas.store') }}',
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#addmodal').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        });
    });
</script>
