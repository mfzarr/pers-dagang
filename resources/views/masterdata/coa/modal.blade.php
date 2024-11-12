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
                        <select class="form-control" id="kelompok_akun" name="kelompok_akun" required>
                            <option value="" selected hidden>Select Kelompok</option>
                            @foreach ($kelompokAkun as $option)
                                <option value="{{ $option->nama_kelompok_akun }}">{{ $option->nama_kelompok_akun }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="posisi_d_c">Posisi Debit/Kredit:</label>
                        <br>
                        <input type="radio" id="Debit" name="posisi_d_c" value="Debit" required>
                        <label for="Debit">Debit</label><br>
                        <input type="radio" id="Kredit" name="posisi_d_c" value="Kredit" required>
                        <label for="Kredit">Kredit</label><br>
                    </div>
                    <div class="form-group">
                        <label for="saldo_awal">Saldo Awal:</label>
                        <br>
                        <input type="radio" id="1" name="saldo_awal" value="1" required>
                        <label for="1">Ya</label><br>
                        <input type="radio" id="0" name="saldo_awal" value="0" required>
                        <label for="0">Tidak</label><br>
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
    $(document).ready(function() {
        $('#confirmDataButton').click(function() {
            var form = $('#addform');
            var formData = form.serialize();

            $.ajax({
                url: '{{ route("coas.store") }}',
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
