<!DOCTYPE html>
<html lang="en">

<head>
    <title>Proyek SIA</title>
    @include('includes.style')
</head>

<body class="">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    <!-- [ navigation menu ] start -->
    @include('includes.navbar')
    <!-- [ Header ] start -->
    @include('includes.header')
    <!-- [ Header ] end -->



    <!-- [ Main Content ] start -->
    @yield('content')
    <!-- [ Main Content ] end -->


    @include('includes.footer')


</body>

</html>