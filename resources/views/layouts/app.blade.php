<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>@yield('title') | {{ config('app.name') }} </title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
    integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />


  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/components.css') }}">
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

  <!-- Untuk CSS yang berbeda di setiap component-->
  @stack('style')
</head>

<body>
  <div id="app">
    <div class="main-wrapper">
      <!-- Header -->
      @include('components.header')

      <!-- Sidebar -->
      @include('components.sidebar')

      <!-- Content -->
      @yield('main')
      @yield('modal')
    </div>

    <!-- Content -->
  </div>

  <!-- General JS Scripts -->
  <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('library/popper.js/dist/umd/popper.js') }}"></script>
  <script src="{{ asset('library/tooltip.js/dist/umd/tooltip.js') }}"></script>
  <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('library/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
  {{-- <script src="{{ asset('library/moment/min/moment.min.js') }}"></script> --}}
  <script src="{{ asset('js/stisla.js') }}"></script>

  <!-- Template JS File -->
  <script src="{{ asset('js/scripts.js') }}"></script>
  <script src="{{ asset('js/custom.js') }}"></script>

  <!-- Untuk JS yang berbeda di setiap component-->
  @stack('scripts')
</body>

</html>