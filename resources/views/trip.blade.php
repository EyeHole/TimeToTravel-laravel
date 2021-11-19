<!doctype html>
<html>
    <header>
    <title>TimeToTravel</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}" >
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="{{ asset('js/map.js') }}"></script>
    </header>
    <x-navbar/>

    <body>
    <div class="container-fluid content">
        <div class="row">
            <div class = "col" id="map"></div>
            <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDSQ1ZoiS7_oGzQkUJwlkuBohkvW1_yWRs&callback=initMap&v=weekly"
            async
            ></script>
            <div class="trip-form col">
                <h1> Выберите точки и расскажите о них. </h1>
                <h4> Выбранная точка: -34.397, 150.644 </h4>

                <label for="place_name" class="form-label">Название места:</label>
                <div class="input-group mb-3">
                <input type="text" class="form-control" id="place_name">
                </div>

                <label for="place_desc" class="form-label">Описание:</label>
                <div class="input-group">
                <textarea class="form-control" id="place_desc" aria-label="With textarea"></textarea>
                </div>

                <label for="photo0" class="form-label file-input">Фото: </label>
                <div class="input-group">
                <input type="file" class="form-control" id="photo0">
                <button class="btn btn-primary" type="button">Добавить еще</button>
                </div>

                <label for="audio0" class="form-label file-input">Аудио: </label>
                <div class="input-group">
                <input type="file" class="form-control" id="audio0">
                <button class="btn btn-primary" type="button">Добавить еще</button>
                </div>

                <div class="text-center add-trip justify-content-center">
                <button class="btn btn-primary add-trip-btn" type="button">Добавить маршрут</button>
                </div>
            </div>
        </div>
    </div>
    <x-footer/>
    </body>
</html>