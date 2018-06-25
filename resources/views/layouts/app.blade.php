<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link href="{{ asset('css/fontawesome/css/fontawesome-all.css') }}" rel="stylesheet" >
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" >
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">


</head>



<body>

    @include('layouts.nav')


<div class="container">

    @yield('content')

</div>
</body>
</html>
