@extends('layout')
@extends('admin/admin_header')
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


		@if (isset($element))	
			<div class='change_item'>
				<h2 class="groups_title">Заголовок: {{ $article->title }} </h2>
				{{ Form::model($element, ['route' => "codeSearchAdmin", 'method' => 'POST', 'class'=>'item_form']) }}
					<table>
						<tr>
							<td>{{ Form::label('item', 'Заголовок: ', ['class'=>'main_label']) }}</td>
							<td>{{ Form::text('item', null, ['placeholder'=>"", 'class'=>'change_input']) }}</td>
						</tr>
						<tr>
							<td>{{ Form::label('description', 'Текст: ', ['class'=>'main_label']) }}</td>
							<td>{{ Form::textarea('description', null, ['placeholder'=>"", 'class'=>'change_input']) }}</td>
						</tr>
						<tr>
							<td>{{ Form::label('photo', 'Изображение: ', ['class'=>'main_label']) }}</td>
							<td>{{ Form::file('photo', ['class'=>'change_input input_file']) }}255px * 255px</td>
						</tr>
					</table>
				{{ Form::close() }}

				<div class='item_preview'>
					<div class="catalog_item">
						<h2 class="catalog_item_header">{{ $article->title }}</h2>
						<!--****************************************************
						| Info
						*****************************************************-->
						<!-- article_full -->
						<div class="article_block">
							<h2 class="article_header"> {{ $article->title }} </h2>
							<p class="article_text">
								{{ HTML::image("photos/$article->image", 'article', ['class'=>'article_photo']) }}
								{{ $article->body }}
							</p>
							<div class="article_button">
								<p class="article_button_p">Превью</p>
							</div>
						</div><!-- article_block -->
						<!--****************************************************-->
						<!-- article_prewiew -->
						<div class="article_preview" style="display:none">
							<h2 class="article_preview_header">{{ $article->title }}</h2>
							<p class="article_preview_text">
								{{ HTML::image("photos/$article->image", 'article', ['class'=>'article_photo_preview']) }}
								{{ $article->body }}
							</p>
							<div class="article_button">
								<p class="article_button_p">Полная статья</p>
							</div>	
						</div> <!-- article_preview -->
						<button class="info_page_admin_button">Перейти к редактированию товаров</button>	
					</div>
				</div>
			</div>
		@endif
		{{-- @if (isset($element)) --}}
		
	</div>	
@stop