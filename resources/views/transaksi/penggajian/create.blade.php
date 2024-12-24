@extends('layouts.frontend')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Tambah Penggajian</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('penggajian.index') }}">Penggajian</a></li>
                            <li class="breadcrumb-item active">Tambah Penggajian</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Form Penggajian Baru</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('penggajian.store') }}" method="POST">
                    @csrf

                    <!-- Tanggal Penggajian -->
                    <div class="form-group">
                        <label for="tanggal_penggajian">Tanggal Penggajian</label>
                        <input type="date" id="tanggal_penggajian" name="tanggal_penggajian" class="form-control" required>
                    </div>

                    <!-- Karyawan -->
                    <div class="form-group">
                        <label for="id_karyawan">Karyawan</label>
                        <select id="id_karyawan" name="id_karyawan" class="form-control" required>
                            <option value="">Pilih Karyawan</option>
                            @foreach($karyawan as $emp)
                            <option value="{{ $emp->id_karyawan }}">{{ $emp->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tarif -->
                    <div class="form-group">
                        <label for="tarif">Tarif</label>
                        <input type="number" id="tarif" name="tarif" class="form-control" required readonly>
                    </div>

                    <!-- Bonus (%) -->
                    <div class="form-group">
                        <label for="bonus">Bonus (%)</label>
                        <input type="number" id="bonus" name="bonus" class="form-control" required placeholder="Masukkan persentase bonus">
                    </div>

                    <!-- Total Service -->
                    <div class="form-group">
                        <label for="total_service">Total Service</label>
                        <input type="number" id="total_service" name="total_service" class="form-control" readonly>
                    </div>


                    <!-- Bonus Service -->
                    <div class="form-group">
                        <label for="bonus_service">Bonus Service</label>
                        <input type="number" id="bonus_service" name="bonus_service" class="form-control" readonly>
                    </div>

                    <!-- Total Kehadiran -->
                    <div class="form-group">
                        <label for="total_kehadiran">Total Kehadiran</label>
                        <input type="number" id="total_kehadiran" name="total_kehadiran" class="form-control" readonly>
                    </div>


                    <!-- Bonus Kehadiran -->
                    <div class="form-group">
                        <label for="bonus_kehadiran">Bonus Kehadiran</label>
                        <input type="number" id="bonus_kehadiran" name="bonus_kehadiran" class="form-control" required placeholder="Masukkan bonus per kehadiran">
                    </div>

                    <!-- Total Bonus Kehadiran -->
                    <div class="form-group">
                        <label for="total_bonus_kehadiran">Total Bonus Kehadiran</label>
                        <input type="number" id="total_bonus_kehadiran" name="total_bonus_kehadiran" class="form-control" readonly>
                    </div>

                    <!-- Total Gaji Bersih -->
                    <div class="form-group">
                        <label for="total_gaji_bersih">Total Gaji Bersih</label>
                        <input type="number" id="total_gaji_bersih" name="total_gaji_bersih" class="form-control" readonly>
                    </div>

                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-success">Simpan Penggajian</button>
                        <a href="{{ route('penggajian.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Fetch tarif when a karyawan is selected
    document.getElementById('id_karyawan').addEventListener('change', function() {
        const karyawanId = this.value;
        if (karyawanId) {
            fetch(`/penggajian/get-tarif/${karyawanId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('tarif').value = data.tarif || 0;
                    calculateFields(); // Re-calculate fields if needed
                })
                .catch(error => console.error('Error fetching tarif:', error));
        } else {
            document.getElementById('tarif').value = 0;
        }
    });

    // Update the event listener for 'id_karyawan'
    document.getElementById('id_karyawan').addEventListener('change', function() {
        const karyawanId = this.value;

        if (karyawanId) {
            // Fetch tarif
            fetch(`/penggajian/get-tarif/${karyawanId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('tarif').value = data.tarif || 0;
                    calculateFields(); // Recalculate fields
                })
                .catch(error => console.error('Error fetching tarif:', error));

            // Fetch total_service
            fetch(`/penggajian/get-total-service/${karyawanId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('total_service').value = data.total_service || 0;
                    calculateFields(); // Recalculate fields
                })
                .catch(error => console.error('Error fetching total_service:', error));
        } else {
            document.getElementById('tarif').value = 0;
            document.getElementById('total_service').value = 0;
        }
    });

    document.getElementById('id_karyawan').addEventListener('change', function() {
        const karyawanId = this.value;

        if (karyawanId) {
            // Fetch tarif
            fetch(`/penggajian/get-tarif/${karyawanId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('tarif').value = data.tarif || 0;
                    calculateFields();
                })
                .catch(error => console.error('Error fetching tarif:', error));

            // Fetch total_service
            fetch(`/penggajian/get-total-service/${karyawanId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('total_service').value = data.total_service || 0;
                    calculateFields();
                })
                .catch(error => console.error('Error fetching total_service:', error));

            // Fetch total_kehadiran
            fetch(`/penggajian/get-total-kehadiran/${karyawanId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('total_kehadiran').value = data.total_kehadiran || 0;
                    calculateFields();
                })
                .catch(error => console.error('Error fetching total_kehadiran:', error));
        } else {
            document.getElementById('tarif').value = 0;
            document.getElementById('total_service').value = 0;
            document.getElementById('total_kehadiran').value = 0;
        }
    });




    // Event listeners for inputs affecting calculations
    document.getElementById('bonus').addEventListener('input', calculateFields);
    document.getElementById('total_service').addEventListener('input', calculateFields);
    document.getElementById('total_kehadiran').addEventListener('input', calculateFields);
    document.getElementById('bonus_kehadiran').addEventListener('input', calculateFields);

    function calculateFields() {
        const tarif = parseFloat(document.getElementById('tarif').value) || 0;
        const bonus = parseFloat(document.getElementById('bonus').value) || 0;
        const totalService = parseFloat(document.getElementById('total_service').value) || 0;
        const totalKehadiran = parseFloat(document.getElementById('total_kehadiran').value) || 0;
        const bonusKehadiran = parseFloat(document.getElementById('bonus_kehadiran').value) || 0;

        // Calculate bonus_service and total_bonus_kehadiran
        const bonusService = (bonus / 100) * totalService;
        document.getElementById('bonus_service').value = bonusService;

        const totalBonusKehadiran = totalKehadiran * bonusKehadiran;
        document.getElementById('total_bonus_kehadiran').value = totalBonusKehadiran;

        // Calculate total_gaji_bersih
        const totalGajiBersih = tarif + bonusService + totalBonusKehadiran;
        document.getElementById('total_gaji_bersih').value = totalGajiBersih;
    }
</script>
@endsection