@extends('layouts.frontend')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Create Penjualan</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('penjualan.index') }}">Penjualan</a></li>
                            <li class="breadcrumb-item active">Create Penjualan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Create New Penjualan</h5>
            </div>
            <div class="card-body">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('penjualan.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="tanggal" class="form-label">Tanggal Transaksi</label>
                        <input type="date" id="tanggal" name="tanggal" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="pelanggan" class="form-label">Pelanggan</label>
                        <select id="pelanggan" name="pelanggan" class="form-control" required onchange="updateDiscountInfo()">
                            <option value="">Pilih Pelanggan</option>
                            @foreach($pelanggan as $item)
                            <option value="{{ $item->id_pelanggan }}" data-jumlah-transaksi="{{ $item->jumlah_transaksi }}">
                                {{ $item->nama }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="discount-info" class="alert alert-info d-none">
                        <strong>Discount:</strong>
                        <p id="discount-message">Pilih pelanggan untuk melihat diskon yang tersedia.</p>
                    </div>


                    <h5 class="mt-4">Produk Details</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="produkTable">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Kuantitas</th>
                                    <th>Pegawai</th>
                                    <th>Subtotal</th>
                                    <th>
                                        <button type="button" class="btn btn-sm btn-primary" onclick="addRow()">Add Row</button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select name="produk[0][id_produk]" class="form-control produk-select" onchange="updateHarga(this)" required>
                                            <option value="">Select Produk</option>
                                            @foreach($produk as $item)
                                            <option value="{{ $item->id_produk }}" data-harga="{{ $item->harga }}">{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="number" name="produk[0][harga]" class="form-control harga" readonly required></td>
                                    <td><input type="number" name="produk[0][kuantitas]" class="form-control kuantitas" min="1" onchange="calculateSubtotal(this)" required></td>
                                    <td>
                                        <select name="produk[0][pegawai]" class="form-control" required>
                                            <option value="">Select Pegawai</option>
                                            @foreach($pegawai as $item)
                                            <option value="{{ $item->id_karyawan }}">{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="number" class="form-control subtotal" readonly></td>
                                    <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">Remove</button></td>
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-right"><strong>Total</strong></td>
                                    <td>
                                        <input type="number" id="total" class="form-control" readonly>
                                        <input type="hidden" name="total" id="total_hidden"> <!-- Hidden input for the total -->
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <button type="submit" class="btn btn-success mt-3">Create Penjualan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function updateHarga(selectElement) {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const harga = selectedOption.getAttribute('data-harga');
        const row = selectElement.closest('tr');
        row.querySelector('.harga').value = harga; // Set harga value
        calculateSubtotal(row.querySelector('.kuantitas'));
    }

    function calculateSubtotal(kuantitasInput) {
        const row = kuantitasInput.closest('tr');
        const harga = parseFloat(row.querySelector('.harga').value) || 0;
        const kuantitas = parseInt(kuantitasInput.value) || 0;
        const subtotal = harga * kuantitas;
        row.querySelector('.subtotal').value = subtotal;
        calculateTotal();
    }

    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('.subtotal').forEach(subtotalInput => {
            total += parseFloat(subtotalInput.value) || 0;
        });
        document.getElementById('total').value = total;
        document.getElementById('total_hidden').value = total; // Set hidden input value
    }

    function addRow() {
        const table = document.querySelector("#produkTable tbody");
        const rowCount = table.rows.length;
        const newRow = table.insertRow(rowCount);
        newRow.innerHTML = document.querySelector("#produkTable tbody tr").innerHTML.replace(/\[0\]/g, `[${rowCount}]`);
    }

    function removeRow(button) {
        button.closest('tr').remove();
        calculateTotal(); // Recalculate total when a row is removed
    }

    const discounts = @json($discounts);

    function updateDiscountInfo() {
        const pelangganSelect = document.getElementById('pelanggan');
        const selectedOption = pelangganSelect.options[pelangganSelect.selectedIndex];
        const jumlahTransaksi = parseInt(selectedOption.getAttribute('data-jumlah-transaksi')) || 0;

        const nextTransaction = jumlahTransaksi + 1;
        const discountInfo = discounts[nextTransaction];

        const discountInfoDiv = document.getElementById('discount-info');
        const discountMessage = document.getElementById('discount-message');

        if (discountInfo) {
            discountInfoDiv.classList.remove('d-none');
            discountMessage.innerHTML = `pada transaksi ini (No. ${nextTransaction}), pelanggan akan mendapat <strong>${discountInfo.discount_percentage}%</strong>.`;
        } else {
            discountInfoDiv.classList.add('d-none');
            discountMessage.innerHTML = 'tidak ada diskon.';
        }
    }
</script>
@endsection