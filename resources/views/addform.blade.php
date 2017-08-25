@extends('layouts.main')
@section('title', 'AddForm')
@section('content')

    <div class="row">
        <h1>Добавить нагрузку для </h1>



        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        {!! Form::open(['url' => ['updateLoad', $idProf]]) !!}
        <table class="table">
            <tbody>
            @php $i=0; @endphp
        @foreach ($arrLoad as $arr)
            <tr>
                <td>{{$arr->type}}</td>
                <td id={{$i}}>@php  echo \HoursLoad\Subject::getFreeHours($arr->idLoadSub, $arr->hours);  @endphp</td>
                <td> {!! Form::number('hours['.$i.']', null, ['id' => 'i-'.$i ,'step' =>'any']) !!}</td>
                {!! Form::hidden('idLoadSub['.$i.']', $arr->idLoadSub) !!}
                @php
                    $i++;
                @endphp
            </tr>
        @endforeach
            </tbody>
        </table>
        <label> <input type="checkbox" id="allField" name="Все часы" value="allField" onclick="checkAll({{$i}})">Все часы</label>
        {!! Form::submit('Save', ['class' => 'btn btn-default', 'id' => 'btn']) !!}



        {!! Form::close() !!}
        <p id="error"></p>
    </div>

    <script>
        function checkAll(i) {
            if(document.getElementById('allField').checked){
                for (var j = 0; j < i; j++){
                    document.getElementById("i-" + j).value = document.getElementById(j).innerHTML
                }
            }
            else {
                for (var j = 0; j < i; j++){
                    document.getElementById("i-" + j).value =''
                }
            }
        }
        
        
        function validate(i) {
            for (var j = 0; j < i; j++){
                if(document.getElementById("i-" + j).value > document.getElementById(j).innerHTML)
                    document.getElementById('error').innerHTML = "ERROR";
                else
                    return alert(true);

            }
           //console.log(document.getElementsByName("hours")[0].value);
        }


    </script>
@endsection