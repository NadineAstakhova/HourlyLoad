@extends('layouts.main')
@section('title', 'Profile')
@section('content')
    <script>
        $(document).ready(function (e) {
            $('.delete_btn').on('click', function () {
                return confirm('Вы уверены, что хотите убрать всю нагрузку по предмету для преподавателя?');
            });

        });
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip({placement: "bottom"});
        });
        $(document).ready(function(){
            setTimeout(function(){$('#mesSuccessAdd').slideUp('slow')},5000);
        });
    </script>
        <div class="row">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href={{url("prof")}}>Back</a></li>
                <li class="breadcrumb-item active">{{$user->lastName}} {{$user->firstName}}</li>
            </ol>
            @php
                if(Session::has('save'))
                   echo "<div class='alert alert-success' id='mesSuccessAdd'>".Session::get("save")."</div>";
               if(Session::has('error'))
                   echo "<div class='alert alert-danger' id='mesSuccessAdd'>".Session::get("error")."</div>";
            @endphp
            <div class="col-xs-6 col-sm-8 col-lg-8">
                <h1>{{$user->lastName}} {{$user->firstName}} {{$user->patronomical}}</h1>
                <h4>Должность: {{$user->position}}</h4>
                <h4>Ставка: </h4>
            </div>
            <div class="col-xs-8 col-sm-4 col-lg-4" id="listBtn">
                <a href="{{url("subjects/$user->idProfessors")}}" class="btn btn-default btn-lg" id="listSub">Список вакансий</a>
            </div>

        </div>
        <div class="row center-block">
            <h3 id="h3center">Перечень дисциплин:</h3>
            <h3 id="h3center">ОСЕНЬ</h3>
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>Предмет</th>
                    <th>Специальность</th>
                    <th>Курс</th>
                    <th>Семестр</th>
                    @php
                        $types = \HoursLoad\TypeOfWork::all(array('idTypeOfWork','type'));
                        $hourAutumn = 0;
                        $hourSpring = 0;
                     foreach ($types as $type)
                         echo "<th>".$type->type."</th>";
                    @endphp
                    <th>Итого</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($user->subjects as $sub)
                    @php  $sumSubHours = 0 @endphp
                    @if (in_array($sub->term,\HoursLoad\Subject::$AUTUMN_TERM))
                    <tr>
                        <td>{{$sub->name}}
                            <a href="{{url("delete/$user->idProfessors/$sub->idSubjects")}}" class="delete_btn"
                               data-toggle="tooltip" title="Снять дисциплину полностью">
                                <i class="fa fa-remove sng-red"></i>
                            </a>
                            <a href="{{url("update/$user->idProfessors/$sub->idSubjects")}}" id="update_btn"
                               data-toggle="tooltip" title="Изменить дисциплину">
                                <i class="fa fa-pencil"></i>
                            </a>
                        </td>
                        <td>{{$sub->specialty}}</td>
                        <td>{{$sub->course}}</td>
                        <td>{{$sub->term}}</td>
                        @foreach ($types as $type)
                            @php
                                $t = \HoursLoad\TypeOfWork::getTimeForProfType($user->idProfessors, $type->idTypeOfWork,
                                                                                $sub->idSubjects);
                            $sumSubHours += (count($t) > 0) ? $t[0]->time : 0;
                            @endphp
                            <td>{{(count($t) > 0) ? $t[0]->time : 0}}</td>
                        @endforeach
                        <td>{{$sumSubHours}}</td>
                        @php  $hourAutumn += $sumSubHours; @endphp
                    </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
            <h4>Итого по осени: {{$hourAutumn}}</h4>
        </div>
        <div class="row center-block">
            <h3 id="h3center">ВЕСНА</h3>
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>Предмет</th>
                    <th>Специальность</th>
                    <th>Курс</th>
                    <th>Семестр</th>
                    @php
                        $types = \HoursLoad\TypeOfWork::all(array('idTypeOfWork','type'));
                     foreach ($types as $type)
                         echo "<th>".$type->type."</th>";
                    @endphp
                    <th>Итого</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($user->subjects as $sub)
                    @php  $sumSubHours = 0 @endphp
                    @if (in_array($sub->term,\HoursLoad\Subject::$SPRING_TERM))
                    <tr>
                        <td>{{$sub->name}}
                            <a href="{{url("delete/$user->idProfessors/$sub->idSubjects")}}" class="delete_btn"
                               data-toggle="tooltip" title="Снять дисциплину полностью">
                                <i class="fa fa-remove sng-red"></i>
                            </a>
                            <a href="{{url("update/$user->idProfessors/$sub->idSubjects")}}" id="update_btn"
                               data-toggle="tooltip" title="Изменить дисциплину">
                                <i class="fa fa-pencil"></i>
                            </a>
                        </td>
                        <td>{{$sub->specialty}}</td>
                        <td>{{$sub->course}}</td>
                        <td>{{$sub->term}}</td>
                        @foreach ($types as $type)
                            @php
                                $t = \HoursLoad\TypeOfWork::getTimeForProfType($user->idProfessors, $type->idTypeOfWork,
                                                                               $sub->idSubjects);
                                $sumSubHours += (count($t) > 0) ? $t[0]->time : 0;
                            @endphp
                            <td>{{(count($t) > 0) ? $t[0]->time : 0}}</td>
                        @endforeach
                        <td>{{$sumSubHours}}</td>
                        @php  $hourSpring += $sumSubHours; @endphp
                    </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
            <h4>Итого по весне: {{$hourSpring}}</h4>
            <h4><b>Итого всего: {{$hourSpring + $hourAutumn}}</b></h4>
        </div>
@endsection