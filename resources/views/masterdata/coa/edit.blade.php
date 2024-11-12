<div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Coa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="editform">
                    @csrf
                    @method('PUT')
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
                        <input type="radio" id="Debit" name="posisi_d_c" value="Debit">
                        <label for="Debit">Debit</label><br>
                        <input type="radio" id="Kredit" name="posisi_d_c" value="Kredit">
                        <label for="Kredit">Kredit</label><br>
                    </div>
                    <div class="form-group">
                        <label for="saldo_awal">Saldo Awal:</label>
                        <br>
                        <input type="radio" id="1" name="saldo_awal" value="1">
                        <label for="1">Ya</label><br>
                        <input type="radio" id="0" name="saldo_awal" value="0">
                        <label for="0">Tidak</label><br>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="confirmUpdateButton">Update Data</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.edit-button').click(function() {
            var id = $(this).data('id');

            $.ajax({
                url: '/masterdata/coas/' + id + '/edit', // Fixing the URL to match the plural 'coas'
                method: 'GET',
                success: function(data) {
                    $('input[name="id_coa"]').val(data.coas.id_coa);
                    $('input[name="nama_akun"]').val(data.coas.nama_akun);
                    $('input[name="kode"]').val(data.coas.kode);
                    $('select[name="kelompok_akun"]').val(data.coas.kelompok_akun);
                    $('select[name="id_perusahaan"]').val(data.coas.id_perusahaan);
                    $('input[name="posisi_d_c"][value="' + data.coas.posisi_d_c + '"]').prop('checked', true);
                    $('input[name="saldo_awal"][value="' + data.coas.saldo_awal + '"]').prop('checked', true);

                    // Set form action URL and include PUT method
                    $('#editform').attr('action', '/masterdata/coas/' + id);
                    $('#editmodal').modal('show');
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        });

        $('#confirmUpdateButton').click(function() {
            var form = $('#editform');
            var formData = form.serialize(); // Automatically includes CSRF and PUT method

            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: formData,
                success: function(response) {
                    $('#editmodal').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        });
    });
</script>