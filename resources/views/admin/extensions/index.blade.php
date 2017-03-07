@extends('admin.template.main')

@section('title','Extensions List')


@section('content')

<a href="{{ route('ext.create') }}" class="btn btn-primary"> New Extension</a>
<hr>

<table class="table table-striped">
	<thead>
		<th>ID</th>
		<th>Name</th>
  		<th>Created </th>
		<th>@ </th>


  	</thead>

	<tbody>
		@foreach($extensions as $extension)
		<tr>
			<td>{{$extension->id}}</td>
			<td>{{$extension->name}}</td>
	 			<td>{{$extension->updated_at->format('d-M-Y')}}</td>
@if (Auth::guest())
@elseif (Auth::user()->type=="admin")
			<td>

			<a href="{{route('ext.edit' , $extension->id) }}" class="btn btn-warning"><span class="glyphicon glyphicon-pencil
			"></span></a>
			<a href="{{ route('admin.ext.destroy', $extension->id) }}" class="btn btn-danger"><span class="glyphicon glyphicon-remove
				"></span></a>


				 </td>
				 @endif

		</tr>
			@endforeach
		</tbody>

	</table>

	{!! $extensions->render() !!}


	@endsection


