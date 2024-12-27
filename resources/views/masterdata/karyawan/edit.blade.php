@extends('layouts.frontend')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Edit Karyawan</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('pegawai.index') }}">Karyawan</a></li>
                            <li class="breadcrumb-item"><a>Edit Karyawan</a></li>
                        </ul>  
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Edit Karyawan</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('pegawai.update', $karyawan->id_karyawan) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="{{ $karyawan->nama }}" required>
                                @error('nama')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="id_user">User</label>
                                <select class="form-control" id="id_user" name="id_user">
                                    <option value="">Belum Terdaftar</option>
                                    @foreach($users as $user)
                                        @if($user->role == 'pegawai')
                                            <option value="{{ $user->id }}" {{ $karyawan->id_user == $user->id ? 'selected' : '' }}>{{ $user->id }} - {{ $user->username }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('id_user')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $karyawan->email }}" required>
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="no_telp">No Telp</label>
                                <input type="text" class="form-control" id="no_telp" name="no_telp" value="{{ $karyawan->no_telp }}" required>
                                @error('no_telp')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="Pria" {{ $karyawan->jenis_kelamin == 'Pria' ? 'selected' : '' }}>Pria</option>
                                    <option value="Wanita" {{ $karyawan->jenis_kelamin == 'Wanita' ? 'selected' : '' }}>Wanita</option>
                                </select>
                                @error('jenis_kelamin')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $karyawan->alamat }}" required>
                                @error('alamat')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="aktif" {{ $karyawan->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="non-aktif" {{ $karyawan->status == 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                                </select>
                                @error('status')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Ketika dropdown user berubah
    document.getElementById('id_user').addEventListener('change', function () {
        var userId = this.value; // Ambil ID user yang dipilih

        // Jika tidak ada ID yang dipilih, kosongkan email
        if (userId === "") {
            document.getElementById('email').value = "";
            return;
        }

        // Mengambil email berdasarkan user id dari server
        fetch(`/get-user-email/${userId}`)
            .then(response => response.json())
            .then(data => {
                if (data.email) {
                    document.getElementById('email').value = data.email; // Isi email dengan data yang diterima
                } else {
                    document.getElementById('email').value = ""; // Kosongkan email jika tidak ditemukan
                }
            })
            .catch(error => {
                console.error('Error fetching email:', error);
            });
    });
</script>
@endsection