@extends('layouts.main')
@section('title', 'Subjects')
@section('content')
    <script>
        $(document).ready(function(){
            setTimeout(function(){$('#mesSuccessAdd').slideUp('slow')},5000);
        });
    </script>
    <div class="row">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href={{ url()->previous() }}>Back</a></li>
            <li class="breadcrumb-item active">Вакансии</li>
        </ol>
        <div class="col-xs-6 col-sm-8 col-lg-10">

                 @php
                     if(Session::has('save'))
                        echo "<div class='alert alert-success' id='mesSuccessAdd'>".Session::get("save")."</div>";
                    if(Session::has('error'))
                        echo "<div class='alert alert-danger' id='mesSuccessAdd'>".Session::get("error")."</div>";
                 @endphp

            <h1>Список вакансий:</h1>
        </div>
    </div>
    <div class="row center-block">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Предмет</th>
                    <th>Тип работы</th>
                    <th>Свободные часы</th>
                    <th>Курс</th>
                    <th>Семестр</th>
                    @if(isset($idProf))
                    <th>Назначить <br>преподавателя</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($sub as $s)
                    @php
                        $works =  \HoursLoad\Subject::getSubjects($s->idSubjects);
                        $allFreeHours = 0;
                    @endphp
                    @foreach($works as $w)
                        @php
                            $freeHours = \HoursLoad\Subject::getFreeHours($w->idLoadSub, $w->hours);
                            $allFreeHours += $freeHours;
                        @endphp
                        @if ($freeHours != 0)
                            <tr>
                                <td>{{$w->name}}</td>
                                <td>{{$w->type}}</td>
                                <td>{{$freeHours}}</td>
                                <td>{{$w->course}}</td>
                                <td>{{$w->term}}</td>
                                <td></td>
                            </tr>
                        @endif
                    @endforeach
                    @if ($allFreeHours != 0)
                    <tr>
                        <td><b>{{$s->name}}</b></td>
                        <td><b>Всего свободных часов: </b></td>
                        <td><b>{{$allFreeHours}}</b></td>
                        <td>{{$s->course}}</td>
                        <td>{{$s->term}}</td>
                        @if(isset($idProf))
                        <td><a href="{{url("addform/$idProf/$s->idSubjects")}}"><i class="fa fa-plus-circle" id="faic"></i></a></td>
                        @endif
                    </tr>
                    @endif
                @endforeach

            </tbody>
        </table>
    </div>
@endsection