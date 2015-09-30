@extends('layout')
@extends('admin/admin_header')
@extends('footer')

@section('body')
	<div class="width_960 catalog_gen">
		{{-- {{ $time }} --}}
		{{-- {{ $mempeak }} --}}
		<hr>
		<span style="color:green">Импорт файла {{$original_name}} завершен!</span>
		<hr>
		<span style="color:blue">Импорт завершен, было изменено {{ $added }} товаров</span>
		<hr>
		<span style="color:orange">Дубли:</span></br>
		<ul>
			{{print_r($codes_duplications);}}
			{{--@foreach ($codes_duplications as $duplication)--}}
				{{--@foreach($duplication as $code=>$rows)--}}
					{{--<li>{{$code}} встречается на строке--}}
						{{--@foreach($rows as $row)--}}
							{{--{{$row}}--}}
						{{--@endforeach--}}
					{{--</li>--}}
				{{--@endforeach--}}
			{{--@endforeach--}}
		</ul>
		<hr>
		<span style="color:red">{{ $missed }} товаров не было изменено. Ошибки:</span></br>
		{{ HTML::ul($errors, ['style' => 'color:red']) }}
		<hr>
	</div>
@stop