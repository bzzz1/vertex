@extends('layout')
@extends('admin/admin_header')
@extends('footer')

@section('body')
	<div class="width_960">
		<div class='catalog_gen'>
			@foreach($articles as $article)	
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
			@endforeach
		</div><!-- catalog_gen -->
	</div><!-- width_960 -->
@stop