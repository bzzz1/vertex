@extends('layout')
@extends('header')
@extends('footer')

@section('css')
	{{ HTML::style('css/style.css') }}
@stop

@section('body')
	<div class="width_960">
		<div class = "main_menu">
			<a class="main_icon_a" href="index.html">
				<div class="free_space"></div>
				<p class="">Холодильное оборудование</p>
			</a>
			<a class="main_icon_a" href="index.html">
				<div class="free_space"></div>
				<p class="">Холодильное оборудование</p>
			</a>
			<a class="main_icon_a" href="index.html">
				<div class="free_space"></div>
				<p class="">Холодильное оборудование</p>
			</a>
			<a class="main_icon_a" href="index.html">
				<div class="free_space"></div>
				<p class="">Холодильное оборудование</p>
			</a>
			<a class="main_icon_a" href="index.html">
				<div class="free_space"></div>
				<p class="">Холодильное оборудование</p>
			</a>
			<a class="main_icon_a" href="index.html">
				<div class="free_space"></div>
				<p class="">Холодильное оборудование</p>
			</a>
			<a class="main_icon_a" href="index.html">
				<div class="free_space"></div>
				<p class="">Холодильное оборудование</p>
			</a>
			<a class="main_icon_a" href="index.html">
				<div class="free_space"></div>
				<p class="">Холодильное оборудование</p>
			</a>
			<hr class = "main_hr" />
			<div class = "groups">
				<div class="brands">
					<div class="mask_title_sort">
						<p class="brands_sort title_sort">По брендам</p>
					</div>
					<div class="brands_column">
						<ul>
								<!--[if lt IE 10]>
									<script src="{{ asset('js/modernizr_columns.js') }}"></script>
								<![endif]-->

							@foreach ($all_brands as $brand)
								<li>
									{{ HTML::link("items/producer/$brand", $brand) }}
								</li>
							@endforeach
						</ul>
					</div><!-- brands_column -->
				</div><!-- brands -->
			</div> <!-- groups  -->
		</div><!-- main_menu -->
	</div><!-- width_960 -->
@stop