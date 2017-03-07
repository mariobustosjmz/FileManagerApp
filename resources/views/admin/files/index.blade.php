@extends('admin.template.main')

@section('title','Files List')


@section('content')

<a href="{{ route('files.create') }}" class="btn btn-primary"> New File</a>
<hr>

<table class="table table-striped">
	<thead>
		<th>ID</th>
		<th>Name</th>
		<th>Description </th>
		<th>File </th>
		<th>Mime </th>
		<th>Size </th>
		<th>Folder </th>
		<th>Extension </th>
		<th>User </th>
		<th>Updated </th>
		<th>@ </th>


  	</thead>

	<tbody>
		@foreach($files as $file)
		<tr>
			<td>{{$file->id}}</td>
			<td>{{$file->name}}</td>
			<td>{{$file->description}}</td>
			<td>{{$file->file}}</td>
			<td>{{$file->mime}}</td>
			<td>{{$file->size}}</td>
			<td>{{$file->folder->name}}</td>
			<td>{{$file->extension->name}}</td>
			<td>{{$file->user->name}}</td>
			<td>{{$file->updated_at->format('d-m-Y')}}</td>

			<td>


			<a href="{{route('files.get' , $file->id) }}" class="btn btn-primary"><span class="glyphicon glyphicon-download"></span></a>
@if (Auth::guest())
@elseif (Auth::user()->type=="admin")
			<a href="{{route('files.edit' , $file->id) }}" class="btn btn-warning"><span class="glyphicon glyphicon-pencil
			"></span></a>

 			<a href="{{ route('admin.files.destroy', $file->id) }}" class="btn btn-danger"><span class="glyphicon glyphicon-remove
				"></span></a>
				@endif

				 </td>

		</tr>
			@endforeach
		</tbody>

	</table>

	{!! $files->render() !!}


	@endsection


