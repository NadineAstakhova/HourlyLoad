@extends('layouts.main')
@section('title', 'AddForm')
@section('content')

    <div class="row">
        <h1>Добавить нагрузку для </h1>



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
        <table class="table">
            <tbody>
            @php
            $i=0;
            @endphp
        @foreach ($arrLoad as $arr)
            <tr>
                <td>{{$arr->type}}</td>
                <td>{{$arr->hours}}</td>
                <td>{{ $arr->idLoadSub}}</td>
                <td> {!! Form::text('hours['.$i.']') !!}</td>
                {!! Form::hidden('idLoadSub['.$i.']', $arr->idLoadSub) !!}
                @php
                    $i++;
                @endphp



            </tr>


        @endforeach
            </tbody>
        </table>
        {!! Form::submit('Click Me!', ['class' => 'btn btn-default']) !!}

        {!! Form::close() !!}
    </div>
@endsection