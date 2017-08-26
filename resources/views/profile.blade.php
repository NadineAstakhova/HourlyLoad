@extends('layouts.main')
@section('title', 'Profile')
@section('content')
        <div class="row">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href={{url("prof")}}>Back</a></li>
                <li class="breadcrumb-item active">{{$user->lastName}} {{$user->firstName}}</li>
            </ol>
            <div class="col-xs-6 col-sm-8 col-lg-10">
                <h1>{{$user->lastName}} {{$user->firstName}} {{$user->patronomical}}</h1>
                <h3>{{$user->position}}  Ставка</h3>
                <h3>Перечень дисциплин:</h3>
            </div>
            <a href="{{url("subjects/$user->idProfessors")}}" class="btn btn-default" id="listSub">Список вакансий</a>
        </div>
        <div class="row center-block">
            <h3>ОСЕНЬ</h3>
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
                        <td>{{$sub->name}}</td>
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
            <h3>ВЕСНА</h3>
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
                        <td>{{$sub->name}}</td>
                        <td>{{$sub->type}}</td>
                        <td>{{$sub->time}}</td>
                    </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
            <h4>Итого по весне: <?php echo \HoursLoad\Professors::setHourSpring($user->subjects);?></h4>
            <h4>Итого всего: <?php echo \HoursLoad\Professors::getAllSumHours();?></h4>
        </div>
@endsection