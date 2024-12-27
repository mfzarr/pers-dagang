@extends('layouts.frontend')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Jadwal Penyusutan Aset</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('aset.index') }}">Aset</a></li>
                            <li class="breadcrumb-item"><a>Depresiasi Aset</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Penyusutan Aset: {{ $asset->nama_asset }}</h5>
            </div>
            <div class="card-body">
                <table id="simpletable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Tahun</th>
                            <th>Biaya Penyusutan</th>
                            <th>Akumulasi Penyusutan</th>
                            <th>Nilai Buku</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($depreciation_schedule as $schedule)
                        <tr>
                            <td>{{ $schedule['tahun'] }}</td>
                            <td>{{ number_format($schedule['biaya_penyusutan'], 2) }}</td>
                            <td>{{ number_format($schedule['akumulasi_penyusutan'], 2) }}</td>
                            <td>{{ number_format($schedule['nilai_buku'], 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-right">
                    <a href="{{ route('aset.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
