@extends('main')

@section('content')
    <div class="row">
        <div class="col mb-4 mt-4">
            <article class="card-body reg-card">
                <h4 class="card-title text-center mb-4 mt-1">Зарегистрироваться</h4>
                <hr>
                <form method="post" action="{{ action('App\Http\Controllers\AuthController@webSignup') }}"
                enctype="multipart/form-data" accept-charset="UTF-8">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="form-label">Имя*:</label>
                        <div class="input-group">
                            <input class="form-control" type="text" name="first_name" value="{{ $first_name }}">
                        </div>
                        @if ($errors->has('first_name'))
                            <span class="text-danger">{{ $errors->first('first_name') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="last_name" class="form-label">Фамилия*:</label>
                        <div class="input-group">
                            <input class="form-control" type="text" name="last_name" value="{{ $last_name }}">
                        </div>
                        @if ($errors->has('last_name'))
                            <span class="text-danger">{{ $errors->first('last_name') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Почта*:</label>
                        <div class="input-group">
                            <input class="form-control" type="email" name="email" value="{{ $email }}">
                        </div>
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                        <div class="form-group">
                            <label for="bio" class="form-label mt-3">Расскажите о себе:</label>
                            <div class="input-group">
                                <textarea class="form-control" type="text" name="bio"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">Пароль (Укажите хотя бы одну букву и цифру):</label>
                            <div class="input-group">
                                <input class="form-control" type="password" name="password">
                            </div>
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">Повторите пароль:</label>
                            <div class="input-group">
                                <input class="form-control" type="password" name="password_confirmation">
                            </div>
                        </div>
                        <label for="avatar" class="form-label file-input">Загрузите аватар: </label>
                        <div class="input-group">
                            <input type="file" class="form-control" name="avatar" accept="image/*">
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary card-btn mt-5 text-center"> Зарегистрироваться
                            </button>
                        </div>
                </form>
            </article>
        </div>
    </div>
@endsection
