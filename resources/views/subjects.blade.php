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
                <h1>Список вакансий:</h1>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Предмет</th>
                        <th>Свободные часы</th>
                        <th>Курс</th>
                        <th>Семестр</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($sub as $s)
                        <tr>
                            <td>{{$s->name}}</td>
                            <td>3</td>
                            <td>{{$s->course}}</td>
                            <td>{{$s->term}}</td>
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