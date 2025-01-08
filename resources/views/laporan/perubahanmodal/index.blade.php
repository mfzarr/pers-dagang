@extends('layouts.frontend')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Laporan Perubahan Modal</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item active">Laporan Perubahan Modal</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Filter Laporan Perubahan Modal</h5>
                <form action="{{ route('perubahan-modal.index') }}" method="GET" class="form-inline">
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="tanggal" class="sr-only">Tanggal</label>
                        <input type="month" class="form-control" id="tanggal" name="tanggal" 
                               value="{{ request('tanggal', date('Y-m')) }}">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Filter</button>
                </form>
            </div>

            <div class="card-body">
                <!-- Header -->
                <div class="text-center mb-4">
                    <h4>{{ $namaPerusahaan }}</h4>
                    <h5>Laporan Perubahan Modal</h5>
                    <h5>{{ $namaBulan }}</h5>
                </div>

                <!-- Content using monospace font for better alignment -->
                <div style="font-family: 'calibri';">
                    <!-- Modal Awal -->
                    <div class="row mb-2">
                        <div class="col-2">3101</div>
                        <div class="col-6">Modal Investor {{ date('j', strtotime($startOfMonth)) }} {{ $namaBulan }}</div>
                        <div class="col-4 text-right">Rp {{ number_format($modalAwal, 0, ',', '.') }}</div>
                    </div>

                    <!-- Laba -->
                    <div class="row mb-2">
                        <div class="col-2"></div>
                        <div class="col-6">Laba</div>
                        <div class="col-4 text-right">Rp {{ number_format($laba, 0, ',', '.') }}</div>
                    </div>

                    <!-- Prive (if exists) -->
                    @if($prive > 0)
                    <div class="row mb-2">
                        <div class="col-2">3102</div>
                        <div class="col-6">Prive</div>
                        <div class="col-4 text-right">(Rp {{ number_format($prive, 0, ',', '.') }})</div>
                    </div>
                    @endif

                    <!-- Laba dikurangi Prive -->
                    <div class="row mb-2">
                        <div class="col-2"></div>
                        <div class="col-6">Laba - Prive</div>
                        <div class="col-4 text-right">Rp {{ number_format($laba_prive, 0, ',', '.') }}</div>
                    </div>

                    <!-- Modal Akhir -->
                    <div class="row mt-3" style="border-top: 2px solid black; padding-top: 10px;">
                        <div class="col-2">3101</div>
                        <div class="col-6">Modal Investor {{ date('j', strtotime($endOfMonth)) }} {{ $namaBulan }}</div>
                        <div class="col-4 text-right"><strong>Rp {{ number_format($modal_akhir, 0, ',', '.') }}</strong></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .row {
        align-items: center;
        margin-bottom: 5px;
    }
    .text-right {
        text-align: right !important;
    }
    .mb-2 {
        margin-bottom: 0.5rem !important;
    }
    .mt-3 {
        margin-top: 1rem !important;
    }
    .card-body {
        padding: 2rem;
    }
</style>
@endpush

@endsection