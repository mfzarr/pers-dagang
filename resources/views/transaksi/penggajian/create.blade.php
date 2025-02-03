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
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                            class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('penggajian.index') }}">Penggajian</a></li>
                                <li class="breadcrumb-item active"><a>Tambah Penggajian</a></li>
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
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Tanggal Penggajian -->
                                <div class="form-group">
                                    <label for="tanggal_penggajian">Tanggal Penggajian</label>
                                    <input type="date" id="tanggal_penggajian" name="tanggal_penggajian" class="form-control" required>
                                    @error('tanggal_penggajian')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Karyawan -->
                                <div class="form-group">
                                    <label for="id_karyawan">Karyawan</label>
                                    <select id="id_karyawan" name="id_karyawan" class="form-control" required>
                                        <option value="">Pilih Karyawan</option>
                                        @foreach ($karyawan->where('status', 'aktif') as $emp)
                                            <option value="{{ $emp->id_karyawan }}">{{ $emp->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_karyawan')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Tarif -->
                                <div class="form-group">
                                    <label for="tarif">Tarif</label>
                                    <input type="number" id="tarif" name="tarif" class="form-control" required readonly>
                                    @error('tarif')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Bonus Lembur -->
                                <div class="form-group">
                                    <label for="lembur">Bonus Lembur</label>
                                    <input type="number" id="lembur" name="lembur" class="form-control" required placeholder="Masukkan nominal bonus lembur">
                                    @error('lembur')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="tunjangan_makan">Tunjangan Makan</label>
                                    <input type="number" id="tunjangan_makan" name="tunjangan_makan" class="form-control" required placeholder="Masukkan nominal tunjangan makan">
                                    @error('tunjangan_makan')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="tunjangan_jabatan">Tunjangan Jabatan</label>
                                    <input type="number" id="tunjangan_jabatan" name="tunjangan_jabatan" class="form-control" required placeholder="Masukkan nominal tunjangan jabatan">
                                    @error('tunjangan_jabatan')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="potongan_gaji">Potongan Gaji</label>
                                    <input type="number" id="potongan_gaji" name="potongan_gaji" class="form-control" required placeholder="Masukkan nominal potongan gaji">
                                    @error('potongan_gaji')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Detail Potongan -->
                                <div class="form-group">
                                    <label for="detail_potongan">Detail Potongan</label>
                                    <input type="text" id="detail_potongan" name="detail_potongan" class="form-control" required placeholder="Masukkan detail potongan">
                                    @error('detail_potongan')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Bonus (%) -->
                                <div class="form-group">
                                    <label for="bonus">Bonus (%)</label>
                                    <input type="number" id="bonus" name="bonus" class="form-control" required placeholder="Masukkan persentase bonus">
                                    @error('bonus')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Total Service -->
                                <div class="form-group">
                                    <label for="total_service">Total Service</label>
                                    <input type="number" id="total_service" name="total_service" class="form-control" readonly>
                                    @error('total_service')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Bonus Service -->
                                <div class="form-group">
                                    <label for="bonus_service">Bonus Service</label>
                                    <input type="number" id="bonus_service" name="bonus_service" class="form-control" readonly>
                                    @error('bonus_service')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Total Kehadiran -->
                                <div class="form-group">
                                    <label for="total_kehadiran">Total Kehadiran</label>
                                    <input type="number" id="total_kehadiran" name="total_kehadiran" class="form-control" readonly>
                                    @error('total_kehadiran')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Bonus Kehadiran -->
                                <div class="form-group">
                                    <label for="bonus_kehadiran">Bonus Kehadiran</label>
                                    <input type="number" id="bonus_kehadiran" name="bonus_kehadiran" class="form-control" required placeholder="Masukkan bonus per kehadiran">
                                    @error('bonus_kehadiran')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Total Bonus Kehadiran -->
                                <div class="form-group">
                                    <label for="total_bonus_kehadiran">Total Bonus Kehadiran</label>
                                    <input type="number" id="total_bonus_kehadiran" name="total_bonus_kehadiran" class="form-control" readonly>
                                    @error('total_bonus_kehadiran')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Total Gaji Bersih -->
                                <div class="form-group">
                                    <label for="total_gaji_bersih">Total Gaji Bersih</label>
                                    <input type="number" id="total_gaji_bersih" name="total_gaji_bersih" class="form-control" readonly>
                                    @error('total_gaji_bersih')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
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
        // Fetch data when a karyawan is selected
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
        document.getElementById('lembur').addEventListener('input', calculateFields);
        document.getElementById('tunjangan_makan').addEventListener('input', calculateFields);
        document.getElementById('tunjangan_jabatan').addEventListener('input', calculateFields);
        document.getElementById('potongan_gaji').addEventListener('input', calculateFields);

        function calculateFields() {
            const tarif = parseFloat(document.getElementById('tarif').value) || 0;
            const bonus = parseFloat(document.getElementById('bonus').value) || 0;
            const totalService = parseFloat(document.getElementById('total_service').value) || 0;
            const totalKehadiran = parseFloat(document.getElementById('total_kehadiran').value) || 0;
            const bonusKehadiran = parseFloat(document.getElementById('bonus_kehadiran').value) || 0;
            const tunjangan_makan = parseFloat(document.getElementById('tunjangan_makan').value) || 0;
            const tunjangan_jabatan = parseFloat(document.getElementById('tunjangan_jabatan').value) || 0;
            const lembur = parseFloat(document.getElementById('lembur').value) || 0;
            const potongan_gaji = parseFloat(document.getElementById('potongan_gaji').value) || 0;

            // Calculate bonus_service and total_bonus_kehadiran
            const bonusService = (bonus / 100) * totalService;
            document.getElementById('bonus_service').value = bonusService;

            const totalBonusKehadiran = totalKehadiran * bonusKehadiran;
            document.getElementById('total_bonus_kehadiran').value = totalBonusKehadiran;

            // Calculate total_gaji_bersih
            const totalGajiBersih = tarif + bonusService + totalBonusKehadiran + lembur + tunjangan_makan +
                tunjangan_jabatan - potongan_gaji;
            document.getElementById('total_gaji_bersih').value = totalGajiBersih;
        }
    </script>
@endsection
