<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ablepro v8.0 bootstrap admin template by Phoenixcoded</title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="Phoenixcoded" />
    <!-- Favicon icon -->
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    <!-- vendor css -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <!-- [ auth-signup ] start -->
    <div class="auth-wrapper">
        <div class="auth-content" style="width: 750px">
            <div class="card">
                <div class="card-body d-flex flex-sm-row justify-content-sm-between align-items-center">
                    <div class="align-items-center text-center flex-grow-1">
                        <div class="col-md-12">
                            <div class="card-body">
                                <h4 class="mb-3 f-w-400">Registrasi Perusahaan</h4>

                                <!-- Form starts here -->
                                <form method="POST" action="{{ route('create.perusahaan') }}">
                                    @csrf <!-- CSRF Protection -->

                                    <!-- Nama Perusahaan -->
                                    <div class="form-group mb-3">
                                        <label class="floating-label" for="nama">Nama Perusahaan</label>
                                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Enter company name" required>
                                    </div>

                                    <!-- Alamat Perusahaan -->
                                    <div class="form-group mb-3">
                                        <label class="floating-label" for="alamat">Alamat Perusahaan</label>
                                        <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Enter company address" required>
                                    </div>

                                    <!-- Jenis Perusahaan (Dropdown for Barang or Jasa) -->
                                    <div class="form-group mb-3">
                                        <label class="floating-label" for="jenis_perusahaan">Jenis Perusahaan</label>
                                        <select class="form-control" id="jenis_perusahaan" name="jenis_perusahaan" required>
                                            <option value="barang">Barang</option>
                                            <option value="jasa">Jasa</option>
                                        </select>
                                    </div>

                                    <!-- Kode Perusahaan (Auto-generated, hidden) -->
                                    <input type="hidden" name="kode_perusahaan" id="kode_perusahaan">

                                    <!-- Submit button -->
                                    <button type="submit" class="btn btn-primary btn-block mb-4">Create Perusahaan</button>
                                </form>
                                <!-- Form ends here -->
                            </div>
                        </div>
                    </div>
                    <div class="align-items-left flex-shrink-0">
                        <img src="assets/images/logosia.png" alt="Logo" class="img-fluid" style="max-width: 200px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ auth-signup ] end -->

    <!-- Required Js -->
    <script src="assets/js/vendor-all.min.js"></script>
    <script src="assets/js/plugins/bootstrap.min.js"></script>
    <script src="assets/js/ripple.js"></script>
    <script src="assets/js/pcoded.min.js"></script>
</body>

</html>
