@extends('layout')
@extends('admin/admin_header')
@extends('footer')

@section('body')
	<div class="width_960 catalog_gen">
		{{ $time }}
		{{ $mempeak }}
		<hr>
		<span style="color:blue">Импорт завершен, было изменено {{ $added }} товаров</span>
		<hr>
		<span style="color:red">{{ $missed }} товаров не было изменено. Ошибки:</span></br>
		{{ HTML::ul($errors, ['style' => 'color:red']) }}
		<hr>
	</div>
@stop