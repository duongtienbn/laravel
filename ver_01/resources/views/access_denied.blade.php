<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Document</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">
        <script src="https://kit.fontawesome.com/b26821c0fd.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    </head>

    <body class="antialiased">
        @yield('content')
        <div class="position-absolute top-50 start-50 translate-middle">
            <img src="/images/AccessDeniedError.png" alt="AccessDeniedError.png">
            <h2 class="text-center">ACCESS DENIED</h2>
            <h5>a user with the role "{{Auth::user()->role;}}" cannot do this.</h5>
            <h5 class="text-center"><a href="{{ url('/student') }}" >Back to main page</a></h5>
        </div>
    </body>
</html>
