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
                                <h4 class="mb-3 f-w-400">Buat Akun</h4>
                                <!-- Add CSRF token -->
                                <form method="POST" action="{{ route('register') }}" id="registerForm">
                                    @csrf <!-- CSRF Protection -->
                                    
                                    <div class="form-group mb-3">
                                        <label class="floating-label" for="Username">Username</label>
                                        <input type="text" class="form-control" id="Username" name="username" placeholder="" required>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="floating-label" for="Email">Email address</label>
                                        <input type="email" class="form-control" id="Email" name="email" placeholder="" required>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="floating-label" for="Password">Password</label>
                                        <input type="password" class="form-control" id="Password" name="password" placeholder="" required minlength="6">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="floating-label" for="PasswordConfirm">Confirm Password</label>
                                        <input type="password" class="form-control" id="PasswordConfirm" name="password_confirmation" placeholder="" required>
                                    </div>

                                    <!-- Role Selection -->
                                    <div class="form-group mb-3">
                                        <label class="floating-label" for="Role">Role</label>
                                        <select class="form-control" id="Role" name="role" required>
                                            <option value="owner">Owner</option>
                                            <option value="pegawai">Pegawai</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-block mb-4">Daftar</button>
                                    <p class="mb-2">Already have an account? <a href="{{ route('login') }}" class="f-w-400">Signin</a></p>
                                </form>
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

    <!-- Client-Side Validation -->
    <script>
        document.getElementById('registerForm').addEventListener('submit', function(event) {
            var password = document.getElementById('Password').value;
            var confirmPassword = document.getElementById('PasswordConfirm').value;

            // Check if passwords match
            if (password !== confirmPassword) {
                event.preventDefault(); // Prevent form submission
                alert("Passwords do not match.");
            }

        });
    </script>
</body>

</html>
