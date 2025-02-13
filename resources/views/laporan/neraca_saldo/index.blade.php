@extends('layouts.frontend')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Neraca Saldo</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Laporan</a></li>
                            <li class="breadcrumb-item"><a href="#!">Neraca Saldo</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Neraca Saldo</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('neraca-saldo') }}">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="month">Bulan</label>
                                        <select name="month" id="month" class="form-control">
                                            @foreach($months as $key => $value)
                                                <option value="{{ $key }}" {{ $selectedMonth == $key ? 'selected' : '' }}>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="year">Tahun</label>
                                        <input type="number" name="year" id="year" class="form-control" value="{{ $selectedYear }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button type="submit" class="btn btn-primary btn-block">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        
                        <div class="table-responsive">
                            <table id="basic-btn" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>Kode Akun</th>
                                        <th>Nama Akun</th>
                                        <th>Debit</th>
                                        <th>Kredit</th>
                                        <th>Saldo Debit</th>
                                        <th>Saldo Kredit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($totalBalances as $balance)
                                    <tr>
                                        <td>{{ $balance->kode_akun }}</td>
                                        <td>{{ $balance->nama_akun }}</td>
                                        <td>Rp{{ number_format($balance->total_debit) }}</td>
                                        <td>Rp{{ number_format($balance->total_credit) }}</td>
                                        <td>Rp{{ number_format($balance->saldo_debit) }}</td>
                                        <td>Rp{{ number_format($balance->saldo_kredit) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2">Total</th>
                                        <th>Rp{{ number_format($grandTotalDebit) }}</th>
                                        <th>Rp{{ number_format($grandTotalCredit) }}</th>
                                        <th>Rp{{ number_format($grandTotalSaldoDebit) }}</th>
                                        <th>Rp{{ number_format($grandTotalSaldoKredit) }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection