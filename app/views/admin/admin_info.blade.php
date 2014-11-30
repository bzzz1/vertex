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
				{{ HTML::link("/admin/info/changeArticle/$article->id", 'Изменить', ['class'=>'article_button']) }}
				{{ Form::open(['url'=>['/admin/info/deleteArticle', $article->id], 'method'=>'POST', 'class'=>'article_form confirm_form']) }}
					{{ Form::submit('Удалить', ['class'=>'article_button confirm_delete']) }} 
				{{ Form::close() }}
			</div> <!-- article_preview -->
		@endforeach
		{{ HTML::link('/admin/info/changeArticle', 'Добавить статью', ['class'=>'admin_button_link']) }}
		{{ HTML::link('/admin/changeItem', 'Панель товаров', ['class'=>'admin_button_link']) }}
	</div><!--width_960 catalog_gen -->
@stop