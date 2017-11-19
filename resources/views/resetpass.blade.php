@extends('layouts.main')
@section('title', 'Reset Pass')
@section('content')
    {!! Form::open(['url' => ['updatePass'], 'class'=>'form-group']) !!}
<h3>Для изменения пароля нужно заполнить следующие поля:</h3>
    {!! Form::label('cur_password', 'Текущий пароль') !!}

    {!! Form::password('cur_password', ['class' => 'form-control', 'required' => 'true']) !!}
    @if(Session::has('error'))
       <span class = "error"> {{Session::get("error")}} </span>
        <br>
    @endif

    {!! Form::label('new_password', 'Новый пароль') !!}
    {!! Form::password('new_password', ['class' => 'form-control', 'required' => 'true', 'id' => 'passNew', 'minlength' => 6]) !!}

    {!! Form::label('password_confirm', 'Повторите пароль') !!}
    {!! Form::password('password_confirm', ['class' => 'form-control', 'id' => 'passConf', 'required' => 'true', 'minlength' => 6]) !!}
    <span class = "error" id="conf"></span>
    <br>
    {!! Form::submit('Save', ['class' => 'btn btn-default', 'id' => 'btn', 'disabled' => 'true']) !!}

    <a class="btn btn-default btn-close" href="{{ url()->previous() }}">Cancel</a>

    {!! Form::close() !!}

<script>
    $('#passConf').keyup(function() {
       formval();
    });
    $('#passNew').keyup(function() {
        formval();
    });

    function formval() {
        if($('#passNew').val() != $('#passConf').val()) {
            $('#conf').html('Пароли не совпдают');
            $('#btn').prop( "disabled", true );
        }
        else {
            $('#conf').html('');
            $('#btn').prop( "disabled", false );

        }
    }

</script>

@endsection