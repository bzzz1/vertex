@extends('layout')
@extends('header')
@extends('footer')

@section('css')
	{{ HTML::style('css/style.css') }}
@stop

@section('body')
	<div class="width_960">
		<div class="main_menu">

			<div class="category_icon_block bar_icon_block" href="index.html">
				<div class="free_space"></div>
				<p class="category_icon_title">Барное</br>оборудование</p>
				<div class="subcategory_block">
					<div class="subcategory_block">
						<div class="subcategory_column">
							<ul>
								<li>
									{{ HTML::link("$env/Барное/Всё", 'Показать всё') }}
								</li>
								@foreach ($subcategories['Барное'] as $subcategory)
									<li>
										{{ HTML::link("$env/Барное/$subcategory", $subcategory) }}
									</li>
								@endforeach
							</ul>
						</div><!-- brands_column -->
					</div><!-- subcategory block -->
				</div>
			</div>
			<div class="category_icon_block neutral_icon_block" href="index.html">
				<div class="free_space"></div>
				<p class="category_icon_title">Нейтральное оборудование</p>
				<div class="subcategory_block">
					<div class="subcategory_column">
						<ul>
							<li>
								{{ HTML::link("$env/Нейтральное/Всё", 'Показать всё') }}
							</li>
							@foreach ($subcategories['Нейтральное'] as $subcategory)
								<li>
									{{ HTML::link("$env/Нейтральное/$subcategory", $subcategory) }}
								</li>
							@endforeach
						</ul>
					</div><!-- brands_column -->
				</div>
			</div>
			<div class="category_icon_block inventory_icon_block" href="index.html">
				<div class="free_space"></div>
				<p class="category_icon_title">Посуда и</br>инвентарь</p>
				<div class="subcategory_block">
					<div class="subcategory_column">
						<ul>
							<li>
								{{ HTML::link("$env/Посуда и инвентарь/Всё", 'Показать всё') }}
							</li>
							@foreach ($subcategories['Посуда и инвентарь'] as $subcategory)
								<li>
									{{ HTML::link("$env/Посуда и инвентарь/$subcategory", $subcategory) }}
								</li>
							@endforeach
						</ul>
					</div><!-- brands_column -->
				</div>
			</div>
			<div class="category_icon_block wash_icon_block" href="index.html">
				<div class="free_space"></div>
				<p class="category_icon_title">Посудомоечное оборудование</p>
				<div class="subcategory_block">
					<div class="subcategory_column">
						<ul>
							<li>
								{{ HTML::link("$env/Посудомоечное/Всё", 'Показать всё') }}
							</li>						
							@foreach ($subcategories['Посудомоечное'] as $subcategory)
								<li>
									{{ HTML::link("$env/Посудомоечное/$subcategory", $subcategory) }}
								</li>
							@endforeach
						</ul>
					</div><!-- brands_column -->
				</div>
			</div>
			<div class="category_icon_block tech_icon_block" href="index.html">
				<div class="free_space"></div>
				<p class="category_icon_title">Технологическое оборудование</p>
				<div class="subcategory_block">
					<div class="subcategory_column">
						<ul>
							<li>
								{{ HTML::link("$env/Технологическое/Всё", 'Показать всё') }}
							</li>						
							@foreach ($subcategories['Технологическое'] as $subcategory)
								<li>
									{{ HTML::link("$env/Технологическое/$subcategory", $subcategory) }}
								</li>
							@endforeach
						</ul>
					</div><!-- brands_column -->
				</div>
			</div>
			<div class="category_icon_block packing_icon_block" href="index.html">
				<div class="free_space"></div>
				<p class="category_icon_title">Упаковочное оборудование</p>
				<div class="subcategory_block">
					<div class="subcategory_column">
						<ul>
							<li>
								{{ HTML::link("$env/Упаковочное/Всё", 'Показать всё') }}
							</li>						
							@foreach ($subcategories['Упаковочное'] as $subcategory)
								<li>
									{{ HTML::link("$env/Упаковочное/$subcategory", $subcategory) }}
								</li>
							@endforeach
						</ul>
					</div><!-- brands_column -->
				</div>
			</div>
			<div class="category_icon_block bread_icon_block" href="index.html">
				<div class="free_space"></div>
				<p class="category_icon_title">Хлебопекарное оборудование</p>
				<div class="subcategory_block">
					<div class="subcategory_column">
						<ul>
							<li>
								{{ HTML::link("$env/Хлебопекарное/Всё", 'Показать всё') }}
							</li>						
							@foreach ($subcategories['Хлебопекарное'] as $subcategory)
								<li>
									{{ HTML::link("$env/Хлебопекарное/$subcategory", $subcategory) }}
								</li>
							@endforeach
						</ul>
					</div><!-- brands_column -->
				</div>
			</div>
			<div class="category_icon_block freez_icon_block" href="index.html">
				<div class="free_space"></div>
				<p class="category_icon_title">Холодильное оборудование</p>
				<div class="subcategory_block">
					<div class="subcategory_column">
						<ul>
							<li>
								{{ HTML::link("$env/Холодильное/Всё", 'Показать всё') }}
							</li>						
							@foreach ($subcategories['Холодильное'] as $subcategory)
								<li>
									{{ HTML::link("$env/Холодильное/$subcategory", $subcategory) }}
								</li>
							@endforeach
						</ul>
					</div><!-- brands_column -->
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
								<!!!script src="{{ asset('js/modernizr_columns.js') }}"></script>
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