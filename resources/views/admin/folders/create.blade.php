@extends('admin.template.main')

@section('title',  'Add Folder')

@section('content')

{!!  Form::open(['route'=>'folders.store','method'=>'POST']) !!}

<div class="form-group">

{!! Form::label('name','Name') !!}
{!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Name for folder','required']) !!}

</div>

<div class="form-group">

{!! Form::label('path','Path') !!}
{!! Form::text('path',null,['class'=>'form-control','placeholder'=>'Path of Folder','required']) !!}

</div>
<div class="form-group">

{!! Form::submit('Save',['class'=>'btn btn-primary']) !!}


</div>

{!!Form::close() !!}



@endsection