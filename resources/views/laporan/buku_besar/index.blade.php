@extends('layouts.frontend')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Buku Besar</h5>
                <!-- View Switch Buttons -->
                <div>
                    <button type="button" class="btn btn-dark" onclick="switchView(1)">1</button>
                    <button type="button" class="btn btn-dark" onclick="switchView(2)">2</button>
                    <button type="button" class="btn btn-dark" onclick="switchView(3)">3</button>
                </div>
            </div>

            <div class="card-body">
                <!-- View 1: Buku Besar per Akun -->
                <div id="view1" class="view-section" style="display: block;">
                    <!-- Form to Select Account -->
                    <form method="GET" action="{{ route('buku-besar') }}" class="mb-4 d-flex align-items-center">
                        <!-- Account Selector -->
                        <div class="mr-3">
                            <label for="account" class="col-form-label">Pilih Akun</label>
                            <select name="account" id="account" class="form-control" required>
                                <option value="" disabled selected>Pilih Akun</option>
                                @foreach($coas as $coa)
                                <option value="{{ $coa->id_coa }}" {{ $selectedAccount == $coa->id_coa ? 'selected' : '' }}>
                                    {{ $coa->kode_akun }} - {{ $coa->nama_akun }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Month Selector -->
                        <div class="mr-3">
                            <label for="month" class="col-form-label">Pilih Bulan</label>
                            <select name="month" id="month" class="form-control" required>
                                @foreach($months as $monthNumber => $monthName)
                                <option value="{{ $monthNumber }}" {{ $monthNumber == $selectedMonth ? 'selected' : '' }}>
                                    {{ $monthName }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Year Selector -->
                        <div class="mr-3">
                            <label for="year" class="col-form-label">Pilih Tahun</label>
                            <select name="year" id="year" class="form-control" required>
                                <option value="{{ $selectedYear }}" selected>{{ $selectedYear }}</option>
                                <!-- Optionally, you can add other years, e.g., previous year, next year, etc. -->
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit" class="btn btn-primary">Lihat Buku Besar</button>
                        </div>
                    </form>



                    <div class="text-center mb-4">
                        <!-- Display Transactions -->
                        @if($selectedAccount)
                        @php
                        // Find the selected Coa by ID
                        $selectedCoa = $coas->firstWhere('id_coa', $selectedAccount);
                        @endphp

                        <h4>Buku Besar</h4>
                        <h6>Akun {{ $selectedCoa->kode_akun }} - {{ $selectedCoa->nama_akun }}</h6>
                        <h6>{{ \Carbon\Carbon::create($selectedYear, $selectedMonth)->translatedFormat('F Y') }}</h6>
                    </div>


                    <div class="table-responsive mt-4">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Debit</th>
                                    <th>Kredit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- New row to display saldo_awal -->
                                <tr>
                                    <td colspan="2"><strong>Saldo Awal</strong></td>
                                    <td colspan="2">Rp{{ number_format($saldoAwal) }}</td>
                                </tr>

                                <!-- Transactions -->
                                @php
                                $totalDebit = 0;
                                $totalCredit = 0;
                                $runningBalance = $saldoAwal; // Start with saldo_awal
                                @endphp
                                @foreach($transactions as $transaction)
                                @php
                                // Update the running balance
                                if ($transaction->debit) {
                                $runningBalance += $transaction->debit;
                                }
                                if ($transaction->credit) {
                                $runningBalance -= $transaction->credit;
                                }
                                $totalDebit += $transaction->debit ?? 0;
                                $totalCredit += $transaction->credit ?? 0;
                                @endphp
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($transaction->tanggal_jurnal)->format('d M') }}</td>
                                    <td>{{ $transaction->nama_akun }}</td>
                                    <td>Rp{{ $transaction->debit ? number_format($transaction->debit) : '0' }}</td>
                                    <td>Rp{{ $transaction->credit ? number_format($transaction->credit) : '0' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2"><strong>Total</strong></td>
                                    <td><strong>Rp{{ number_format($totalDebit) }}</strong></td>
                                    <td><strong>Rp{{ number_format($totalCredit) }}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><strong>Saldo Akhir</strong></td>
                                    <td colspan="2"><strong>Rp{{ number_format($runningBalance) }}</strong></td> <!-- Display running balance -->
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    @else
                    <p class="text-muted">Silakan pilih akun untuk melihat Buku Besar.</p>
                    @endif
                </div>



                <!-- View 2: Total Saldo Semua Akun -->
                <div id="view2" class="view-section" style="display: none;">
                    <h6>Total Saldo Semua Akun</h6>

                    <div class="table-responsive mt-4">
                        <table class="table table-striped table-bordered">
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
                                @foreach($totalBalances as $coa)
                                @php
                                // Use the total debit and credit values directly
                                $coaDebit = $coa->total_debit;
                                $coaCredit = $coa->total_credit;
                                $totalDebit += $coaDebit;
                                $totalCredit += $coaCredit;
                                @endphp
                                <tr>
                                    <td>{{ $coa->kode_akun }} - {{ $coa->nama_akun }}</td>
                                    <td>Rp{{ number_format($coaDebit) }}</td>
                                    <td>Rp{{ number_format($coaCredit) }}</td>
                                    <td>Rp{{ number_format($coa->saldo_awal) }}</td> <!-- Display Saldo Awal here -->
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="1"><strong>Total Keseluruhan</strong></td>
                                    <td><strong>Rp{{ number_format($totalDebit) }}</strong></td>
                                    <td><strong>Rp{{ number_format($totalCredit) }}</strong></td>
                                    <td><strong>Rp{{ number_format($totalDebit - $totalCredit) }}</strong></td> <!-- Total Saldo Awal here -->
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- View 3: Semua Transaksi -->
                <div id="view3" class="view-section" style="display: none;">
                    <h6>Semua Transaksi</h6>

                    <div class="table-responsive mt-4">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Akun</th>
                                    <th>Debit</th>
                                    <th>Kredit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allTransactions as $transaction)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($transaction->tanggal_jurnal)->format('d M') }}</td>
                                    <td>{{ $transaction->coa->nama_akun }}</td>
                                    <td>Rp{{ number_format($transaction->debit) }}</td>
                                    <td>Rp{{ number_format($transaction->credit) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2"><strong>Total Keseluruhan</strong></td>
                                    <td><strong>Rp{{ number_format($grandTotalDebit) }}</strong></td>
                                    <td><strong>Rp{{ number_format($grandTotalCredit) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Switch views on button click
    function switchView(viewNumber) {
        // Hide all views
        document.querySelectorAll('.view-section').forEach(function(view) {
            view.style.display = 'none';
        });

        // Show the selected view
        if (viewNumber === 1) {
            document.getElementById('view1').style.display = 'block';
        } else if (viewNumber === 2) {
            document.getElementById('view2').style.display = 'block';
        } else if (viewNumber === 3) {
            document.getElementById('view3').style.display = 'block';
        }
    }
</script>
@endsection