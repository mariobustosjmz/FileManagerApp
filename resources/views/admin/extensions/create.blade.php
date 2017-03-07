@extends('admin.template.main')

@section('title',  'Add Extension')

@section('content')

{!!  Form::open(['route'=>'ext.store','method'=>'POST']) !!}

<div class="form-group">

{!! Form::label('name','Name') !!}
{!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Name for extension','required']) !!}

</div>

<div class="form-group">

{!! Form::submit('Save',['class'=>'btn btn-primary']) !!}


</div>

{!!Form::close() !!}



@endsection