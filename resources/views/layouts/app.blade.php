<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Admin Dashboard') }}</title> 
  <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
  <link rel="icon" href="{{ asset($websetting->favicon) }}" type="image/x-icon" />

  <!-- Fonts and icons -->
  <script src="{{asset('/')}}assets/js/plugin/webfont/webfont.min.js"></script>
  <script>
    WebFont.load({
      google: { families: ["Public Sans:300,400,500,600,700"] },
      custom: {
        families: [
          "Font Awesome 5 Solid",
          "Font Awesome 5 Regular",
          "Font Awesome 5 Brands",
          "simple-line-icons",
        ],
        urls: ["{{asset('/')}}assets/css/fonts.min.css"],
      },
      active: function () {
        sessionStorage.fonts = true;
      },
    });
  </script>

  <!-- CSS Files -->
  <link rel="stylesheet" href="{{asset('/')}}assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="{{asset('/')}}assets/css/plugins.min.css" />
  <link rel="stylesheet" href="{{asset('/')}}assets/css/kaiadmin.min.css" />

  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link rel="stylesheet" href="{{asset('/')}}assets/css/demo.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
  <div class="wrapper">

    @include('layouts.sidebar')

    {{ $slot }}

    <footer class="footer">
      <div class="container-fluid d-flex justify-content-between">

        <div class="copyright">
          2025, made with <i class="fa fa-heart heart text-danger"></i> by
          <a href="javascript:void(0)">Salman Quraishi</a>
        </div>
        <div>
          Distributed by
          <a target="_blank" href="https://webtis.in">Webtis.in</a>
        </div>
      </div>
    </footer>
  </div>
  </div>
  <!--   Core JS Files   -->
  <script src="{{asset('/')}}assets/js/core/jquery-3.7.1.min.js"></script>
  <script src="{{asset('/')}}assets/js/core/popper.min.js"></script>
  <script src="{{asset('/')}}assets/js/core/bootstrap.min.js"></script>

  <!-- jQuery Scrollbar -->
  <script src="{{asset('/')}}assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

  <!-- Datatables -->
  <script src="{{asset('/')}}assets/js/plugin/datatables/datatables.min.js"></script>

  <!-- Sweet Alert -->
  <script src="{{asset('/')}}assets/js/plugin/sweetalert/sweetalert.min.js"></script>

  <!-- Kaiadmin JS -->
  <script src="{{asset('/')}}assets/js/kaiadmin.min.js"></script>

  <!-- Kaiadmin DEMO methods, don't include it in your project! -->
  <script src="{{asset('/')}}assets/js/setting-demo2.js"></script>

  @if (session('success'))
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Success',
        text: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 2000
      });
    </script>
  @endif
  @if ($errors->any())
    <script>
      Swal.fire({
        icon: 'error',
        title: 'Validation Error',
        html: '{!! implode("<br>", $errors->all()) !!}',
        confirmButtonColor: '#d33'
      });
    </script>
  @endif
  <script>
    function confirmLogout() {
      Swal.fire({
        title: 'Are you sure?',
        text: "You will be logged out.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, logout'
      }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('logout-form').submit();
        }
      });
    }
  </script>
  <script>
    $(document).ready(function () {
      $("#basic-datatables").DataTable({});
    });
  </script>

</body>

</html>