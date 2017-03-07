@extends('admin.template.main')

@section('title','Editar Usuario  '.'<b>'.$user->name.'</b>')


@section('content')

{!!  Form::open(['route'=>['users.update', $user->id] , 'method'=>'PUT']) !!}


<div class="form-group">

{!! Form::label('name','Nombre') !!}

{!! Form::text('name',$user->name,['class'=>'form-control','placeholder'=>'Nombre Completo','required']) !!}
</div>


<div class="form-group">

{!! Form::label('email','Correo') !!}

{!! Form::email('email',$user->email,['class'=>'form-control','placeholder'=>'example@gmail.com','required']) !!}
</div>


<div class="form-group">

{!! Form::label('type','Tipo') !!}

{!! Form::select('type',[ ' ' => 'Seleccione...' , 'admin'=>'Administrador' , 'user'=>'Usuario' ] ,$user->type,['class'=>'form-control'] ) !!}
</div>



<div class="form-group">

{!! Form::submit('Editar' ,['class'=>'btn btn-large btn-block btn-primary']) !!}

</div>



{!!  Form::close() !!}


@endsection
