@extends('layout')
@extends('admin/admin_header')
@extends('footer')
@section('meta')
	<meta http-equiv="refresh" content="1;URL=http:/admin/import_s/?offset={{$offset}}" />
@stop

@section('body')
	<div class="width_960 catalog_gen">
		<div class="top">
			<h1>Происходит иморт файла {{$original_name}}</h1>
			<p>Импорт займет примерно {{round(($max_row/$iteration)*10/60)}} минут</p>
			{{--<p>Подождите немного.</p>--}}
		</div>
		<div class="status">
			<h2>Статус импорта</h2>
			<p class="status_text">Импортируются товары с {{$offset-$iteration-$skip}} по {{$offset-$skip}} из {{$max_row}}</p>
		</div>
		<div class="loader">
			<p><span>Импортровано </span> <span class="js_status">{{round(($offset/$max_row)*100)}}%</span></p>
			<div class="for_loader">
				<p class="point"></p>
			</div>
		</div>
		<div class="fact">
			<h2>Интересный факт</h2>
			<p class="fact_text"></p>
		</div>
	</div>


		<script>
		$persantage = $('.js_status').text();
		console.log($persantage);
		$('.point').css('width', $persantage);
		function randomInteger(min, max) {
		  var rand = min + Math.random() * (max - min)
		  rand = Math.round(rand);
		  return rand;
		}
			$ran =randomInteger(1,10);
			if ($ran == 1) {
				$('.fact_text').text('Англичане пьют чая больше, чем жители любой другой страны. Например, в двадцать раз больше, чем американцы.');
			} else if($ran == 2) {
				$('.fact_text').text('В среднем дети смеются около 400 раз в день, взрослые смеются около 15 раз в день.');
			} else if($ran == 3) {
				$('.fact_text').text('Уральские горы, разделяющие Россию на европейскую и азиатскую части – древнейшие в мире.');
			} else if($ran == 4) {
				$('.fact_text').text('Мужчины в течение жизни тратят 3 350 часов на сбривание 8,4 метров щетины.');
			} else if($ran == 5) {
				$('.fact_text').text('В течение жизни человек проходит расстояние, равное 5 экваторам Земли.');
			} else if($ran == 6) {
				$('.fact_text').text('В среднем человек засыпает в течение 7 минут.');
			} else if($ran == 7) {
				$('.fact_text').text('Вы разделяете свой день рождения почти с 20 миллионами человек в мире.');
			} else if($ran == 8) {
				$('.fact_text').text('В возрасте шести-семи месяцев ребёнок может одновременно дышать и глотать. Взрослые так не умеют.');
			} else if($ran == 9) {
				$('.fact_text').text('Чем выше доход мужчины, тем больше вероятность, что он изменяет жене.');
			} else if($ran == 10) {
				$('.fact_text').text('Каждые три минуты кто-то на Земле объявляет, что видел НЛО.');
			};
		</script>

		<style>
			.top,
			.status,
			.loader {
				color: #008CCB;
			}
			.top h1 {
				font-size: 37px;
				text-align: center;
			}
			.top p {
				text-align: center;
				font-size: 25px;
			}
			.status h2 {
				font-size: 33px;
				text-align: center;
			}
			.status p {
				text-align: center;
				font-size: 25px;
			}
			.loader p {
				text-align: center;
				font-size: 25px;
			}
			.fact h2 {
				font-size: 33px;
				text-align: center;
			} 
			.fact p {
				text-align: center;
				font-size: 25px;
				margin-bottom: 0;
			}
			.loader {
				position: relative;
				margin-bottom: 25px;
			}
			.for_loader {
				/*background-color: #008CCB;*/
				/*overflow: hidden;*/
				/*height: 100px;*/
				display: inline-block;
				width: 100%;
				border: 1px solid grey;
			}
			.point {
				float: left;
				width: 56%;
				height: 15px;
				text-align: left;
				background-color: #008CCB;
				display: inline-block;
				/*position: relative;*/
				/*left: 0;*/
				margin-bottom: 0;
			}
		</style>


		{{-- <span style="color:green">Импорт файла {{$original_name}}!</span> --}}
		{{-- <hr> --}}
		{{-- <span style="color:blue">Изменяются товары с {{$offset-$iteration}} по {{$offset}} из {{$max_row}}</span> --}}
		{{--<span style="color:blue">Импорт завершен, было изменено {{ $added }} товаров</span>--}}
		{{--<hr>--}}
		{{--<span style="color:black">Сообщения:</span></br>--}}
		{{--{{ HTML::ul($messages, ['style' => 'color:black']) }}--}}
		{{--<hr>--}}
		{{--<span style="color:orange">Дубли:</span></br>--}}
		{{-- HTML::ul($codes_duplication, ['style' => 'color:black']) --}}
		{{--<hr>--}}
		{{--<span style="color:red">{{ $missed }} товаров не было изменено. Ошибки:</span></br>--}}
		{{--{{ HTML::ul($errors, ['style' => 'color:red']) }}--}}
		{{--<hr>--}}
	{{--</div>--}}
@stop

