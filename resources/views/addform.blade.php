@extends('layouts.main')
@section('title', 'Subjects')
@section('content')

    <div class="row">
        Form

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        {!! Form::open(['url' => ['updateLoad', $idProf]]) !!}

        {!! Form::text('hours') !!}

        {!! Form::submit('Click Me!', ['class' => 'btn btn-default']) !!}

        {!! Form::close() !!}
    </div>
@endsection