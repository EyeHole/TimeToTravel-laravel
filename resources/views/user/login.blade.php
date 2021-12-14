@extends('main')

@section('content')
    <div class="row">
        <div class="col mb-4 mt-4">
            <article class="card-body login-card">
                <h4 class="card-title text-center mb-4 mt-1">Войти</h4>
                <hr>
                <form method="post" action="{{ action('App\Http\Controllers\AuthController@webLogin') }}"
                    accept-charset="UTF-8">
                    @csrf
                    <div class="form-group">
                        <label for="email" class="form-label">Почта:</label>
                        <div class="input-group">
                            <input class="form-control" type="email" name="email" value="{{ $email }}">
                        </div>
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Пaроль:</label>
                        <div class="input-group">
                            <input class="form-control" type="password" name="password">
                        </div>
                        @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                            <p class="text-danger">Пароль должен содержать хотя бы одну букву и одну цифру.</p>
                        @endif
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary card-btn"> Войти </button>
                    </div>
                </form>
            </article>
        </div>
    </div>
@endsection
