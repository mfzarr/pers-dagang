<nav class="pcoded-navbar menu-light ">
    <div class="navbar-wrapper  ">
        <div class="navbar-content scroll-div ">

            <div class="">
                <div class="main-menu-header">
                    <img class="img-radius" src="{{asset('assets/images/user/avatar-2.jpg')}}" alt="User-Profile-Image">
                    <div class="user-details">
                        <div id="more-details">{{ Auth::user()->username }} <i class="fa fa-caret-down"></i></div>
                    </div>
                </div>
                <div class="collapse" id="nav-user-link">
                    <ul class="list-inline">
                        <li class="list-inline-item"><a href="user-profile.html" data-toggle="tooltip" title="View Profile"><i class="feather icon-user"></i></a></li>
                        <li class="list-inline-item"><a href="email_inbox.html"><i class="feather icon-mail" data-toggle="tooltip" title="Messages"></i><small class="badge badge-pill badge-primary">5</small></a></li>
                        <li class="list-inline-item">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" data-toggle="tooltip" title="Logout" class="text-danger">
                                <i class="feather icon-power"></i>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>

            <ul class="nav pcoded-inner-navbar ">
                <li class="nav-item pcoded-menu-caption">
                    <label>Navigasi</label>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link ">
                        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                        <span class="pcoded-mtext">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('perusahaan.index') }}" class="nav-link ">
                        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                        <span class="pcoded-mtext">Tentang Perusahaan</span>
                    </a>
                </li>

                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link "><span class="pcoded-micon"><i class="feather icon-package"></i></span><span class="pcoded-mtext">Masterdata</span></a>
                    <ul class="pcoded-submenu">
                        {{-- <li><a href="{{ route('coas.index') }}">COA</a></li>
                        <li><a href="{{ route('coa-kelompok.index') }}">Kelompok COA</a></li> --}}
                        <li><a href="{{ route('jabatan.index') }}">Jabatan</a></li>
                        <!-- <li><a href="{{ route('jasa.index') }}">Jasa</a></li> -->
                        <li><a href="{{ route('barang2.index') }}">Produk/Barang</a></li>
                        <li><a href="{{ route('pelanggan.index') }}">Pelanggan</a></li>
                        <li><a href="{{ route('supplier.index') }}">Supplier</a></li>
                        <li><a href="{{ route('aset.index') }}">Asset</a></li>
                        <li><a href="stok">stok</a></li>
                    </ul>
                </li>

                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link "><span class="pcoded-micon"><i class="feather icon-book"></i></span><span class="pcoded-mtext">Chart Of Account</span></a>
                    <ul class="pcoded-submenu">
                        <li><a href="{{ route('coa-kelompok.index') }}">Kelompok COA</a></li>
                        <li><a href="{{ route('coa.index') }}">COA</a></li>
                    </ul>
                </li>

                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link "><span class="pcoded-micon"><i class="feather icon-github"></i></span><span class="pcoded-mtext">Pegawai</span></a>
                    <ul class="pcoded-submenu">
                    <li><a href="{{ route('karyawan.index') }}">Pegawai</a></li>
                        <li><a href="pegawai/presensi">Presensi</a></li>
                        <li><a href="pegawai/penggajian">Penggajian</a></li>
                    </ul>
                </li>
                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link "><span class="pcoded-micon"><i class="feather icon-credit-card"></i></span><span class="pcoded-mtext">Transaksi</span></a>
                    <ul class="pcoded-submenu">
                        <li><a href="transaksi/main">Transaksi</a></li>
                        <li><a href="transaksi/penjualan">Penjualan</a></li>
                        <li><a href="transaksi/pembelian">Pembelian Barang Dagang</a></li>
                    </ul>
                </li>
                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link "><span class="pcoded-micon"><i class="feather icon-clipboard"></i></span><span class="pcoded-mtext">Laporan</span></a>
                    <ul class="pcoded-submenu">
                        <li><a href="laporan/jurnal">Jurnal Umum</a></li>
                        <li><a href="laporan/buku_besar">Buku Besar</a></li>
                        <li><a href="laporan/neraca">Neraca Saldo</a></li>
                        <li><a href="laporan/laba_rugi">Laporan Laba Rugi</a></li>
                        <li><a href="laporan/perubahan_modal">Laporan Perubahan Modal</a></li>
                        <li><a href="laporan/laporan_neraca">Laporan Neraca</a></li>

                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
