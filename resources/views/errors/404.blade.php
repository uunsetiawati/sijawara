@php
$config = \App\Models\Setting::first();
@endphp
@extends('app')
@section('script')
	<script>
		document.is_404 = true;
	</script>
@stop