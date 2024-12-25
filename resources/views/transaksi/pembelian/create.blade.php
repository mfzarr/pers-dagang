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
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('pembelian.store') }}" method="POST">
                                @csrf
                                {{-- Tipe Transaksi --}}
                                {{-- <div class="form-group">
                                <label for="id_coa" class="form-label">Tipe Transaksi</label>
                                <select id="id_coa" name="id_coa" class="form-control" required>
                                    <option value="">Select Tipe Transaksi</option>
                                    @foreach ($coa as $coaItem)
                                        <option value="{{ $coaItem->id_coa }}" {{ $coaItem->nama_akun == 'Pembelian' ? 'selected' : '' }}>{{ $coaItem->nama_akun }}</option>
                                    @endforeach
                                </select>                                
                            </div> --}}

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
                                        @foreach ($suppliers as $supplier)
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

                                {{-- Table for produk Details --}}
                                <h5 class="mt-4">Produk Details</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="produkTable">
                                        <thead>
                                            <tr>
                                                <th>Produk</th>
                                                <th>Qty</th>
                                                <th>Harga</th>
                                                <th>Subtotal</th>
                                                <th>Dibayar</th>
                                                <th>
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        onclick="addRow()">Add Row</button>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select name="produk[0][id_produk]" class="form-control produk-select"
                                                        onchange="updateHarga(this)" required>
                                                        <option value="">Select Produk</option>
                                                        @foreach ($produk as $item)
                                                            <option value="{{ $item->id_produk }}"
                                                                data-harga="{{ $item->hpp }}">{{ $item->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td><input type="number" name="produk[0][qty]" class="form-control qty"
                                                        required></td>
                                                <td><input type="number" name="produk[0][harga]" class="form-control harga"
                                                        readonly required></td>
                                                <td><input type="number" name="produk[0][subtotal]"
                                                        class="form-control subtotal" readonly></td>
                                                <td><input type="number" name="produk[0][dibayar]"
                                                        class="form-control dibayar" required></td>
                                                <td><button type="button" class="btn btn-sm btn-danger"
                                                        onclick="removeRow(this)">Remove</button></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td><strong>Total Dibayar</strong></td>
                                                <td colspan="3"></td>
                                                <td><input type="number" id="total_dibayar" class="form-control" readonly>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Total</strong></td>
                                                <td colspan="2"></td>
                                                <td><input type="number" id="total" class="form-control" readonly></td>
                                                <td colspan="2"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
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
        function updateHarga(selectElement) {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const harga = selectedOption.getAttribute('data-harga');
            const row = selectElement.closest('tr');
            row.querySelector('.harga').value = harga; // Set harga value
            calculateSubtotal(row.querySelector('.kuantitas'));
        }

        function addRow() {
            const table = document.getElementById("produkTable").getElementsByTagName('tbody')[0];
            const rowCount = table.rows.length;
            const row = table.insertRow(rowCount);
            row.innerHTML = document.querySelector("#produkTable tbody tr").innerHTML.replace(/\[0\]/g, `[${rowCount}]`);
        }

        function removeRow(button) {
            const row = button.parentNode.parentNode;
            row.parentNode.removeChild(row);
            calculateTotals();
        }

        document.getElementById('tipe_pembayaran').addEventListener('change', function() {
            const isTunai = this.value === 'tunai';

            // Loop through all rows and update 'dibayar' field based on payment type
            document.querySelectorAll('#produkTable tbody tr').forEach(row => {
                const dibayarInput = row.querySelector('[name*="dibayar"]');
                const subtotalInput = row.querySelector('.subtotal');

                if (isTunai) {
                    dibayarInput.value = subtotalInput.value; // Set dibayar to subtotal
                    dibayarInput.setAttribute('readonly', true); // Make it uneditable
                } else {
                    dibayarInput.value = ''; // Clear value if kredit is selected
                    dibayarInput.removeAttribute('readonly'); // Make it editable
                }
            });

            calculateTotals(); // Update totals after changing payment type
        });

        document.addEventListener('input', function(event) {
            if (event.target.classList.contains('qty') || event.target.classList.contains('harga')) {
                const row = event.target.closest('tr');
                const qty = parseFloat(row.querySelector('.qty').value) || 0;
                const harga = parseFloat(row.querySelector('.harga').value) || 0;
                const subtotal = qty * harga;
                row.querySelector('.subtotal').value = subtotal;

                // Automatically update 'dibayar' if payment type is tunai
                const tipePembayaran = document.getElementById('tipe_pembayaran').value;
                const dibayarInput = row.querySelector('[name*="dibayar"]');
                if (tipePembayaran === 'tunai') {
                    dibayarInput.value = subtotal;
                }

                calculateTotals(); // Recalculate totals on input change
            }
        });

        function calculateTotals() {
            let total = 0;
            let total_dibayar = 0;

            document.querySelectorAll('#produkTable tbody tr').forEach(row => {
                total += parseFloat(row.querySelector('.subtotal').value) || 0;
                total_dibayar += parseFloat(row.querySelector('[name*="dibayar"]').value) || 0;
            });

            document.getElementById('total').value = total;
            document.getElementById('total_dibayar').value = total_dibayar;
        }

        document.getElementById('produk[0][id_produk]').addEventListener('change', function() {
            var id_produk = this.value;

            fetch(`/get-harga/${id_produk}`)
                .then(response => response.json())
                .then(data => {
                    document.querySelector('.harga').value = data.harga;
                });
        }); // Trigger change event on page load
    </script>
@endsection
