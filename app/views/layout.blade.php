<!DOCTYPE html>

<html lang="en">

<head>

	<meta charset="UTF-8">

	<meta name='viewport' content='width=960'>

	<meta name='keywords' content='Оборудование для баров, кафе, ресторанов, комплексное оснащение баров, ксобровождение баров, техника для баров, кафе ресторанов, техника для общепита, открытие ресторана Россия, техника для точек питания, запчасти для техники, запчасти для барного оборудования, запчасти для холодильного оборудования, запчасти для пекарского оборудования, запчасти для производственного оборудования, запчасти для кафе, холодильное оборудование, барное оборудование, пекарское оборудование, нейтральное оборудование, Санкт-Петербург, Россия'>

	<meta name='description' content='Комплексное оснащение баров, ресторанов,кафе, пищевых производств и магазинов.'>

	<title>Vertex - Комплексное оснащение баров, ресторанов, кафе, пищевых производств и магазинов</title>

	<link rel="shortcut icon" href="{{ asset('icons/favicon.ico') }}">

	{{ HTML::style('css/bootstrap.min.css') }}
	{{ HTML::style('css/font-awesome.min.css') }}
	{{ HTML::style('css/reset.css') }}
	{{ HTML::style('css/style.css') }}
	{{ HTML::script('js/angular.min.js') }}
	{{ HTML::script('packages/ckeditor/ckeditor.js') }}
	{{ HTML::script('packages/ckfinder/ckfinder.js') }}

	@yield('css')

	<!--[if lt IE 10]>

		<!!!!!!!!!!!!!!!script src="{{ asset('js/modernizr_columns.js') }}"></script>

	<![endif]-->

</head>

<body>

	@yield('header')

	@yield('body')



	<div class="footer_absolute">

		@yield('footer')

	</div>



	{{ HTML::script('js/jquery.min.js') }}

	{{ HTML::script('js/jquery.columnizer.js') }}

	{{ HTML::script('js/betterContactForm.js') }}

	{{ HTML::script('js/script.js') }}

	@yield('js')

	<a id="bcf_trigger" href="http://bettercontactform.com" rel="bcf_trigger"></a>

</body>

</html>