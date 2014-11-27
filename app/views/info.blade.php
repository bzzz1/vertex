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
				<div class="article_preview" >
					<h2 class="article_preview_header">{{ $article->title }}</h2>
					<p class="article_preview_text">
						{{ HTML::image("photos/$article->image", 'article', ['class'=>'article_photo_preview']) }}
						{{ $article->body }}
					</p>
					<div class="article_button">
						<p class="article_button_p">Далее...</p>
					</div>	
				</div> <!-- article_preview -->
				<!-- article_full -->
				<div class="article_block" style="display:none">
					<h2 class="article_header"> {{ $article->title }} </h2>
					<p class="article_text">
						{{ HTML::image("photos/$article->image", 'article', ['class'=>'article_photo']) }}
						{{ $article->body }}
					</p>
					<div class="article_button">
						<p class="article_button_p">К списку</p>
					</div>
				</div><!-- article_block -->
			@endforeach
		</div>	
	</div>	
@stop