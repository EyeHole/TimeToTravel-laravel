<!doctype html>
<html>
<header>
    <title>TimeToTravel</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="{{ asset('js/map.js') }}"></script>
</header>

<x-navbar />

<body>
    <div class="container-fluid place-content">
        <div class="row">
            <div class="col" id="map"></div>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDSQ1ZoiS7_oGzQkUJwlkuBohkvW1_yWRs&callback=initMap&v=weekly"
                        async>
            </script>
            <script>

            </script>
            <div class="trip-form col">
                <h4 class="header"> Выберите точку на карте или укажите ее координаты и расскажите о ней. </h4>

                <form method="post" action="{{ action('App\Http\Controllers\RoutesController@addPlace') }}"
                    enctype="multipart/form-data" accept-charset="UTF-8">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                    <input name="trip_id" type="hidden" value="{{ $id }}" />
                    <input name="order" type="hidden" value="{{ $order }}" />
                    <input name="length" type="hidden" value="{{ $length }}" />

                    <div class="input-group {{ $errors->first('longitude') ? '' : 'mb-3' }}">
                        <label for="longitude" class="form-label">Долгота:&nbsp&nbsp</label>
                        <input type="text" class="form-control {{ $errors->first('longitude') ? 'form-error' : '' }}"
                            name="longitude" placeholder="-73.985428" value='{{ $longitude }}'>
                    </div>
                    {!! $errors->first('longitude', '<p class="help-block">:message</p>') !!}

                    <div class="input-group {{ $errors->first('latitude') ? '' : 'mb-3' }}">
                        <label for="latitude" class="form-label">Широта:&nbsp&nbsp</label>
                        <input type="text" class="form-control {{ $errors->first('latitude') ? 'form-error' : '' }}"
                            name="latitude" placeholder="40.748817" value='{{ $latitude }}'>
                    </div>
                    {!! $errors->first('latitude', '<p class="help-block">:message</p>') !!}

                    <div class="input-group mb-3">
                        <label for="order" class="form-label">Очередность в маршруте:&nbsp&nbsp</label>
                        <input type="text" class="form-control" name="order" value="{{ $order }}" readonly>
                    </div>

                    <label for="name" class="form-label {{ $errors->first('name') ? '' : 'mb-3' }}">Название
                        места:</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control {{ $errors->first('name') ? 'form-error' : '' }}"
                            name="name" value='{{ $name }}'>
                    </div>
                    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}

                    <label for="description" class="form-label">Описание:</label>
                    <div class="input-group">
                        <textarea class="form-control" name="description">{{ $description }}</textarea>
                    </div>

                    <div>
                        <label class="form-label file-input">Фото:</label>
                        <div class="row">
                            @foreach ($photos as $image_url)
                                <div class="col-lg-4 col-md-4 col-xs-4 thumb">
                                    <a class="thumbnail" href="#">
                                        <img class="img-responsive my-2" src="{{ $image_url }}" alt="">
                                        <button class="btn btn-danger" type="button"
                                            onclick="return this.parentNode.remove();">Удалить</button>
                                        <input type="hidden" value="{{ $image_url }}"
                                            name="{{ 'uploaded_images[' . $loop->iteration . ']' }}">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        @if (count($errors->get('images.*')) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->get('images.*') as $image_input_error)
                                        Фото {{ $loop->iteration }}:
                                        @foreach ($image_input_error as $message)
                                            <li>{{ $message }}</li>
                                        @endforeach
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div id="imageInputBlock"></div>
                        <button class="btn btn-primary d-block my-3" type="button" onclick="AddFileInput()">Добавить
                            фото</button>
                    </div>


                    <label for="audio" class="form-label file-input">Аудио:</label>
                    <div class="input-group">
                        <input type="file" class="form-control" name="audio">
                        {{-- <button class="btn btn-primary" type="button">Добавить еще</button> --}}
                    </div>

                    <div class="container-fluid btn-form">

                        <div class="add-trip text-center">
                            <button name="action" class="btn btn-primary btn-padding btn-group justify-content-center"
                                type="submit" value="prev" @if ($order < 2) disabled @endif>Предыдущее место</button>
                            <button name="action" class="btn btn-primary btn-padding btn-group justify-content-center"
                                type="submit" value="next" @if ($length <= $order) disabled @endif>Следующее место</button>
                        </div>

                        <div class="add-trip text-center">
                            <button name="action" class="btn btn-primary btn-padding btn-group justify-content-center"
                                type="submit" value="new">Добавить следующее место</button>
                            <button name="action" class="btn btn-primary btn-padding btn-group justify-content-center"
                                type="submit" value="end">Закончить маршрут</button>
                        </div>

                        <div class="text-center add-trip">

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-footer />

    <script>
        function htmlToElement(html) {
            var template = document.createElement('template');
            html = html.trim(); // Never return a text node of whitespace as the result
            template.innerHTML = html;
            return template.content.firstChild;
        }

        function AddFileInput() {
            var inputBlock = document.getElementById("imageInputBlock");

            var newdiv = htmlToElement(
                `                   
                <div class="input-group my-2">
                            <input type="file" class="form-control" name="images[]">
                            <button class="btn btn-danger" type="button" onclick="return this.parentNode.remove();">Удалить</button>
                </div>
                `);
            inputBlock.appendChild(newdiv);
        }
    </script>
</body>

</html>
