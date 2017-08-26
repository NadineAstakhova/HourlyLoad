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
                <td id='l{{$i}}'>@php  echo \HoursLoad\Subject::getFreeHours($arr->idLoadSub, $arr->hours);  @endphp</td>
                <td> {!! Form::number('hours['.$i.']', null, ['id' => $i ,'step' =>'any']) !!}</td>
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


        $(document).ready(function (e) {
        let stack = new Array();
        // logic
        $(":input").bind('keyup mouseup', function () {
            let lable = $("#l"+this.id);


            if(this.value > lable[0].innerHTML || this.value < 0){
                $(this).css({'border' : '2px solid red'});
                $("#btn").prop('disabled', true);
                if (stack.indexOf(this.id)==-1){
                    stack.push(this.id);
                }
            }
            else{
                $(this).css({'border' : '2px solid green'});
                if (stack.indexOf(this.id)!=-1){
                    stack.splice(stack.indexOf(this.id),1);
                }
            }

            if (stack.length == 0){
                $("#btn").prop('disabled', false);
            }
            console.log(stack);

        });
        });
        function checkAll(i) {
            if(document.getElementById('allField').checked){
                for (var j = 0; j < i; j++){
                    document.getElementById(j).value = document.getElementById("l" + j).innerHTML
                }
            }
            else {
                for (var j = 0; j < i; j++){
                    document.getElementById(j).value =''
                }
            }
        }


    </script>
@endsection