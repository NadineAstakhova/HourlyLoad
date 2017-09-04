@extends('layouts.main')
@section('title', 'All Subjects')
@section('content')
    <div class="row">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href={{ url()->previous()}}>Back</a></li>
            <li class="breadcrumb-item active">Вся нагрузка</li>
        </ol>
        <div class="col-xs-6 col-sm-8 col-lg-10">
            <h1>Вся нагрузка:</h1>
        </div>
    </div>

    <div class="row center-block hoverT">
        <table class="table table-hover ">
            <thead>
            <tr>
                <th>Предмет</th>
                <th>Специальность</th>
                <th>Курс</th>
                <th>Семестр</th>
                @php
                   $allSubHours = 0;
                   $allHoursForType = array();
                   $types = \HoursLoad\TypeOfWork::all(array('idTypeOfWork','type'));
             //   foreach ($types as $type)
                    for($i = 0; $i < count($types); $i++){
                        echo "<th>".$types[$i]->type."</th>";
                        $allHoursForType[$i] = 0;
                    }

                @endphp
                <th>Итого</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($sub as $s)
                @php
                    $works =  \HoursLoad\Subject::getSubjects($s->idSubjects);
                    $allHours = 0;
                @endphp
                @foreach($works as $w)
                        <tr>
                            <td><b>{{$w->name}}</b></td>
                            <td>{{$w->specialty}}</td>
                            <td>{{$w->course}}</td>
                            <td>{{$w->term}}</td>
                            @for($i = 0; $i < count($types); $i++)
                                @php
                                    $t = \HoursLoad\TypeOfWork::getTimeForType($w->idSubjects, $types[$i]->idTypeOfWork);
                                    $hours = (count($t) > 0) ? $t[0]->hours : 0;
                                    $allHoursForType[$i] += $hours;
                                    $allHours += $hours;
                                @endphp
                                <td>{{$hours}}</td>
                            @endfor
                            @php $allSubHours += $allHours; @endphp
                            <td>{{$allHours}}</td>
                        </tr>
                @endforeach
            @endforeach
            <tr id="sumH">
                <td colspan="4">Итого</td>
                @for($i = 0; $i < count($types); $i++)
                    <td>{{$allHoursForType[$i]}}</td>
                @endfor
                <td>{{$allSubHours}}</td>
            </tr>
            </tbody>
        </table>
    </div>

@endsection