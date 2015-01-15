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
				<p class="header_contacts">(812) 982 33 54</p>
				<p class="header_contacts_2nd">8 (905) 222 335 47</p>
			</div>
			<h1 class="header_discription"> 
				Комплексное оснащение <br />
				баров, ресторанов, <br />
				кафе, пищевых <br />
				производств и магазинов.
			</h1>
		</header>
		<div class="main_nav">
			<nav>
				<div class="mask_nav_item">
					<a href="/items" class="nav_item @if ($env == 'items') selected @endif">Техника</a>
				</div>
				<div class="mask_nav_item">
					<a href="/spares" class="nav_item @if ($env == 'spares') selected @endif">Запчасти</a>
				</div>
				<div class="mask_nav_item">
					<a href="/info" class="nav_item @if ($env == 'info') selected @endif">Информация</a>
				</div>
			</nav>
			{{ Form::open(array('route' => "itemSearch", 'method' => 'GET', 'class'=>'header_search')) }}
				{{ Form::text('param', null, ['placeholder'=>"     Поиск товаров", 'class'=>'search_field']) }} 
			{{ Form::close() }}
		</div><!-- main_nav -->
	</div><!-- width_960 -->
	<hr class="navigation_hr" />
@stop