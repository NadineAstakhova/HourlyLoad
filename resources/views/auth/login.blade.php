@extends('layouts.main')
@section('title', 'Login')
@section('content')
    @php
       if(Session::has('message'))
           echo "<div class='alert alert-danger' id='mesSuccessAdd'>".Session::get("message")."</div>";
    @endphp

    <div class="row">
        <h3>Введите данные для входа</h3>
        {!! Form::open(['url' => ['auth/login']]) !!}
        <div class="form-group">
            {!! Form::label('email', 'Почта') !!}
            {!! Form::email('email', $value = null, $attributes = array('class' => 'form-control')) !!}
        </div>
        <div class="form-group">
            {!! Form::label('password', 'Пароль') !!}

            {!! Form::password('password', ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">

        {!! Form::submit('Login', ['class' => 'btn btn-default']) !!}

        {!! Form::close() !!}
        </div>
    </div>

@endsection