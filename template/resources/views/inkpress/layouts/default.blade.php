<!DOCTYPE html>
<html lang="{{ str_replace('_','-',strtolower(app()->getLocale())) }}">
<head>
    @include('inkpress.layouts._header')
    @include('inkpress.layouts._css')
</head>
<body>
    <!-- Preloader if needed, can be simple -->
    <div id="main-wrapper">
        @include('inkpress.layouts._nav_header')
        
        @yield('content')
        
        @include('inkpress.layouts._footer')
    </div>

    @include('inkpress.layouts._script')
    @section('js')
    @show
</body>
</html>
