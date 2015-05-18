@extends('templates.normal')


@section('content')
	<div id="page-wrapper">
		 Culture {{ $waterpoint->id }}
		 Culture {{ $waterpoint->name }}
		 Culture {{ $waterpoint->description }}
	</div>
@endsection