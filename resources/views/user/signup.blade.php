<!doctype html>

<html>

    <title>TimeToTravel</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}" >
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <x-navbar/>
    <body>

    <div class="row">
    <div class="col mb-4 mt-4">
    <article class="card-body reg-card">
        <h4 class="card-title text-center mb-4 mt-1">Зарегистрироваться</h4>
        <hr>
        <form method="post" action="{{ action('App\Http\Controllers\UsersController@signup') }}" accept-charset="UTF-8">
        <div class="form-group">
        <label for="name" class="form-label">Имя:</label>
        <div class="input-group">
            <input class="form-control" type="text" name="name">
        </div>
        </div>
        <div class="form-group">
        <label for="password" class="form-label">Фамилия:</label>
        <div class="input-group">
            <input class="form-control" type="text" name="surname">
        </div>
        </div>
        <div class="form-group">
        <label for="email" class="form-label">Почта:</label>
        <div class="input-group">
            <input name="" class="form-control" type="email" name="email">
        </div>

        <div class="form-group">
        <label for="bio" class="form-label mt-3">Расскажите о себе:</label>
        <div class="input-group">
            <textarea name="" class="form-control" type="text" name="bio"></textarea>
        </div>
        </div> 
        <div class="form-group">
        <label for="password" class="form-label">Пароль:</label>
        <div class="input-group">
            <input class="form-control" type="password" name="password">
        </div>
        </div>
        <div class="form-group">
        <label for="password" class="form-label">Повторите пароль:</label>
        <div class="input-group">
            <input class="form-control" type="password" name="repeated_password">
        </div>
        </div>
        <label for="photos" class="form-label file-input">Загрузите аватар: </label>
        <div class="input-group">
        <input type="file" class="form-control"  name="avatar">
        </div>
        <div class="form-group text-center">
        <button type="submit" class="btn btn-primary card-btn mt-5 text-center"> Зарегистрироваться  </button>
        </div>
        </form>
    </article>
    </div>
</div>

    <x-footer/>
    </body>


</html>