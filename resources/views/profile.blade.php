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

        $(document).ready(function(){
            $('#print').click(function(){
                var printing_css = "<style media=print>" +
                    "#listBtn, .breadcrumb, .delete_btn, #update_btn{display: none;}" +
                    "table{text-align: center} </style>";
                var html_to_print=printing_css+$('#to_print').html();
                var iframe=$('<iframe id="print_frame">');
                $('body').append(iframe);
                var doc = $('#print_frame')[0].contentDocument || $('#print_frame')[0].contentWindow.document;
                var win = $('#print_frame')[0].contentWindow || $('#print_frame')[0];
                doc.getElementsByTagName('body')[0].innerHTML=html_to_print;


                win.print();
                $('iframe').remove();
            }); });
    </script>
    <div id='to_print'>
        <div class="row">
            @if( Auth::user()->role != '2')
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href={{url("prof/1")}}>Back</a></li>
                <li class="breadcrumb-item active">{{$user->lastName}} {{$user->firstName}}</li>
            </ol>
            @endif
            @php
                if(Session::has('save'))
                   echo "<div class='alert alert-success' id='mesSuccessAdd'>".Session::get("save")."</div>";
               if(Session::has('error'))
                   echo "<div class='alert alert-danger' id='mesSuccessAdd'>".Session::get("error")."</div>";
            $hourAutumn = 0;
            $hourSpring = 0;
            $sumHours = \HoursLoad\Professors::getAllSumHours($user->idProfessors);
            @endphp
            <div class="col-xs-6 col-sm-8 col-lg-8">
                <h1>{{$user->lastName}} {{$user->firstName}} {{$user->patronomical}}</h1>
                <h4>Должность: {{$user->position}}</h4>
                <h4>Ставка: {{round($sumHours / \HoursLoad\Professors::getLoadWage(), 2)}} </h4>
            </div>
            <div class="col-xs-8 col-sm-4 col-lg-4" id="listBtn">
                @if( Auth::user()->role != '2')
                <a href="{{url("subjects/$user->idProfessors")}}" class="btn btn-default btn-lg" id="listSub">Список вакансий</a>
                @endif
                <button class="btn btn-default btn-lg" id="print">Печать</button>
            </div>

        </div>
        <div class="row center-block">
            <h3 id="h3center">Перечень дисциплин:</h3>
            <h3 id="h3center">ОСЕНЬ</h3>
            @if(\HoursLoad\Professors::setHourAutumn($user->subjects) != 0)
            <div class="hoverT">
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
                    @if (in_array($sub->term,\HoursLoad\Subject::$AUTUMN_TERM))
                    <tr>
                        <td><b>{{$sub->name}}</b>
                            @if( Auth::user()->role != '2')
                            <a href="{{url("delete/$user->idProfessors/$sub->idSubjects")}}" class="delete_btn"
                               data-toggle="tooltip" title="Снять дисциплину полностью">
                                <i class="fa fa-remove sng-red"></i>
                            </a>
                            <a href="{{url("update/$user->idProfessors/$sub->idSubjects")}}" id="update_btn"
                               data-toggle="tooltip" title="Изменить дисциплину">
                                <i class="fa fa-pencil"></i>
                            </a>
                            @endif
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
            </div>
            <h4>Итого по осени: {{$hourAutumn}}</h4>
            @else
                <h4>Нет нагрузки у преподавателяя</h4>
            @endif
        </div>
        <div class="row center-block">
            <h3 id="h3center">ВЕСНА</h3>
            <div class="hoverT">
            @if(\HoursLoad\Professors::setHourSpring($user->subjects) != 0)
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
                        <td><b>{{$sub->name}}</b>
                            @if( Auth::user()->role != '2')
                            <a href="{{url("delete/$user->idProfessors/$sub->idSubjects")}}" class="delete_btn"
                               data-toggle="tooltip" title="Снять дисциплину полностью">
                                <i class="fa fa-remove sng-red"></i>
                            </a>
                            <a href="{{url("update/$user->idProfessors/$sub->idSubjects")}}" id="update_btn"
                               data-toggle="tooltip" title="Изменить дисциплину">
                                <i class="fa fa-pencil"></i>
                            </a>
                            @endif
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
            </div>
            <h4>Итого по весне: {{$hourSpring}}</h4>
            @else
                <h4>Нет нагрузки у преподавателя</h4>
            @endif
            <h4><b>Итого всего: {{$hourSpring + $hourAutumn}}</b></h4>
        </div>
    </div>
@endsection