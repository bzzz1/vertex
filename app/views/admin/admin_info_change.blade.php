@extends('layout')
@extends('admin/admin_header')
@extends('footer')

@section('body')
	<div class="width_960 catalog_gen">
		<div class='change_item'>
			<h2 class="groups_title">Заголовок: {{ $article->title }} </h2>
			{{ Form::model($article, ['url'=>['admin/info/updateArticle', $article->id], 'files'=>true, 'method'=>'POST', 'class'=>'item_form admin_info_form']) }}
				<table>
					<tr>
						<td>{{ Form::label('title', 'Заголовок: ', ['class'=>'main_label']) }}</td>
						<td>{{ Form::text('title', null, ['class'=>'change_input']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('body', 'Текст: ', ['class'=>'main_label']) }}</td>
						<td>{{ Form::textarea('body', null, ['class'=>'change_input long_textarea']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('priority', 'Последовательность: ', ['class'=>'main_label']) }}</td>
						<td>{{ Form::text('priority', null, ['class'=>'change_input']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('image', 'Изображение: 255px*255px', ['class'=>'main_label']) }}</td>
						<td>
							@if (isset($article->image))
								{{ Form::text('photo_name', $article->image, ['disabled', 'class'=>'change_input input_file_name photo_name']) }}
								{{ Form::hidden('photo_name', $article->image, ['class'=>'change_input input_file_name photo_name']) }}
						 	@else 
								{{ Form::text('photo_name', null, ['disabled', 'placeholder'=>'no_image.png', 'class'=>'change_input input_file_name photo_name']) }}
								{{-- use default value from mysql if not $article->image --}}
							@endif
							<div class="delete_icon"></div>
							{{ Form::file('image', ['class'=>'change_input']) }}
						</td>
					</tr>
				</table>
				{{ Form::submit('Сохранить', ['class'=>'submit_field save_button']) }} 
			{{ Form::close() }}
		</div>
		{{ HTML::link('/admin/info/changeArticle', 'Добавить статью', ['class'=>'admin_button_link']) }}
		{{ HTML::link('/admin', 'Панель товаров', ['class'=>"admin_button_link"]) }}
		{{ HTML::link('/admin/info', 'Панель информации', ['class'=>"admin_button_link"]) }}
	</div><!--width_960 catalog_gen -->
@stop