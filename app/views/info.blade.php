@extends('layout')
@extends('header')
@extends('footer')

@section('body')
	<div class="width_960">
		<div class='catalog_gen'>
			<div class="article_area">
				@foreach($articles as $article)	
					<div class="article_preview">
						<h2 class="article_preview_header">{{ $article->title }}</h2>
						{{ HTML::image("photos/$article->image", 'article', ['class'=>'article_photo_preview']) }}
						<p class="article_preview_text">{{ $article->body }}</p>
						{{ Form::button('Читать', ['class'=>'article_button article_button_read']) }}
					</div>
				@endforeach
			</div>	
		</div><!-- catalog_gen -->
	</div>	
@stop