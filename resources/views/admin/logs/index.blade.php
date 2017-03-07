@extends('admin.template.main')

@section('title','Logs List')


@section('content')

<hr>

<table class="table table-striped">
	<thead>
		<th>ID</th>
		 		<th>User </th>

		<th>Action</th>
		<th>Module </th>
 		<th>Date </th>


  	</thead>

	<tbody>
		@foreach($logs as $log)
			<tr>
				<td>{{$log->id}}</td>
								<td>{{$log->user->name}}</td>

				<td><b>{{$log->action}}</b></td>
				<td><span class="label label-primary ">
				{{$log->module}}
				</span></td>
				<td>{{$log->created_at->format('d-M-Y')}}</td>


			</tr>
		@endforeach
	</tbody>


{{--test test--}}

	</table>

	{!! $logs->render() !!}


	@endsection


