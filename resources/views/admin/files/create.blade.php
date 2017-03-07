@extends('admin.template.main')

@section('title',  'Agregar File')

@section('content')

{!!  Form::open(['route'=>'files.store','method'=>'POST' , 'files' => true]) !!}

<div class="form-group">
{!! Form::label('name','Name') !!}
{!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Name for file','required'  ]) !!}



{!! Form::label('description','Description') !!}
{!! Form::text('description',null,['class'=>'form-control','placeholder'=>'Open Description','required']) !!}



{!! Form::label('filefield','File') !!}
{!! Form::file('filefield',null,['class'=>'form-control','placeholder'=>'Select File','required']) !!}



<!--
{!! Form::label('file','File') !!}
{!! Form::text('file',null,['class'=>'form-control','placeholder'=>'Write File Name','required','disabled']) !!}

{!! Form::label('size','Size') !!}
{!! Form::text('size',null,['class'=>'form-control','placeholder'=>'Write Size','required','disabled']) !!}
-->



{!! Form::label('folder_id','Folder') !!}
{!!
Form::select('folder_id', $data['folders'], null, ['class' => 'form-control']);
!!}


{!! Form::label('extension_id','Extension') !!}
{!!Form::select('extension_id', $data['extensions'], null, ['class' => 'form-control']);
!!}


{!! Form::label('user_id','User') !!}
{!!Form::select('user_id', $data['users'], null, ['class' => 'form-control']);
!!}






</div>
<div class="form-group">

{!! Form::submit('Registrar',['class'=>'btn btn-primary']) !!}


</div>

{!!Form::close() !!}



@endsection


