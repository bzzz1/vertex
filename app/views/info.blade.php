@extends('layout')
@extends('header')
@extends('footer')

@section('css')
	{{ HTML::style('css/style.css') }}
@stop

@section('body')
	<div class="width_960">
		@foreach($article as $article)	
			<!-- article_prewiew -->
			<div class="article_area">
				<div class="article_preview">
					<h2 class="article_preview_header">{{ $article->header }}</h2>
					<p class="article_preview_text">
						{{ HTML::image("photos/$article->photo", 'article', ['class'=>'article_photo_preview']) }}
						{{ $article->text }}
					</p>
					<div class="article_button">
						<p class="article_button_p">Далее...</p>
					</div>	
				</div> <!-- article_preview -->
				<!-- article_full -->
				<div class="article_block">
					<h2 class="article_header"> {{ $article->header }} </h2>
					<p class="article_text">
						{{ HTML::image("photos/$article->photo", 'article', ['class'=>'article_photo']) }}
						{{ $article->text }}
					</p>
					<div class="article_button">
						<p class="article_button_p">К списку</p>
					</div>
				</div><!-- article_block -->
				<div class="catalog_bottom_pages">
				<a class="catalog_sort_pages catalog_bottom_pages_item">1</a>
				<a class="catalog_sort_pages catalog_bottom_pages_item">2</a>
				<a class="catalog_sort_pages catalog_bottom_pages_item">3</a>
				<a class="catalog_sort_pages catalog_bottom_pages_item">4</a>
				<a class="catalog_sort_pages catalog_bottom_pages_item dots">...</a>
				<a class="catalog_sort_pages catalog_bottom_pages_item">9</a> <!-- pages_nav -->
				</div>
			</div>	
		@endforeach
	</div>	
@stop