@extends('layout')
@extends('header')
@extends('footer')

@section('body')
	<div class="width_960 catalog_gen">
		@foreach($articles as $article)	
			<div class="article_preview">
				<h2 class="article_preview_header">{{ $article->title }}</h2>
				<div class="article_photo_preview_div">
					{{ HTML::image("photos/articles/$article->image", 'article', ['class'=>'article_photo_preview']) }}
				</div>
				<p class="article_preview_text">{{ $article->body }}</p>
				{{ Form::button('Читать', ['class'=>'article_button article_button_read']) }}
			</div>
		@endforeach
	</div><!-- width_960 catalog_gen -->
@stop