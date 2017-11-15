@extends('layouts.main')
@section('title', 'Reset Pass')
@section('content')
    {!! Form::open(['url' => ['updatePass'], 'class'=>'form-group']) !!}
<h3>Для изменения пароля нужно заполнить следующие поля:</h3>
    {!! Form::label('cur_password', 'Текущий пароль') !!}

    {!! Form::password('cur_password', ['class' => 'form-control']) !!}
    @if(Session::has('error'))
       {{Session::get("error")}}
        <br>
    @endif

    {!! Form::label('new_password', 'Новый пароль') !!}
    {!! Form::password('new_password', ['class' => 'form-control']) !!}

    {!! Form::label('password_confirm', 'Повторите пароль') !!}
    {!! Form::password('password_confirm', ['class' => 'form-control']) !!}
    <br>
    {!! Form::submit('Save', ['class' => 'btn btn-default', 'id' => 'btn']) !!}

    <a class="btn btn-default btn-close" href="{{ url()->previous() }}">Cancel</a>

    {!! Form::close() !!}



@endsection