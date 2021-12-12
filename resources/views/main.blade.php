<!doctype html>

<html>

<title>TimeToTravel</title>
<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<section>@yield('link')</section>


<body>
    <div class="special-wrapper">
        <x-navbar />

        <main class="d-flex my-3 flex-column">
            <section>@yield('content')</section>
        </main>

        <x-footer />
    </div>
</body>


</html>
