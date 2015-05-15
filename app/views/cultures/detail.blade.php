@extends('templates.normal')


@section('content')
	<div id="page-wrapper">
		 Culture {{ $culture->id }}
		 Culture {{ $culture->name }}
		 Culture {{ $culture->description }}
	</div>
@endsection