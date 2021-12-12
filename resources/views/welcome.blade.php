@extends('main')

@section('content')
    <div class="container text-center welcome-content">
        <h2>Добро пожаловать на сайт TimeToTravel!</h2>
        <a href="{{ route('trip') }}" class="btn btn-primary main-btn" role="button">Добавить маршрут</a>
    </div>
@endsection
