@extends('layouts.frontend')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Laporan Neraca</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="neraca">Neraca</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Filter Laporan Neraca</h5>
                <form action="{{ route('neraca.index') }}" method="GET" class="form-inline">
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="tanggal" class="sr-only">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" 
                               value="{{ request('tanggal', date('Y-m-d')) }}">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Filter</button>
                </form>
            </div>

            <div class="card-body">
                <div class="text-center mb-4">
                    <h4>{{ $namaPerusahaan }}</h4>
                    <h5>Laporan Keuangan {{ $namaBulan }}</h5>
                    <h5>Neraca</h5>
                </div>

                <div class="row">
                    <!-- Left Column - Assets -->
                    <div class="col-md-6">
                        <!-- Current Assets -->
                        <h6>Aktiva Lancar</h6>
                        @foreach($currentAssets as $asset)
                        <div class="row">
                            <div class="col-2">{{ $asset->kode_akun }}</div>
                            <div class="col-6">{{ $asset->nama_akun }}</div>
                            <div class="col-4 text-right">Rp {{ number_format($asset->ending_balance, 0, ',', '.') }}</div>
                        </div>
                        @endforeach
                        <div class="row font-weight-bold mb-4">
                            <div class="col-8">Jumlah Aktiva Lancar</div>
                            <div class="col-4 text-right">Rp {{ number_format($totalCurrentAssets, 0, ',', '.') }}</div>
                        </div>

                        <!-- Fixed Assets -->
                        <h6>Aktiva Tetap</h6>
                        @foreach($fixedAssets as $asset)
                        <div class="row">
                            <div class="col-2">{{ $asset->kode_akun }}</div>
                            <div class="col-6">{{ $asset->nama_akun }}</div>
                            <div class="col-4 text-right">Rp {{ number_format($asset->asset_value, 0, ',', '.') }}</div>
                        </div>
                        @if($asset->accumulated_depreciation != 0)
                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-6">Akum. Peny. {{ $asset->nama_akun }}</div>
                            <div class="col-4 text-right">-Rp {{ number_format(abs($asset->accumulated_depreciation), 0, ',', '.') }}</div>
                        </div>
                        <div class="row">
                            <div class="col-8"></div>
                            <div class="col-4 text-right">Rp {{ number_format($asset->net_value, 0, ',', '.') }}</div>
                        </div>
                        @endif
                        @endforeach
                        <div class="row font-weight-bold mb-4">
                            <div class="col-8">Jumlah Aktiva Tetap</div>
                            <div class="col-4 text-right">Rp {{ number_format($totalFixedAssets, 0, ',', '.') }}</div>
                        </div>

                        <!-- Total Assets -->
                        <div class="row font-weight-bold">
                            <div class="col-8">Total Aktiva</div>
                            <div class="col-4 text-right">Rp {{ number_format($totalAssets, 0, ',', '.') }}</div>
                        </div>
                    </div>

                    <!-- Right Column - Liabilities & Equity -->
                    <div class="col-md-6">
                        <!-- Current Liabilities -->
                        <h6>Hutang Jangka Pendek</h6>
                        @foreach($currentLiabilities as $liability)
                        <div class="row">
                            <div class="col-2">{{ $liability->kode_akun }}</div>
                            <div class="col-6">{{ $liability->nama_akun }}</div>
                            <div class="col-4 text-right">Rp {{ number_format($liability->ending_balance, 0, ',', '.') }}</div>
                        </div>
                        @endforeach
                        <div class="row font-weight-bold mb-4">
                            <div class="col-8">Jumlah Hutang Jangka Pendek</div>
                            <div class="col-4 text-right">Rp {{ number_format($totalCurrentLiabilities, 0, ',', '.') }}</div>
                        </div>

                        <!-- Equity -->
                        <h6>Modal</h6>
                        @foreach($equity as $item)
                        <div class="row">
                            <div class="col-2">{{ $item->kode_akun }}</div>
                            <div class="col-6">{{ $item->nama_akun }} {{ \Carbon\Carbon::parse($tanggal)->format('d F Y') }}</div>
                            <div class="col-4 text-right">Rp {{ number_format($item->ending_balance, 0, ',', '.') }}</div>
                        </div>
                        @endforeach
                        <div class="row font-weight-bold mb-4">
                            <div class="col-8">Total Modal</div>
                            <div class="col-4 text-right">Rp {{ number_format($totalEquity, 0, ',', '.') }}</div>
                        </div>

                        <!-- Total Liabilities & Equity -->
                        <div class="row font-weight-bold">
                            <div class="col-8">Total Pasiva</div>
                            <div class="col-4 text-right">Rp {{ number_format($totalLiabilitiesEquity, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .row {
        margin-bottom: 5px;
    }
    h6 {
        font-weight: bold;
        margin-top: 15px;
        margin-bottom: 10px;
    }
    .breadcrumb-item {
        font-size: 14px;
    }
</style>
@endpush

@endsection
