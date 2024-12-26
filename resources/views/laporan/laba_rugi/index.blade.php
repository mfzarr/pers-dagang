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
                            <li class="breadcrumb-item"><a href="/"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item active">Laporan Laba Rugi</li>
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
                    <div class="row">
                        <div class="col-md-5">
                            <label for="start_date">Dari Tanggal:</label>
                            <input type="date" name="start_date" id="start_date" class="form-control"
                                value="{{ request('start_date') }}">
                        </div>
                        <div class="col-md-5">
                            <label for="end_date">Sampai Tanggal:</label>
                            <input type="date" name="end_date" id="end_date" class="form-control"
                                value="{{ request('end_date') }}">
                        </div>
                        <div class="col-md-2 align-self-end">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>
                <!-- End of Date Filter Form -->

                <!-- Pendapatan and Biaya Tables -->
                <h6><strong>Penjualan</strong></h6>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Kode Akun</th>
                            <th>Keterangan</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendapatan as $item)
                        <tr>
                            <td>{{ $item->kode_akun }}</td>
                            <td>{{ $item->nama_akun }}</td>
                            <td class="text-right">{{ number_format($item->penjualan_sum_total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- <h6><strong>Total Penjualan:</strong> <span class="float-right">Rp{{ number_format($totalPendapatan) }}</span></h6><br> --}}

                <h6><strong>Harga Pokok Penjualan (HPP)</strong></h6>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Kode Akun</th>
                            <th>Keterangan</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hpp as $item)
                        <tr>
                            <td>{{ $item->kode_akun }}</td>
                            <td>{{ $item->nama_akun }}</td>
                            <td class="text-right">Rp{{ number_format($item->penjualan_sum_hpp) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <h6><strong>Total HPP:</strong> <span class="float-right">Rp{{ number_format($totalHpp) }}</span></h6><br>

                <h6><strong>Laba Kotor = Penjualan - HPP :</strong> <span class="float-right">Rp{{ number_format($labakotor) }}</span></h6><br><br>

                <h6><strong>Biaya</strong></h6>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Kode Akun</th>
                            <th>Keterangan</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($biaya as $item)
                        <tr>
                            <td>{{ $item['kode_akun'] }}</td>
                            <td>{{ $item['nama_akun'] }}</td>
                            <td class="text-right">{{ number_format($item['total_harga'], 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <h6><strong>Total Biaya:</strong> <span class="float-right">Rp{{ number_format($totalBiaya) }}</span></h6><br><br>

                @if($labaRugi < 0)
                <h5><strong>Rugi:</strong> <span class="float-right">Rp{{ number_format(abs($labaRugi)) }}</span></h5>
                @else
                <h5><strong>Laba:</strong> <span class="float-right">Rp{{ number_format($labaRugi) }}</span></h5>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection