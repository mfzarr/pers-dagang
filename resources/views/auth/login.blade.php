{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <title>Login Proyek SIA</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="Phoenixcoded" />
    <link rel="icon" href="assets/images/logosia.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <!-- [ auth-signin ] start -->
    <div class="auth-wrapper">
        <div class="auth-content" style="width: 750px">
            <div class="card">
                <div class="card-body d-flex flex-sm-row justify-content-sm-between align-items-center">
                    <div class="align-items-left flex-shrink-0">
                        <img src="assets/images/logosia.png" alt="Logo" class="img-fluid" style="max-width: 200px;">
                    </div>
                    <div class="align-items-center text-center flex-grow-1">
                        <div class="col-md-12">
                            <h4 class="mb-3 f-w-400">Proyek SIA</h4>

                            <!-- Login Form with Client-Side Validation -->
                            <form id="loginForm" method="POST" action="{{ route('login') }}">
                                @csrf

                                <!-- Email -->
                                <div class="form-group mb-3">
                                    <label class="floating-label" for="Email">Email address</label>
                                    <input type="email" class="form-control" id="Email" name="email" value="{{ old('email') }}" required autofocus>
                                    @if($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                                <!-- Password -->
                                <div class="form-group mb-4 position-relative">
                                    <label for="Password" class="floating-label">Password</label>
                                        <input type="password" class="form-control" id="Password" name="password" required style="padding-right: 2.5rem;">
                                        <div class="input-group">
                                        <span class="position-absolute" onclick="togglePasswordVisibility()" style="right: 10px; top: 50%; transform: translateY(-135%); cursor: pointer;">
                                            <i id="password-icon" class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                    @if($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>

                                <div class="custom-control custom-checkbox text-left mb-4 mt-2">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1" name="remember">
                                    <label class="custom-control-label" for="customCheck1">Simpan Informasi Login.</label>
                                </div>

                                <!-- Submit button -->
                                <button type="submit" class="btn btn-block btn-primary mb-4">Masuk</button>

                                <p class="mb-2 text-muted">Lupa password? <a href="{{ route('password.request') }}" class="f-w-400">Reset</a></p>
                                <p class="mb-0 text-muted">Belum punya akun? <a href="{{ route('register') }}" class="f-w-400">Signup</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ auth-signin ] end -->

    <!-- Required Js -->
    <script src="assets/js/vendor-all.min.js"></script>
    <script src="assets/js/plugins/bootstrap.min.js"></script>
    <script src="assets/js/ripple.js"></script>
    <script src="assets/js/pcoded.min.js"></script>

    <!-- Client-Side Validation Script -->
    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("Password");
            var passwordIcon = document.getElementById("password-icon");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                passwordIcon.classList.remove("fa-eye");
                passwordIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                passwordIcon.classList.remove("fa-eye-slash");
                passwordIcon.classList.add("fa-eye");
            }
        }

        document.getElementById('loginForm').addEventListener('submit', function(event) {
            var password = document.getElementById('Password').value;

            // Check if the password meets the length requirement
            if (password.length < 6) {
                event.preventDefault(); // Stop form submission
                alert("Password must be at least 6 characters long.");
            }
        });
    </script>
</body>

</html> --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login Proyek SIA</title>
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
    <!-- [ signin-img ] start -->
    <div class="auth-wrapper align-items-stretch aut-bg-img">
        <div class="flex-grow-1">
            <div class="h-100 d-md-flex align-items-center auth-side-img">
                <div class="col-sm-10 auth-content w-auto">
                    <img src="assets/images/logosia.png" alt="" class="img-fluid" style="max-width: 200px;">
                    <h1 class="text-white my-4">Welcome Back!</h1>
                    <h4 class="text-white font-weight-normal">
                        Selamat datang di Aplikasi Perusahaan Dagang<br>Silahkan login untuk mengakses fitur fitur pada aplikasi
                    </h4>
                </div>
            </div>
            <div class="auth-side-form">
                <div class="auth-content">
                    <img src="assets/images/auth/auth-logo-dark.png" alt="" class="img-fluid mb-4 d-block d-xl-none d-lg-none">
                    <h3 class="mb-4 f-w-400">Signin</h3>
                    <form id="loginForm" method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="form-group mb-3">
                            <label class="floating-label" for="login">Email address or Username</label>
                            <input type="text" class="form-control" id="login" name="login" value="{{ old('login') }}" required autofocus>
                            @if($errors->has('login'))
                            <span class="text-danger">{{ $errors->first('login') }}</span>
                            @endif
                        </div>

                        <!-- Password -->
                        <div class="form-group mb-4 position-relative">
                            <label for="Password" class="floating-label">Password</label>
                            <input type="password" class="form-control" id="Password" name="password" required style="padding-right: 2.5rem;">
                            <span class="position-absolute" onclick="togglePasswordVisibility()" style="right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                                <i id="password-icon" class="fas fa-eye"></i>
                            </span>
                            @if($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>

                        <div class="custom-control custom-checkbox text-left mb-4 mt-2">
                            <input type="checkbox" class="custom-control-input" id="customCheck1" name="remember">
                            <label class="custom-control-label" for="customCheck1">Simpan Informasi Login.</label>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="btn btn-block btn-primary mb-4">Masuk</button>

                        <p class="mb-2 text-muted">Lupa password? <a href="{{ route('password.request') }}" class="f-w-400">Reset</a></p>
                        <p class="mb-0 text-muted">Belum punya akun? <a href="{{ route('register') }}" class="f-w-400">Signup</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- [ signin-img ] end -->

    <!-- Required Js -->
    <script src="assets/js/vendor-all.min.js"></script>
    <script src="assets/js/plugins/bootstrap.min.js"></script>
    <script src="assets/js/ripple.js"></script>
    <script src="assets/js/pcoded.min.js"></script>

    <!-- Client-Side Validation Script -->
    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("Password");
            var passwordIcon = document.getElementById("password-icon");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                passwordIcon.classList.remove("fa-eye");
                passwordIcon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                passwordIcon.classList.remove("fa-eye-slash");
                passwordIcon.classList.add("fa-eye");
            }
        }

        document.getElementById('loginForm').addEventListener('submit', function(event) {
            var password = document.getElementById('Password').value;

            // Check if the password meets the length requirement
            if (password.length < 6) {
                event.preventDefault(); // Stop form submission
                alert("Password must be at least 6 characters long.");
            }
        });
    </script>
</body>

</html>
