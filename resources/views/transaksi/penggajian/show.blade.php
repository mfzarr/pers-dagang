@extends('layouts.frontend')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Detail Penggajian</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('penggajian.index') }}">Penggajian</a></li>
                            <li class="breadcrumb-item active">Detail Penggajian</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Detail Penggajian</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Penggajian Information -->
                    <div class="col-md-6">
                        <h6>Informasi Penggajian</h6>
                        <table class="table table-striped">
                            <tr>
                                <th>No Transaksi</th>
                                <td>{{ $penggajian->no_transaksi_gaji }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Penggajian</th>
                                <td>{{ $penggajian->tanggal_penggajian }}</td>
                            </tr>
                            <tr>
                                <th>Total Gaji Bersih</th>
                                <td>{{ number_format($penggajian->total_gaji_bersih, 2) }}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Karyawan Information -->
                    <div class="col-md-6">
                        <h6>Informasi Karyawan</h6>
                        <table class="table table-striped">
                            <tr>
                                <th>Nama Karyawan</th>
                                <td>{{ $penggajian->karyawan->nama }}</td>
                            </tr>
                            <tr>
                                <th>Jabatan</th>
                                <td>{{ $penggajian->karyawan->jabatan->nama }}</td>
                            </tr>

                            <tr>
                                <th>Tarif</th>
                                <td>{{ number_format($penggajian->tarif, 2) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Detailed Breakdown -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <h6>Rincian Penggajian</h6>
                        <table class="table table-bordered">
                            <tr>
                                <th>Bonus (%)</th>
                                <td>{{ $penggajian->bonus }}</td>
                            </tr>
                            <tr>
                                <th>Total Service</th>
                                <td>{{ number_format($penggajian->total_service, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Bonus Service</th>
                                <td>{{ number_format($penggajian->bonus_service, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Total Kehadiran</th>
                                <td>{{ $penggajian->total_kehadiran }}</td>
                            </tr>
                            <tr>
                                <th>Bonus Kehadiran</th>
                                <td>{{ number_format($penggajian->bonus_kehadiran, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Total Bonus Kehadiran</th>
                                <td>{{ number_format($penggajian->total_bonus_kehadiran, 2) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Back Button -->
                <div class="text-right">
                    <a href="{{ route('penggajian.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection