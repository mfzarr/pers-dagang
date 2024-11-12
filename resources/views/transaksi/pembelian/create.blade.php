{{-- resources/views/layouts/transaksi/create.blade.php --}}
@extends('layouts.frontend')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Create Pembelian</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pembelian.index') }}">Pembelian</a></li>
                            <li class="breadcrumb-item"><a href="#!">Create Pembelian</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Create New Pembelian</h5>
                    </div>
                    <div class="card-body">
                        {{-- Display errors if any --}}
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('pembelian.store') }}" method="POST">
                            @csrf

                            {{-- Tanggal Pembelian --}}
                            <div class="form-group">
                                <label for="tanggal" class="form-label">Tanggal Pembelian</label>
                                <input type="date" id="tanggal" name="tanggal" class="form-control" required>
                            </div>

                            {{-- Supplier --}}
                            <div class="form-group">
                                <label for="supplier" class="form-label">Supplier</label>
                                <select id="supplier" name="supplier" class="form-control" required>
                                    <option value="">Select Supplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id_supplier }}">{{ $supplier->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Tipe Pembayaran --}}
                            <div class="form-group">
                                <label for="tipe_pembayaran" class="form-label">Tipe Pembayaran</label>
                                <select id="tipe_pembayaran" name="tipe_pembayaran" class="form-control" required>
                                    <option value="tunai">Tunai</option>
                                    <option value="kredit">Kredit</option>
                                </select>
                            </div>

                            {{-- Table for Barang Details --}}
                            <h5 class="mt-4">Barang Details</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="barangTable">
                                    <thead>
                                        <tr>
                                            <th>Barang</th>
                                            <th>Qty</th>
                                            <th>Harga</th>
                                            <th>Subtotal</th>
                                            <th>Dibayar</th>
                                            <th><button type="button" class="btn btn-sm btn-primary" onclick="addRow()">Add Row</button></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select name="barang[0][id_barang]" class="form-control" required>
                                                    <option value="">Select Barang</option>
                                                    @foreach($barang as $item)
                                                        <option value="{{ $item->id_barang }}">{{ $item->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input type="number" name="barang[0][qty]" class="form-control qty" required></td>
                                            <td><input type="number" name="barang[0][harga]" class="form-control harga" required></td>
                                            <td><input type="number" name="barang[0][subtotal]" class="form-control subtotal" readonly></td>
                                            <td><input type="number" name="barang[0][dibayar]" class="form-control" required></td>
                                            <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">Remove</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            {{-- Totals --}}
                            <div class="form-group">
                                <label for="total_dibayar" class="form-label">Total Dibayar</label>
                                <input type="number" id="total_dibayar" name="total_dibayar" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="total" class="form-label">Total</label>
                                <input type="number" id="total" name="total" class="form-control" readonly>
                            </div>

                            {{-- Submit --}}
                            <button type="submit" class="btn btn-success">Create Pembelian</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script to handle row addition, deletion, and calculations --}}
<script>
    function addRow() {
        const table = document.getElementById("barangTable").getElementsByTagName('tbody')[0];
        const rowCount = table.rows.length;
        const row = table.insertRow(rowCount);
        row.innerHTML = document.querySelector("#barangTable tbody tr").innerHTML.replace(/\[0\]/g, `[${rowCount}]`);
    }

    function removeRow(button) {
        const row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
        calculateTotals();
    }

    document.addEventListener('input', function (event) {
        if (event.target.classList.contains('qty') || event.target.classList.contains('harga')) {
            const row = event.target.closest('tr');
            const qty = row.querySelector('.qty').value || 0;
            const harga = row.querySelector('.harga').value || 0;
            const subtotal = qty * harga;
            row.querySelector('.subtotal').value = subtotal;
            calculateTotals();
        }
    });

    function calculateTotals() {
        let total = 0;
        let total_dibayar = 0;
        document.querySelectorAll('#barangTable tbody tr').forEach(row => {
            total += parseFloat(row.querySelector('.subtotal').value) || 0;
            total_dibayar += parseFloat(row.querySelector('[name*="dibayar"]').value) || 0;
        });
        document.getElementById('total').value = total;
        document.getElementById('total_dibayar').value = total_dibayar;
    }
</script>
@endsection
