@extends('main')

@section('content')
    <div class="row">
        <div class="col mb-4 mt-4">
            <article class="card-body reg-card">
                <h4 class="card-title text-center mb-4 mt-1">Настройки</h4>
                <hr>
                <form method="post" action="{{ action('App\Http\Controllers\UsersController@update') }}"
                    accept-charset="UTF-8">
                    <div class="form-group">
                        <label for="name" class="form-label">Имя:</label>
                        <div class="input-group">
                            <input class="form-control" type="text" name="name" value='{{ $name }}'>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Фамилия:</label>
                        <div class="input-group">
                            <input class="form-control" type="text" name="surname" value='{{ $surname }}'>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Почта:</label>
                        <div class="input-group">
                            <input name="" class="form-control" type="email" name="email" value='{{ $email }}'>
                        </div>

                        <div class="form-group">
                            <label for="bio" class="form-label mt-3">О Вас:</label>
                            <div class="input-group">
                                <textarea name="" class="form-control" type="text"
                                    name="bio">{{ $bio }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">Новый пароль:</label>
                            <div class="input-group">
                                <input class="form-control" type="password" name="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label">Повторите новый пароль:</label>
                            <div class="input-group">
                                <input class="form-control" type="password" name="repeated_password">
                            </div>
                        </div>
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
