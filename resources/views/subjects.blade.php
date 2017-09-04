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
            <li class="breadcrumb-item"><a href={{isset($idProf) ? url()->to('profile/'.$idProf) :  url()->previous()}}>Back</a></li>
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

    <div class="row center-block hoverT">
        <table class="table table-hover ">
            <thead>
                <tr>
                    @if(isset($idProf))
                        <th>Назначить <br>препода-<br>вателя</th>
                    @endif
                    <th>Предмет</th>
                    <th>Специальность</th>
                    <th>Курс</th>
                    <th>Семестр</th>
                    @php
                        $countOfFreeSub = 0;
                       $types = \HoursLoad\TypeOfWork::all(array('idTypeOfWork','type'));
                    foreach ($types as $type)
                        echo "<th>".$type->type."</th>";
                    @endphp
                    <th>Итого</th>
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
                            $freeHour = \HoursLoad\Subject::getAllTime($w->idSubjects) - \HoursLoad\Subject::getAllLoadsTime($w->idSubjects);
                        @endphp
                        @if($freeHour > 0)
                            <tr>
                                @if(isset($idProf))
                                    <td><a href="{{url("addform/$idProf/$s->idSubjects")}}"><i class="fa fa-plus-circle" id="faic"></i></a></td>
                                @endif
                                <td><b>{{$w->name}}</b></td>
                                <td>{{$w->specialty}}</td>
                                <td>{{$w->course}}</td>
                                <td>{{$w->term}}</td>
                                @foreach ($types as $type)
                                    @php
                                        $countOfFreeSub++;
                                        $t = \HoursLoad\TypeOfWork::getTimeForType($w->idSubjects, $type->idTypeOfWork);
                                        $freeHours = (count($t) > 0) ?
                                                        \HoursLoad\Subject::getFreeHours($t[0]->idLoadSub, $t[0]->hours) :
                                                        0;
                                         $allFreeHours += $freeHours;
                                    @endphp
                                        <td>{{$freeHours}}</td>
                                @endforeach

                                <td>{{$allFreeHours}}</td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
            </tbody>
        </table>

        @if($countOfFreeSub == 0)
            <h3 style="text-align: center">Нет вакансий</h3>
        @endif

    </div>
@endsection