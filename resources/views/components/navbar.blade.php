<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}" >

  <nav class="navbar navbar-dark bg-primary sticky-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ route('main') }}">Time To Travel Admin</a>

      @guest
      <div class="d-flex flex-row-reverse bd-highlight">
        <a class="navbar-brand bd-highlight nav-menu" href="{{ route('signup') }}">Регистрация</a>
        <a class="navbar-brand bd-highlight nav-menu" href="{{ route('login') }}">Войти</a>
      </div>
      @endguest

      @auth
      <div class="d-flex flex-row-reverse bd-highlight">
        <a class="navbar-brand bd-highlight nav-menu" href="{{ route('logout') }}">Выйти</a>
        <a class="navbar-brand bd-highlight nav-menu" href="{{ route('settings') }}">Настройки</a>
        <a class="navbar-brand bd-highlight nav-menu" href="{{ route('settings') }}">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</a>
      </div>
      @endauth
    </div>
</nav>