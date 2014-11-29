@extends('layout')
@extends('admin/admin_header')
@extends('footer')

@section('body')
	<div class="width_960 catalog_gen">
		<div class='change_item'>
			<h2 class="groups_title">Заголовок: {{ $article->title }} </h2>
			{{ Form::model($article, ['route' => "codeSearchAdmin", 'method' => 'POST', 'class'=>'item_form']) }}
				<table>
					<tr>
						<td>{{ Form::label('title', 'Заголовок: ', ['class'=>'main_label']) }}</td>
						<td>{{ Form::text('title', null, ['placeholder'=>"", 'class'=>'change_input']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('body', 'Текст: ', ['class'=>'main_label']) }}</td>
						<td>{{ Form::textarea('body', null, ['placeholder'=>"", 'class'=>'change_input']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('priority', 'Последовательность: ', ['class'=>'main_label']) }}</td>
						<td>{{ Form::text('priority', null, ['placeholder'=>"", 'class'=>'change_input']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('image', 'Изображение: 255px*255px', ['class'=>'main_label']) }}</td>
						<td>
							{{ Form::text('image', null, ['disabled', 'class'=>'change_input input_file_name']) }}
							{{ Form::file('image', ['class'=>'change_input']) }}
						</td>
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
					{{ HTML::link('/admin', 'Панель товаров', ['class'=>"admin_button_link"]) }}
					{{ HTML::link('/admin/info', 'Панель информации', ['class'=>"admin_button_link"]) }}
				</div>
			</div>
		</div>
	</div><!--width_960 catalog_gen -->
@stop