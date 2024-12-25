@extends('layouts.frontend')

@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Add Pegawai</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Pegawai</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Create Pegawai</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('pegawai.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="form-group">
                                <label for="id_user">User</label>
                                <select class="form-control" id="id_user" name="id_user">
                                    <option value="">Belum Terdaftar</option>
                                    @foreach($users as $user)
                                        @if($user->role == 'pegawai' && $user->id_perusahaan == auth()->user()->id_perusahaan)
                                            <option value="{{ $user->id }}">{{ $user->id }} - {{ $user->username }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>                            
                            <div class="form-group">
                                <label for="no_telp">No Telp</label>
                                <input type="text" class="form-control" id="no_telp" name="no_telp" required>
                            </div>
                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="Pria">Pria</option>
                                    <option value="Wanita">Wanita</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat" required>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="aktif">Aktif</option>
                                    <option value="non-aktif">Non-Aktif</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="id_jabatan">Jabatan</label>
                                <select class="form-control" id="id_jabatan" name="id_jabatan" required>
                                    @foreach($jabatans as $jabatan)
                                    <option value="{{ $jabatan->id_jabatan }}">{{ $jabatan->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="{{ route('pegawai.index') }}" class="btn btn-danger">Back</a>
                            </div>
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