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
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <!-- Modal Awal -->
                            <tr>
                                <td class="text-center">3101</td>
                                <td>Modal Investor {{ date('j', strtotime($startOfMonth)) }} {{ $namaBulan }}</td>
                                <td class="text-right">Rp {{ number_format($modalAwal, 0, ',', '.') }}</td>
                            </tr>

                            <!-- Laba -->
                            <tr>
                                <td class="text-center"></td>
                                <td>Laba</td>
                                <td class="text-right">Rp {{ number_format($laba, 0, ',', '.') }}</td>
                            </tr>

                            <!-- Prive (if exists) -->
                            @if($prive > 0)
                            <tr>
                                <td class="text-center">3102</td>
                                <td>Prive</td>
                                <td class="text-right">(Rp {{ number_format($prive, 0, ',', '.') }})</td>
                            </tr>
                            @endif

                            <!-- Laba dikurangi Prive -->
                            <tr>
                                <td class="text-center"></td>
                                <td>Laba - Prive</td>
                                <td class="text-right">Rp {{ number_format($laba_prive, 0, ',', '.') }}</td>
                            </tr>

                            <!-- Modal Akhir -->
                            <tr class="font-weight-bold" style="border-top: 2px solid black;">
                                <td class="text-center">3101</td>
                                <td>Modal Investor {{ date('j', strtotime($endOfMonth)) }} {{ $namaBulan }}</td>
                                <td class="text-right">Rp {{ number_format($modal_akhir, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .table td, .table th {
        vertical-align: middle;
    }
    .font-weight-bold {
        font-weight: bold;
    }
</style>
@endpush

@endsection
