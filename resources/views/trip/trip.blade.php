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
    <div class="container">
        <h1 class="text-center"> Создание маршрута </h1>
        <h4 class="sub-header text-center"> Общая информация </h4>
        <div class="content">

        <form method="post" action="{{ action('App\Http\Controllers\RoutesController@create') }}" accept-charset="UTF-8">
        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
    
        <label for="name" class="form-label">Название маршрута:</label>
        <div class="input-group {{($errors->first('name') ? '' : 'mb-3')}}">
        <input type="text" class="form-control {{($errors->first('name') ? 'form-error' : '')}}" name="name">
        </div>
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}

        <label for="transport">Тип транспорта:</label>
        <select class="form-control" name="transport">
        <option value=0 selected="selected">Не выбрано</option>
        <option value=1>Пешая прогулка</option>
        <option value=2>Автомобиль</option>
        <option value=3>Общественный транспорт</option>
        </select>

        <label for="description" class="form-label">Описание:</label>
        <div class="input-group">
        <textarea class="form-control" name="description"></textarea>
        </div>

        <label for="photos" class="form-label file-input">Фото: </label>
        <div class="input-group">
        <input type="file" class="form-control"  name="photos">
        <button class="btn btn-primary" type="button">Добавить еще</button>
        </div>

        <div class="text-center add-trip justify-content-center">
        <button class="btn btn-primary main-btn" type="submit">Добавить места</button>
        </div>
        </form>
        </div>
    </div>
    <x-footer/>
    </body>
</html>