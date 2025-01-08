@extends('layouts.frontend')

@section('content')
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Neraca Saldo</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                            class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('neraca-saldo') }}">neraca-saldo</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- DataTable for COA -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Neraca Saldo</h5>
                            {{-- <div class="card-header-right">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#addmodal">Tambah Data</button>
                        </div> --}}
                        </div>
                        <div class="card-body">
                            <div class="dt-responsive table-responsive">
                                <link rel="stylesheet"
                                    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
                                <table id="simpletable" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>Akun</th>
                                            <th>Total Debit</th>
                                            <th>Total Kredit</th>
                                            <th>Saldo Awal</th> <!-- Added Saldo Awal column -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $totalDebit = 0;
                                        $totalCredit = 0;
                                        @endphp
                                        @foreach($totalBalances->where('id_perusahaan', auth()->user()->id_perusahaan) as $coa)
                                        @php
                                        // Use the total debit and credit values directly
                                        $coaDebit = $coa->total_debit;
                                        $coaCredit = $coa->total_credit;
                                        $totalDebit += $coaDebit;
                                        $totalCredit += $coaCredit;
                                        @endphp
                                        <tr>
                                            <td>{{ $coa->kode_akun }} - {{ $coa->nama_akun }}</td>
                                            <td>{{ number_format($coaDebit, 2) }}</td>
                                            <td>{{ number_format($coaCredit, 2) }}</td>
                                            <td>{{ number_format($coa->saldo_awal, 2) }}</td> <!-- Display Saldo Awal here -->
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="1"><strong>Total Keseluruhan</strong></td>
                                            <td><strong>{{ number_format($totalDebit, 2) }}</strong></td>
                                            <td><strong>{{ number_format($totalCredit, 2) }}</strong></td>
                                            <td><strong>{{ number_format($totalDebit - $totalCredit, 2) }}</strong></td> <!-- Total Saldo Awal here -->
                                        </tr>
                                    </tfoot>                                               
                                </table>
                            </div>
                            {{-- <div class="text-right mt-3">
                                <!-- Align "Kembali" button to the right and link it to the dashboard -->
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali</a>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <!-- DataTable for COA end -->
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
@endsection
