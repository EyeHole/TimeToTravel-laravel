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
    <div class="container text-center">
        <h1> Созданный маршрут: </h1>
        <h4 class="sub-header"> Общая информация </h4>
        <div class="content">

        <div class="card card-body text-center">
        <label for="name" class="trip-label">Название маршрута:</label>
        <div class="mb-3">
        <p>{{ $name }}</p>
        </div>

        <label for="transport" class="trip-label">Тип транспорта:</label>
        <div class="mb-3">
            @switch ($option)
                @case(0)
                    <p>Не выбрано</p>
                    @break
                @case(1)
                    <p>Пешая прогулка</p>
                    @break
                @case(2)
                    <p>Автомобиль</p>
                    @break
                @case(3)
                    <p>Общественный транспорт</p>
                    @break
            @endswitch
        </div>
    
        <label for="description" class="trip-label">Описание:</label>
        <div class="mb-3">
        <p>{{ $description }}</p>
        </div>

        <label for="length" class="trip-label">Количество мест:</label>
        <div>
        <p>{{ $length }}</p>
        </div>
        </div>
    </div>
    <a href="{{ route('main') }}" class="btn btn-primary back-btn" role="button">Вернуться на главную</a>
        </div>
    <x-footer/>
    </body>
</html>