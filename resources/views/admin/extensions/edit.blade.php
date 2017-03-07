

@extends('admin.template.main')

@section('title',  'Add Extension')

@section('content')

{!!  Form::open(['route'=>['ext.update', $extension->id] ,'method'=>'PUT']) !!}

<div class="form-group">

{!! Form::label('name','Name') !!}
{!! Form::text('name',$extension->name,['class'=>'form-control','placeholder'=>'Name for extension','required']) !!}

</div>


<div class="form-group">

{!! Form::submit('Save',['class'=>'btn btn-primary']) !!}


</div>

{!!Form::close() !!}



@endsection