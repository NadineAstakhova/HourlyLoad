@extends('layouts.main')
@section('title', 'Profile')
@section('content')
    <script>
        $(document).ready(function (e) {
            $('#delete_btn').on('click', function () {
                return confirm('Вы уверены, что хотите убрать всю нагрузку по предмету для преподавателя?');
            });
        });
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip({placement: "bottom"});
        });
    </script>
        <div class="row">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href={{url("prof")}}>Back</a></li>
                <li class="breadcrumb-item active">{{$user->lastName}} {{$user->firstName}}</li>
            </ol>
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
            <table class="table table-hover ">
                <thead>
                <tr>
                    <th>Предмет</th>
                    <th>Вид работы</th>
                    <th>Часы</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($user->subjects as $sub)
                    @if (in_array($sub->term,\HoursLoad\Subject::$AUTUMN_TERM))
                    <tr>
                        <td>{{$sub->name}}
                            <a href="{{url("delete/$user->idProfessors/$sub->idSubjects")}}" id="delete_btn"
                               data-toggle="tooltip" title="Снять дисциплину полностью">
                                <i class="fa fa-remove sng-red"></i>
                            </a>
                        </td>
                        <td>{{$sub->type}}</td>
                        <td>{{$sub->time}}</td>
                    </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
            <h4>Итого по осени: <?php echo \HoursLoad\Professors::setHourAutumn($user->subjects);?></h4>
        </div>
        <div class="row center-block">
            <h3 id="h3center">ВЕСНА</h3>
            <table class="table table-hover ">
                <thead>
                <tr>
                    <th>Предмет</th>
                    <th>Вид работы</th>
                    <th>Часы</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($user->subjects as $sub)
                    @if (in_array($sub->term,\HoursLoad\Subject::$SPRING_TERM))
                    <tr>
                        <td>{{$sub->name}}
                            <a href="{{url("delete/$user->idProfessors/$sub->idSubjects")}}" id="delete_btn"
                               data-toggle="tooltip" title="Снять дисциплину полностью">
                                <i class="fa fa-remove sng-red"></i>
                            </a>
                        </td>
                        <td>{{$sub->type}}</td>
                        <td>{{$sub->time}}</td>
                    </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
            <h4>Итого по весне: <?php echo \HoursLoad\Professors::setHourSpring($user->subjects);?></h4>
            <h4><b>Итого всего: <?php echo \HoursLoad\Professors::getAllSumHours();?></b></h4>
        </div>
@endsection