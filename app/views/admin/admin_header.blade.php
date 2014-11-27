@section('header')
	<div class="width_960">
		<header>
			<h1 class="web_name">Vertex.ltd</h1>
			<a href="{{ URL::to('/') }}" class="h1_name">
				{{ HTML::image('icons/logo.png', 'Vertex - Комплексное оснащение баров, ресторанов, кафе, пищевых производств и магазинов') }} 
			</a>
			<div class="header_contscts_div">
				<p class="header_callback"> пн-пт с 9:00 до 18:00</p>
				<p class="header_callback_2nd"> Oбратный звонок</p>
				<p class="header_contacts"> +7 (495) 649 1461</p>
				<p class="header_contacts_2nd"> +7 (495) 649 1461</p>
			</div>
			<h1 class="header_discription"> 
				Комплексное оснащение <br />
				баров, ресторанов, <br />
				кафе, пищевых <br />
				производств и магазинов.
			</h1>
		</header>
		<div class="main_nav">
			{{ Form::open(array('route' => "codeSearchAdmin", 'method' => 'GET', 'class'=>'code_search')) }}
				{{ Form::text('code', null, ['placeholder'=>"     Поиск по коду", 'class'=>'search_field']) }} 
			{{ Form::close() }}
			{{ Form::open(array('route' => "itemSearchAdmin", 'method' => 'GET', 'class'=>'header_search')) }}
				{{ Form::text('param', null, ['placeholder'=>"     Поиск товаров", 'class'=>'search_field']) }} 
			{{ Form::close() }}
		</div><!-- main_nav -->
	</div><!-- width_960 -->
	<hr class="navigation_hr" />
@stop