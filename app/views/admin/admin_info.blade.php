@extends('layout')
@extends('admin/admin_header')
@extends('footer')

@section('body')
	<div class='width_960 catalog_gen'>
		@foreach($articles as $article)	
			<div class="article_preview">
				<h2 class="article_preview_header">{{ $article->title }}</h2>
				{{ HTML::image("photos/$article->image", 'article', ['class'=>'article_photo_preview']) }}
				<p class="article_preview_text">
					{{ $article->body }}
				</p>
				{{ Form::button('Читать', ['class'=>'article_button article_button_read']) }}
				{{ Form::open(['url' => "/admin/info/changeArticle", 'method' => 'POST']) }}
					{{ Form::hidden('id', "$article->id") }}
					{{ Form::submit('Изменить', ['class'=>'article_button']) }} 
				{{ Form::close() }}
				{{ Form::button('Удалить', ['class'=>'article_button']) }}
			</div> <!-- article_preview -->
		@endforeach
		{{ HTML::link('/admin', 'Панель товаров', ['class'=>"admin_button_link"]) }}
	</div><!--width_960 catalog_gen -->
@stop