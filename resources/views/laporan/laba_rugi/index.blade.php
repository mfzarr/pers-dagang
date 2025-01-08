@extends('layouts.frontend')

@section('content')
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Laporan Laba Rugi</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                            class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('jurnal-umum.index') }}">Jurnal Umum</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5>Laporan Laba Rugi</h5>
                </div>
                <div class="card-body">
                    <!-- Date Filter Form -->
                    <form method="GET" action="{{ route('laba-rugi.index') }}" class="mb-4">
                        <div class="col-md-10">
                            <label for="bulan">Pilih Bulan:</label>
                            <input type="month" name="bulan" id="bulan" class="form-control"
                                value="{{ $selectedMonth }}">
                        </div>
                        <div class="col-md-2 align-self-end">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </form>
                    <!-- End of Date Filter Form -->

                    <!-- Laporan Laba Rugi -->
                    <div class="card">
                        <div class="card-body">
                            <!-- Header -->
                            <div class="text-center mb-4">
                                <h4>{{ auth()->user()->perusahaan->nama ?? 'Perusahaan' }}</h4>
                                <h5>Laporan Laba Rugi</h5>
                                <p>Periode: {{ Carbon\Carbon::parse($selectedMonth)->format('F Y') }}</p>
                            </div>

                            <!-- Content -->
                            <div class="row">
                                <div class="col-12">
                                    <!-- Pendapatan Section -->
                                    <div class="mb-4">
                                        <h6 class="font-weight-bold">Pendapatan</h6>
                                        @foreach ($pendapatan as $item)
                                            <div class="row mb-2">
                                                <div class="col-2">{{ $item->kode_akun }}</div>
                                                <div class="col-6">{{ $item->nama_akun }}</div>
                                                <div class="col-4 text-right">Rp
                                                    {{ number_format($item->saldo, 0, ',', '.') }}</div>
                                            </div>
                                        @endforeach
                                        <div class="row font-weight-bold">
                                            <div class="col-8">Total Pendapatan</div>
                                            <div class="col-4 text-right">Rp
                                                {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                                        </div>
                                    </div>

                                    <!-- Biaya Section -->
                                    <div class="mb-4">
                                        <h6 class="font-weight-bold">Biaya</h6>
                                        @foreach ($biaya as $item)
                                            <div class="row mb-2">
                                                <div class="col-2">{{ $item->kode_akun }}</div>
                                                <div class="col-6">{{ $item->nama_akun }}</div>
                                                <div class="col-4 text-right">Rp
                                                    {{ number_format($item->saldo, 0, ',', '.') }}</div>
                                            </div>
                                        @endforeach
                                        <div class="row font-weight-bold">
                                            <div class="col-8">Total Biaya</div>
                                            <div class="col-4 text-right">Rp {{ number_format($totalBiaya, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Laba/Rugi Section -->
                                    <div class="row font-weight-bold">
                                        <div class="col-8">Laba/Rugi Bersih</div>
                                        <div class="col-4 text-right">Rp {{ number_format($labaRugi, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    /* Add these styles to match the format better */
    .card-body {
        font-family: 'Tahoma', sans-serif;
    }

    .row {
        margin-left: 20px;
        margin-right: 20px;
    }

    .text-right {
        text-align: right !important;
    }

    .mb-2 {
        margin-bottom: 0.5rem !important;
    }

    .mb-4 {
        margin-bottom: 1.5rem !important;
    }

    input[type="month"] {
        height: 38px;
    }
</style>