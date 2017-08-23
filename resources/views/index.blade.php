<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container-fluid">
            <div class="content">
                <div class="row">
                    <div class="col-xs-6 col-sm-8 col-lg-10">
                        <h1>Список преподавателей:</h1>
                        <a href="subjects" class="btn btn-default">Список вакансий</a>
                        <table class="table table-hover">
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
                                <td>2.9</td>
                                <td>3.7</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </body>
</html>