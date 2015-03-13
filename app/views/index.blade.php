@extends('layout')
@extends('header')
@extends('footer')

@section('body')
	<div class="width_960">
  
  <!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter28058841 = new Ya.Metrika({id:28058841,
                    webvisor:true,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/28058841" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

		<div class="main_menu">

			<div class="category_icon_block bar_icon_block" data-category='Барное'>
				<div class="free_space"></div>
				<p class="category_icon_title">Барное</br>оборудование</p>
			</div>
			<div class="category_icon_block neutral_icon_block" data-category='Нейтральное'>
				<div class="free_space"></div>
				<p class="category_icon_title">Нейтральное оборудование</p>
			</div>			
			<div class="category_icon_block inventory_icon_block" data-category='Посуда и инвентарь'>
				<div class="free_space"></div>
				<p class="category_icon_title">Посуда и</br>инвентарь</p>
			</div>
			<div class="category_icon_block wash_icon_block" data-category='Посудомоечное'>
				<div class="free_space"></div>
				<p class="category_icon_title">Посудомоечное оборудование</p>
			</div>
			
			<div class="subcategory_block first_line" data-category='Барное'>
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
			<div class="subcategory_block first_line" data-category='Нейтральное'>
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
			<div class="subcategory_block first_line" data-category='Посуда и инвентарь'>
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
			<div class="subcategory_block first_line" data-category='Посудомоечное'>
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

			<div class="category_icon_block tech_icon_block" data-category='Технологическое'>
				<div class="free_space"></div>
				<p class="category_icon_title">Технологическое оборудование</p>
			</div>
			<div class="category_icon_block packing_icon_block" data-category='Упаковочное'>
				<div class="free_space"></div>
				<p class="category_icon_title">Упаковочное оборудование</p>
			</div>
			<div class="category_icon_block bread_icon_block" data-category='Хлебопекарное'>
				<div class="free_space"></div>
				<p class="category_icon_title">Хлебопекарное оборудование</p>
			</div>
			<div class="category_icon_block freez_icon_block" data-category='Холодильное'>
				<div class="free_space"></div>
				<p class="category_icon_title">Холодильное оборудование</p>
			</div>
			<div class="subcategory_block second_line" data-category='Технологическое'>
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
			<div class="subcategory_block second_line" data-category='Упаковочное'>
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
			<div class="subcategory_block second_line" data-category='Хлебопекарное'>
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
			<div class="subcategory_block second_line" data-category='Холодильное'>
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