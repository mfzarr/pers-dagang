{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <title>Registrasi Perusahaan</title>
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

                                    <!-- Jenis Perusahaan (Invisible, auto-selected) -->
                                    <input type="hidden" id="jenis_perusahaan" name="jenis_perusahaan" value="dagang">

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

</html> --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Create Perusahaan - Projek SIA</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="Phoenixcoded" />
    <link rel="icon" href="assets/images/logosia.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <!-- [ create-perusahaan ] start -->
    <div class="auth-wrapper align-items-stretch aut-bg-img">
        <div class="flex-grow-1">
            <div class="h-100 d-md-flex align-items-center auth-side-img">
                <div class="col-sm-10 auth-content w-auto">
                    <img src="assets/images/logosia.png" alt="" class="img-fluid" style="max-width: 200px;">
                    <h1 class="text-white my-4">Create Your Company!</h1>
                    <h4 class="text-white font-weight-normal">
                        Lengkapi informasi berikut untuk membuat profil perusahaan dagang Anda.
                    </h4>
                </div>
            </div>
            <div class="auth-side-form">
                <div class="auth-content">
                    <img src="assets/images/auth/auth-logo-dark.png" alt="" class="img-fluid mb-4 d-block d-xl-none d-lg-none">
                    <h3 class="mb-4 f-w-400">Create Perusahaan</h3>
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

                        <!-- Jenis Perusahaan (Invisible, auto-selected) -->
                        <input type="hidden" id="jenis_perusahaan" name="jenis_perusahaan" value="dagang">

                        <!-- Kode Perusahaan (Auto-generated, hidden) -->
                        <input type="hidden" name="kode_perusahaan" id="kode_perusahaan">

                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary btn-block mb-4">Create Perusahaan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- [ create-perusahaan ] end -->

    <!-- Required Js -->
    <script src="assets/js/vendor-all.min.js"></script>
    <script src="assets/js/plugins/bootstrap.min.js"></script>
    <script src="assets/js/ripple.js"></script>
    <script src="assets/js/pcoded.min.js"></script>
</body>
</html>
