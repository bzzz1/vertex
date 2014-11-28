@extends('layout')
@extends('header')
@extends('footer')

@section('css')
	{{ HTML::style('css/style.css') }}
@stop

@section('body')
	<div class="width_960">
		<div class="article_area">
			@foreach($articles as $article)	
				<!-- article_prewiew -->
				<div class="article_preview">
					<h2 class="article_preview_header">{{ $article->title }}</h2>
					{{ HTML::image("photos/$article->image", 'article', ['class'=>'article_photo_preview']) }}
					<p class="article_preview_text">
						{{ $article->body }}
					</p>
					<div class="article_button">
						<p class="article_button_p">Читать</p>
					</div>	
				</div> <!-- article_preview -->
				<!-- article_full -->
			@endforeach
		</div>	
	</div>	
@stop