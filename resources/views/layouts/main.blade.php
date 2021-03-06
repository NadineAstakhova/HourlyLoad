<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>


</head>
<body>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href={{Auth::check() && Auth::user()->role == 1 ? url("prof/1" ) :  url("prof/2" )}}>Система распределения нагрузки кафедры КТ</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
                @if ( Auth::check() && Auth::user()->role == 1)
                    <li><a href={{url("prof/1")}}>Преподаватели</a></li>
                    <li><a href={{url("subjects")}}>Вакансии</a></li>
                    <li><a href={{url("allsubjects")}}>Вся нагрузка</a></li>
                @endif
                    @if ( Auth::check() && Auth::user()->role == 2)
                        <li><a href={{url("resetpass")}}>Изменить пароль</a></li>
                    @endif
                <li><a href="{{Auth::check() ? url('auth/logout') : url('auth/login')}}">
                        <span class="glyphicon glyphicon-log-in"></span>
                        {{Auth::check() ? 'Logout' : 'Login'}}</a>
                </li>

            </ul>
        </div>
    </div>
</nav>
    <div class="container">
        @yield('content')
    </div>

</body>
</html>