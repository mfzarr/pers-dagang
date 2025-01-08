<!DOCTYPE html>
<html lang="en">

<head>
    <title>Proyek SIA Perusahaan Dagang</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Welcome to Proyek SIA" />
    <meta name="keywords" content="Proyek SIA, Laravel, Welcome Page">
    <meta name="author" content="Your Name" />

    <!-- Favicon icon -->
    <link rel="icon" href="assets/images/logosia.png" type="image/x-icon">

    <!-- Bootstrap CSS for layout and styling -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">

    <style>
        /* Centered Welcome Section */
        .welcome-wrapper {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            background-color: #f8f9fa;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 20px;
        }
        .btn-group {
            margin-top: 20px;
        }

        /* Feature Section Styling */
        .features {
            padding: 60px 0;
            text-align: center;
            background-color: #007bff; /* Blue background */
            color: white; /* White text for readability */
        }
        .features .col-md-4 {
            margin-bottom: 30px;
        }
        .features img {
            max-width: 100px;
            margin-bottom: 20px;
        }
        .features h3, .features p {
            color: white; /* Ensure all text is white */
        }

        /* Footer Styling */
        footer {
            background-color: #f8f9fa;
            padding: 20px 0;
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- Welcome Wrapper with Logo, Text, and Buttons -->
    <div class="welcome-wrapper">
        <!-- Logo -->
        <img src="assets/images/logosia.png" alt="Logo" class="logo">

        <!-- Welcome Text -->
        <h1>Proyek SIA Perusahaan Dagang</h1>
        <p>Manage Your Business More Simply and Efficiently.</p>

        <!-- Buttons -->
        <div class="btn-group">
            <a href="{{ route('login') }}" class="btn btn-primary mr-2">Login</a>
            <a href="{{ route('register') }}" class="btn btn-success">Register</a>
        </div>
    </div>

    <!-- Feature Section with Blue Background and White Text -->
    <section class="features text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img src="assets/images/feature1.png" alt="Feature 1" class="img-fluid">
                    <h3>Feature 1</h3>
                    <p>Manage inventory with ease and keep track of all your products in one place.</p>
                </div>
                <div class="col-md-4">
                    <img src="assets/images/feature2.png" alt="Feature 2" class="img-fluid">
                    <h3>Feature 2</h3>
                    <p>Generate detailed reports to help you understand your business performance.</p>
                </div>
                <div class="col-md-4">
                    <img src="assets/images/feature3.png" alt="Feature 3" class="img-fluid">
                    <h3>Feature 3</h3>
                    <p>Collaborate with your team and manage your business from anywhere.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>© 2024 Proyek SIA. All rights reserved.</p>
        <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a>
    </footer>

    <!-- Required JS Files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
</body>

</html>
