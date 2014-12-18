<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name='viewport' content='width=960'>
	<title>Vertex - Комплексное оснащение баров, ресторанов, кафе, пищевых производств и магазинов</title>
	<link rel="shortcut icon" href="{{ asset('icons/favicon.ico') }}">
	{{ HTML::style('css/bootstrap.min.css') }}
	{{ HTML::style('css/reset.css') }}
	{{ HTML::style('css/style.css') }}
	{{ HTML::script('js/angular.min.js') }}
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
</body>
</html>