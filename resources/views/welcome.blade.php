@extends('main')

@section('content')
    <div class="container text-center welcome-content">
        <h2>Добро пожаловать на сайт TimeToTravel!</h2>
        <div>
            <a href="{{ route('route') }}" class="btn btn-primary main-btn" role="button">Добавить маршрут</a>
        </div>
        @if ($errors->has('unauthorized'))
            <span class="text-danger">{{ $errors->first('unauthorized') }}</span>
        @endif
    </div>
@endsection
