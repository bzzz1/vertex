@extends('layout')
@extends('admin/admin_header')
@extends('footer')

@section('body')
	<div class="width_960 catalog_gen">
		<div class='change_article'>
			<h2 class="groups_title_admin">{{ $article->title }} </h2>
			{{ Form::model($article, ['url'=>['admin/info/updateArticle', $article->id], 'files'=>true, 'method'=>'POST', 'class'=>'item_form admin_info_form']) }}
				<div class="pad">
					<table class=fullwidth>
						<tr>
							<td>{{ Form::label('title', 'Заголовок: ', ['class'=>'main_label article_label_first']) }}</td>
							<td>{{ Form::text('title', null, ['class'=>'change_input form-control']) }}</td>
						</tr>
					</table>
				</div>

				{{ Form::textarea('body', null, ['class' => 'name form-control', 'id' => 'ckeditor']) }}

				<div class="pad">
					<table class=fullwidth>
						<tr>
							<td>{{ Form::label('time', 'Дата: ', ['class'=>'main_label article_label']) }}</td>
							<td>{{ Form::input('date', 'time', $article->time->format('Y-m-d'), ['class'=>'time_field form-control']) }}</td>
						</tr>
						<tr>
							<td>{{ Form::label('image', 'Изображение: 255px*255px', ['class'=>'main_label article_label ph_label']) }}</td>
							<td class='relative'>
								@if (isset($article->image))
									{{ Form::text('photo_name', $article->image, ['disabled', 'class'=>'change_input input_file_name photo_name form-control']) }}
									{{ Form::hidden('photo_name', $article->image, ['class'=>'change_input input_file_name photo_name']) }}
							 	@else 
									{{ Form::text('photo_name', null, ['disabled', 'placeholder'=>'no_image.png', 'class'=>'change_input input_file_name photo_name form-control']) }}
									{{-- use default value from mysql if not $article->image --}}
								@endif
								<div class="delete_icon del_art"></div>
								{{ Form::file('image', ['class'=>'change_input form-control']) }}
							</td>
						</tr>
					</table>
					{{ Form::submit('Сохранить', ['class'=>'submit_field save_button btn uni_btn']) }} 
				</div>
			{{ Form::close() }}
		</div>
		{{ HTML::link('/admin/info/changeArticle', 'Добавить статью', ['class'=>'admin_button_link btn uni_btn']) }}
		{{ HTML::link('/admin', 'Панель товаров', ['class'=>"admin_button_link r_btn btn uni_btn"]) }}
		{{ HTML::link('/admin/info', 'Панель информации', ['class'=>"admin_button_link r_btn btn uni_btn"]) }}
	</div><!--width_960 catalog_gen -->
@stop