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
    <article class="card-body login-card">
        <h4 class="card-title text-center mb-4 mt-1">Войти</h4>
        <hr>
        <form method="post" action="{{ action('App\Http\Controllers\UsersController@login') }}" accept-charset="UTF-8">
        <div class="form-group">
        <label for="email" class="form-label">Почта:</label>
        <div class="input-group">
            <input name="" class="form-control" type="email" name="email">
        </div>
        </div> 
        <div class="form-group">
        <label for="email" class="form-label">Пaроль:</label>
        <div class="input-group">
            <input class="form-control" type="password" name="password">
        </div>
        </div>
        <div class="form-group text-center">
        <button type="submit" class="btn btn-primary card-btn"> Войти  </button>
        </div>
        </form>
    </article>
    </div>
</div>

    <x-footer/>
    </body>


</html>