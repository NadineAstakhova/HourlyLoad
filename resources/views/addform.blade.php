@extends('layouts.main')
@section('title', 'AddForm')
@section('content')

    <div class="row">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href={{ url()->previous() }}>Back</a></li>
            <li class="breadcrumb-item active">Добавление дисциплины</li>
        </ol>
        <h1>Добавить нагрузку для @php echo \HoursLoad\Subject::getSubjectName($idSub); @endphp </h1>



        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <table class="table">
            <thead>
            <tr>
                <th>Тип работы</th>
                <th>Свободные часы</th>
                <th>Введите часы</th>
            </tr>
            </thead>
            <tbody>
            {!! Form::open(['url' => ['updateLoad', $idProf], 'class'=>'form-group']) !!}
            @php $i=0; @endphp
        @foreach ($arrLoad as $arr)
            <tr>
                <td>{{$arr->type}}</td>
                <td id='l{{$i}}'>@php  echo \HoursLoad\Subject::getFreeHours($arr->idLoadSub, $arr->hours);  @endphp</td>
                <td> {!! Form::number('hours['.$i.']', null,
                ['id' => $i ,'class' => 'form-control num','step' =>'any',  'placeholder'=>"1.2"]) !!}</td>
                {!! Form::hidden('idLoadSub['.$i.']', $arr->idLoadSub) !!}
                @php
                    $i++;
                @endphp
            </tr>
        @endforeach
            </tbody>
        </table>
        <label class="form-check-label">
            <input type="checkbox" id="allField" class="form-check-input" name=" Все часы" value="allField" onclick="checkAll({{$i}})">
            Все часы
        </label>
        <br>
        {!! Form::submit('Save', ['class' => 'btn btn-default', 'id' => 'btn', 'disabled' => 'true']) !!}



        {!! Form::close() !!}
        <p id="error"></p>
    </div>

    <script>
        $(document).ready(function (e) {
            let stack = new Array();
            let correct_num = new Array();
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
                    if (this.value != 0){
                        if (correct_num.indexOf(this.id)==-1){
                            correct_num.push(this.id);
                        }
                    }else{
                        if (correct_num.indexOf(this.id)!=-1){
                            correct_num.splice(correct_num.indexOf(this.id),1);
                        }
                    }

                    if (stack.indexOf(this.id)!=-1){
                        stack.splice(stack.indexOf(this.id),1);
                    }
                }

                if (stack.length == 0 && correct_num.length != 0){
                    $("#btn").prop('disabled', false);
                }
                else{
                    $("#btn").prop('disabled', true);
                }


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