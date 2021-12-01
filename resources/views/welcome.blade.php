<!doctype html>

<html>

    <title>TimeToTravel</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}" >
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <x-navbar/>

    <body>
    <div class="container text-center welcome-content">
        <h2>Добро пожаловать на сайт Time To Travel!</h2>
        <a href="{{ route('trip') }}" class="btn btn-primary main-btn" role="button">Добавить маршрут</a>
        </div>
    </div>

    <x-footer/>
    </body>


</html>