@extends('layouts.main')
@section('title', 'Subjects')
@section('content')
    <div class="row">
        <div class="col-xs-6 col-sm-8 col-lg-10">
            <h1>Список вакансий:</h1>
        </div>
    </div>
    <div class="row center-block" >
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Предмет</th>
                    <th>Тип работы</th>
                    <th>Свободные часы</th>
                    <th>Курс</th>
                    <th>Семестр</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sub as $s)
                    @php $freeHours = \HoursLoad\Subject::getFreeHours($s->idLoadSub, $s->hours)@endphp
                    @if ($freeHours != 0)
                    <tr>
                        <td>{{$s->name}}</td>
                        <td>{{$s->type}}</td>
                        <td>{{$freeHours}}</td>
                        <td>{{$s->course}}</td>
                        <td>{{$s->term}}</td>
                        <td><a href="{{url("addform/$idProf/$s->idSubjects")}}">Add</a></td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@endsection