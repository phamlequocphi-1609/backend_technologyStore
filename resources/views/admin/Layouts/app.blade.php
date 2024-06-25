<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

     <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('admin/assets/images/favicon.png')}}">
    <title>Nice admin Template - The Ultimate Multipurpose admin template</title>
     <!-- Custom CSS -->
    <link href="{{asset('admin/assets/libs/chartist/dist/chartist.min.css')}}" rel="stylesheet">
     <!-- Custom CSS -->
    <link href="{{asset('admin/dist/css/style.min.css')}}" rel="stylesheet">
    
</head>
<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div id="main-wrapper" data-navbarbg="skin6" data-theme="light" data-layout="vertical" data-sidebartype="full" data-boxed-layout="full">
        @include('admin.Layouts.header')
        @include('admin.Layouts.left-sidebar')
        <div class="page-wrapper">
            @yield('content')
            @include('admin.Layouts.footer')
        </div>
    </div>



    <script src="{{asset('admin/assets/libs/jquery/dist/jquery.min.js')}}"></script>
     <!-- Bootstrap tether Core JavaScript -->
     <script src="{{asset('admin/assets/libs/popper.js/dist/umd/popper.min.js')}}"></script>
     <script src="{{asset('admin/assets/libs/bootstrap/dist/js/bootstrap.min.js')}}"></script>
     <!-- slimscrollbar scrollbar JavaScript -->
     <script src="{{asset('admin/assets/extra-libs/sparkline/sparkline.js')}}"></script>
     <!--Wave Effects -->
     <script src="{{asset('admin/dist/js/waves.js')}}"></script>
     <!--Menu sidebar -->
     <script src="{{asset('admin/dist/js/sidebarmenu.js')}}"></script>
     <!--Custom JavaScript -->
     <script src="{{asset('admin/dist/js/custom.min.js')}}"></script>
     <!--This page JavaScript -->
     <!--chartis chart-->
     <script src="{{asset('admin/assets/libs/chartist/dist/chartist.min.js')}}"></script>
     <script src="{{asset('admin/assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js')}}"></script>
     <script src="{{asset('admin/dist/js/pages/dashboards/dashboard1.js')}}"></script>
</body>
</html>