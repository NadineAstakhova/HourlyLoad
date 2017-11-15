@extends('layouts.main')
@section('title', 'Professors')
@section('content')
   
    <div class="row" >
        <div class="col-xs-6 col-sm-8 col-lg-8">
            <h1>Список преподавателей:</h1>
        </div>
        <div class="col-xs-8 col-sm-4 col-lg-4" id="listBtn">
            <a href="{{url("subjects")}}" class="btn btn-default" id="listSub">Список вакансий</a>
            <a href="allsubjects" class="btn btn-default" id="listSub">Вся нагрузка</a>
        </div>
    </div>
    <div class="row center-block">
        <table class="table table-hover" style="font-size: 14px">
            <thead>
                <tr>
                    <th>ФИО</th>
                    <th>Должность</th>
                    <th>Ставка</th>
                    <th>Нагрузка в часах</th>
                    <th>Нагрузка в ставках</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($prof as $p)
                    <tr>
                        <td><a href="{{url("profile/$p->idProfessors")}}">{{$p->lastName}} {{$p->firstName}} {{$p->patronomical}}</a></td>
                        <td>{{$p->position}}</td>
                        <td>{{$p->wageRate}}</td>
                        <td>@php
                                $sumHours = \HoursLoad\Professors::getAllSumHours($p->idProfessors);
                                echo $sumHours;
                            @endphp
                        </td>
                        <td>@php echo round($sumHours / \HoursLoad\Professors::getLoadWage(), 2); @endphp
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
