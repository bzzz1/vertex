<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Vertex - Комплексное оснащение баров, ресторанов, кафе, пищевых производств и магазинов</title>
	<link href="icons/favicon.ico" rel="shortcut icon" type="image/x-icon" />
	{{ HTML::style('css/bootstrap.css') }}
	{{ HTML::style('css/reset.css') }}
	{{ HTML::style('css/text.css') }}
	{{ HTML::style('css/960_24_col.css') }}
	@yield('css')
</head>
<body>

	@yield('header')
	@yield('body')
	@yield('footer')
	
	{{ HTML::script('js/jquery.js') }}
	{{ HTML::script('js/jquery.cookie.js') }}
	{{ HTML::script('js/underscore.js') }}
	{{ HTML::script('js/jquery-ui.js') }}
	{{ HTML::script('js/jquery.transform.js') }}
	{{ HTML::script('js/bootstrap.js') }}
	{{ HTML::script('js/globals.js') }}
	{{ HTML::script('js/slider.js') }}
	{{ HTML::script('js/cart.js') }}
	{{ HTML::script('js/item.js') }}
	{{ HTML::script('js/admin.js') }}
	@yield('js')
</body>
</html>