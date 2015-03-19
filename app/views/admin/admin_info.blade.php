@extends('layout')
@extends('admin/admin_header')
@extends('footer')

@section('body')
	<div class='width_960 catalog_gen'>
		{{ HTML::link('/admin/info/changeArticle', 'Добавить статью', ['class'=>' btn uni_btn adm_info_btn last_btn']) }}
		{{ HTML::link('/admin/changeItem', 'Панель товаров', ['class'=>' btn uni_btn adm_info_btn']) }}
		@foreach($articles as $article)	
			<div class="article_preview">
				<div class="art_prewiew_head_block">
					<h2 class="article_preview_header">{{ $article->title }}</h2>
					<p class="article_prewiew_date">{{ Carbon::parse($article->time)->format('d-m-Y') }}</p>
				</div>
				<div class="article_photo_preview_div">
					@if ($article->image != 'no_image.png')
						{{ HTML::image("photos/articles/$article->image", 'article', ['class'=>'article_photo_preview']) }}
					@endif	
				</div>
				<div class='article_preview_text'>
					{{ $article->body }}
				</div>
				{{ Form::button('Читать', ['class'=>'article_button article_button_read']) }}
				{{ HTML::link("/admin/info/changeArticle/$article->id", 'Изменить', ['class'=>'article_button']) }}
				{{ Form::open(['url'=>['/admin/info/deleteArticle', $article->id], 'method'=>'POST', 'class'=>'article_form confirm_form']) }}
					{{ Form::submit('Удалить', ['class'=>'article_button confirm_delete']) }} 
				{{ Form::close() }}
			</div><!-- article_preview -->
		@endforeach
	</div><!--width_960 catalog_gen -->
@stop