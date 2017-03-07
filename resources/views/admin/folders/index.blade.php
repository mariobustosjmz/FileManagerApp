@extends('admin.template.main')

@section('title','Folders List')


@section('content')

<a href="{{ route('folders.create') }}" class="btn btn-primary"> New Folder</a>
<hr>

<table class="table table-striped">
	<thead>
		<th>ID</th>
		<th>Name</th>
		<th>Path </th>
 		<th>Updated </th>
		<th>@ </th>


  	</thead>

	<tbody>
		@foreach($folders as $folder)
			<tr>
				<td>{{$folder->id}}</td>
				<td>{{$folder->name}}</td>
				<td>{{$folder->path}}</td>
	 			<td>{{$folder->updated_at->format('d/M/Y')}}</td>
@if (Auth::guest())
@elseif (Auth::user()->type=="admin")
				<td>

				<a href="{{route('folders.edit' , $folder->id) }}" class="btn btn-warning"><span class="glyphicon glyphicon-pencil
				"></span></a>
				<a href="{{ route('admin.folders.destroy', $folder->id) }}" class="btn btn-danger"><span class="glyphicon glyphicon-remove
					"></span></a>
					 </td>
			
@endif
			</tr>
		@endforeach
	</tbody>


{{--test test--}}

	</table>

	{!! $folders->render() !!}


	@endsection


