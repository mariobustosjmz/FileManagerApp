@extends('admin.template.main')

@section('title',  'Edit Folder')

@section('content')

{!!  Form::open(['route'=>['folders.update', $folder->id] ,'method'=>'PUT']) !!}

<div class="form-group">

{!! Form::label('name','Name') !!}
{!! Form::text('name',$folder->name,['class'=>'form-control','placeholder'=>'Name for folder','required']) !!}

</div>

<div class="form-group">

{!! Form::label('path','Path') !!}
{!! Form::text('path',$folder->path,['class'=>'form-control','placeholder'=>'Path of Folder','required']) !!}

</div>
<div class="form-group">

{!! Form::submit('Save',['class'=>'btn btn-primary']) !!}


</div>

{!!Form::close() !!}



@endsection