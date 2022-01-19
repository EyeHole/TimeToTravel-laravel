@extends('main')

@section('content')
    <div class="row">
        <div class="col mb-4 mt-4">
            <article class="card-body reg-card">
                <h4 class="card-title text-center mb-4 mt-1">Настройки</h4>
                <hr>
                <form method="post" action="{{ action('App\Http\Controllers\AuthController@updateProfile') }}"
                enctype="multipart/form-data" accept-charset="UTF-8">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="form-label">Имя:</label>
                        <div class="input-group">
                            <input class="form-control" type="text" name="name" value='{{ $name }}'>
                        </div>
                        @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Фамилия:</label>
                        <div class="input-group">
                            <input class="form-control" type="text" name="surname" value='{{ $surname }}'>
                        </div>
                        @if ($errors->has('surname'))
                            <span class="text-danger">{{ $errors->first('surname') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Почта:</label>
                        <div class="input-group">
                            <input class="form-control" type="email" name="email" value="{{ $email }}">
                        </div>
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif

                        <div class="form-group">
                            <label for="description" class="form-label mt-3">О Вас:</label>
                            <div class="input-group">
                                <textarea class="form-control" type="text"
                                    name="description">{{ $description }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">Новый пароль:</label>
                            <div class="input-group">
                                <input class="form-control" type="password" name="password">
                            </div>
                            @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">Повторите новый пароль:</label>
                            <div class="input-group">
                                <input class="form-control" type="password" name="password_confirmation">
                            </div>
                        </div>
                    
                        @if (isset($avatar) && $avatar != '')
                        <p>Аватар: </p>
                            <div class="col-lg-4 col-md-4 col-xs-4">
                                <img class="img-fluid  d-block mx-auto" src="{{ $avatar }}" alt="">
                            </div>
                        @endif
                    
                        <label for="photos" class="form-label file-input">Загрузить новый аватар: </label>
                        <div class="input-group">
                            <input type="file" class="form-control" name="avatar">
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary card-btn mt-5 text-center"> Подтвердить
                            </button>
                        </div>
                </form>
            </article>
        </div>
    </div>
@endsection
