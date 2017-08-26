@extends('layouts.main')
@section('title', 'Login')
@section('content')
    @if (count($errors))
        <ul>
            @foreach($errors as $error)
                <li>{!! $error !!}</li>
            @endforeach
        </ul>
    @endif

    {!! Form::open(['url' => ['auth/login'], 'class'=>'form-group']) !!}

    {!! Form::email('email', $value = null, $attributes = array()) !!}

    {!! Form::password('password') !!}

    {!! Form::submit('Login', ['class' => 'btn btn-default']) !!}

    {!! Form::close() !!}

@endsection