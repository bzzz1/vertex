@extends('layout')
@extends('header')
@extends('footer')

@section('css')
	{{ HTML::style('css/style.css') }}
@stop

@section('body')
	<div class="width_960">
		<div class="main_menu">
			<div class="category_icon_block" href="index.html">
				<div class="free_space"></div>
				<p class="category_icon_title">Барное</br>оборудование</p>
				<div class="subcategory_block">
					<!-- #subcategory -->
				</div>
			</div>
			<div class="category_icon_block" href="index.html">
				<div class="free_space"></div>
				<p class="category_icon_title">Нейтральное оборудование</p>
				<div class="subcategory_block">
					<!-- #subcategory -->
				</div>
			</div>
			<div class="category_icon_block" href="index.html">
				<div class="free_space"></div>
				<p class="category_icon_title">Посуда и</br>инвентарь</p>
				<div class="subcategory_block">
					<!-- #subcategory -->
				</div>
			</div>
			<div class="category_icon_block" href="index.html">
				<div class="free_space"></div>
				<p class="category_icon_title">Посудомоечное оборудование</p>
				<div class="subcategory_block">
					<!-- #subcategory -->
				</div>
			</div>
			<div class="category_icon_block" href="index.html">
				<div class="free_space"></div>
				<p class="category_icon_title">Технологическое оборудование</p>
				<div class="subcategory_block">
					<!-- #subcategory -->
				</div>
			</div>
			<div class="category_icon_block" href="index.html">
				<div class="free_space"></div>
				<p class="category_icon_title">Упаковочное оборудование</p>
				<div class="subcategory_block">
					<!-- #subcategory -->
				</div>
			</div>
			<div class="category_icon_block" href="index.html">
				<div class="free_space"></div>
				<p class="category_icon_title">Хлебопекарское оборудование</p>
				<div class="subcategory_block">
					<!-- #subcategory -->
				</div>
			</div>
			<div class="category_icon_block" href="index.html">
				<div class="free_space"></div>
				<p class="category_icon_title">Холодильное оборудование</p>
				<div class="subcategory_block">
					<!-- #subcategory -->
				</div>
			</div>
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
							@foreach ($brands as $brand)
								<li>
									{{ HTML::link("$env/$brand", $brand) }}
								</li>
							@endforeach
						</ul>
					</div><!-- brands_column -->
				</div><!-- brands -->
			</div> <!-- groups  -->
		</div><!-- main_menu -->
	</div><!-- width_960 -->
@stop