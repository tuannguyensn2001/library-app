<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trang quản lý Admin</title>

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    @foreach(trans('style.index') as $item)
        <link rel="stylesheet" href="{{asset("assets/{$item}")}}">
    @endforeach
    <link rel="stylesheet" href="{{asset('assets/plugins/toastr/toastr.min.css')}}">

    <style>
        .dataTables_filter label {
            width: 100%;
        }
    </style>
    @stack('css')
</head>
<body class="hold-transition sidebar-mini layout-fixed">

<div class="wrapper">

    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="{{asset('assets/dist/img/AdminLTELogo.png')}}" alt="AdminLTELogo" height="60" width="60">
    </div>

    <!-- Navbar -->
    <x-backend.header/>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <x-backend.sidebar/>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        @yield('module_name')
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                            @yield('module')
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            @yield('content')
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <x-backend.footer/>


    <aside class="control-sidebar control-sidebar-dark">

    </aside>


</div>


@foreach(trans('scripts.index') as $item)
    <script src="{{asset("assets/{$item}")}}"></script>
@endforeach

<script src="{{asset('assets/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<!-- Toastr -->
<script src="{{asset('assets/plugins/toastr/toastr.min.js')}}"></script>

@foreach($scriptsDatatables as $item)
    <script src="{{asset("assets/{$item}")}}"></script>
@endforeach
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
<script src="{{asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.js')}}"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{--<script src="{{asset('assets/dist/js/pages/dashboard.js')}}"></script>--}}
<script>
    @if(session('success'))
   setTimeout(() => {
        toastr.success('{{session('success')}}')
    },500);
    @endif
    @if(session('error'))
    setTimeout(() => {
        toastr.error('{{session('error')}}')
    },500)
    @endif

    $(document).ready(function () {
        $('.nav-link').click(function () {
            if ($(this).hasClass('active')) {
                $(this).removeClass('active')
            } else {
                $(this).addClass('active');
            }
        })
    })
</script>
@stack('scripts')
</body>
</html>
