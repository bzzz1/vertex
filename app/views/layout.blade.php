<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Vertex - Комплексное оснащение баров, ресторанов, кафе, пищевых производств и магазинов</title>
	<link rel="shortcut icon" href="{{ asset('icons/favicon.ico') }}">
	{{ HTML::style('css/bootstrap.css') }}
	{{ HTML::style('css/reset.css') }}
	{{ HTML::style('css/text.css') }}
	{{ HTML::style('css/960_24_col.css') }}
	{{ HTML::style('css/login.css') }}
	{{ HTML::style('css/style.css') }}
	@yield('css')
	<!--[if lt IE 10]>
		<!!!!!!!!!!!!!!!script src="{{ asset('js/modernizr_columns.js') }}"></script>
	<![endif]-->
</head>
<body>

	@yield('header')
	@yield('body')
	@yield('footer')
	
	{{ HTML::script('js/jquery.js') }}
	{{ HTML::script('js/angular.min.js') }}
	{{ HTML::script('js/script.js') }}
	@yield('js')
</body>
</html>