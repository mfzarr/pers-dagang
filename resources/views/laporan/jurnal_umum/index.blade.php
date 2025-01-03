@extends('layouts.frontend')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Jurnal Umum</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('jurnal-umum.index') }}">Jurnal Umum</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>List Jurnal Umum</h5>
            </div>

            <div class="card-body">
                <!-- Search Form -->
                <form method="GET" action="{{ route('jurnal-umum.index') }}" class="mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Search by Description" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-6">
                            <select name="filter" class="form-control" onchange="this.form.submit()">
                                <option value="">Filter by Nama Akun</option>
                                @foreach ($filters as $filter)
                                    <option value="{{ $filter->nama_akun }}" {{ request('filter') == $filter->nama_akun ? 'selected' : '' }}>
                                        {{ $filter->nama_akun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- <div class="col-md-3">
                            <select name="month" class="form-control" onchange="this.form.submit()">
                                <option value="">Filter by Month</option>
                                @foreach(range(1, 12) as $month)
                                    <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-secondary">Filter</button>
                        </div>
                    </div>
                </form>

                <!-- Ledger Table -->
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">Tanggal</th>
                                <th>Nama Akun</th>
                                <th>Nomor Akun</th>
                                <th>Debit</th>
                                <th>Credit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($groupedJurnals->sortBy(function($entries) {
                                return \Carbon\Carbon::parse($entries->first()->tanggal_jurnal);
                            }) as $entries)
                                @foreach($entries as $index => $entry)
                                    <tr>
                                        @if ($index == 0)
                                            <td rowspan="{{ $entries->count() }}" class="text-center font-weight-bold tanggal" style="font-size: 16px; margin-top: 8px;">
                                                {{ \Carbon\Carbon::parse($entry->tanggal_jurnal)->format('d/m/Y') }}
                                            </td>
                                        @endif
                                        <td class="{{ $entry->credit > 0 ? 'indent' : '' }}">{{ $entry->nama_akun }}</td>
                                        <td>{{ $entry->kode_akun }}</td>
                                        <td>Rp{{ $entry->debit == 0.00 ? '-' : number_format($entry->debit) }}</td>
                                        <td>Rp{{ $entry->credit == 0.00 ? '-' : number_format($entry->credit) }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                            @if($groupedJurnals->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center">Belum Ada Penjurnalan.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="{{ $jurnals->previousPageUrl() }}" class="btn btn-outline-primary btn-sm {{ $jurnals->onFirstPage() ? 'disabled' : '' }}">&laquo; Previous</a>
                    <span>Page {{ $jurnals->currentPage() }} of {{ $jurnals->lastPage() }}</span>
                    <a href="{{ $jurnals->nextPageUrl() }}" class="btn btn-outline-primary btn-sm {{ $jurnals->hasMorePages() ? '' : 'disabled' }}">Next &raquo;</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    td.indent {
        padding-left: 40px; /* Indentation for child rows */
    }

</style>

@endsection
