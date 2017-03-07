<!DOCTYPE >
<html>
<head>

<title>@yield('title','Default') | Area Administracion </title>

<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }} " >
<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-theme.css') }} " >
<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }} " >

</head>


@if (!Auth::guest())
<body class="admin">

@include('admin.template.partials.nav')

@else
<body class="">

@include('admin.template.partials.nav_2')

@endif




<section class="container" >
<div class="panel panel-primary ">
  <div class="panel-heading">	@yield('title') </div>
  <div class="panel-body">

    @include('flash::message')
  @include('admin.template.partials.errors')
@yield('content')


 	</div>
</div>
</section>


<footer class="panel-footer">
	@yield('footer' ,'File Manager App')

</footer>


<script src="{{ asset('js/jquery-3.1.0.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>



</body>
</html>