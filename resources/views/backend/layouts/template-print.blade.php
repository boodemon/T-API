<!DOCTYPE html>
<html lang="en">
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link href="{{ asset('public/css/export.css') }}" rel="stylesheet">
		<link href="{{ asset('public/css/core.css') }}" rel="stylesheet">
		<link href="{{ asset('public/css/style.css') }}" rel="stylesheet">
		<link href="{{ asset('public/css/layouts.css') }}" rel="stylesheet">
			  @yield('stylesheet')
	</head>

	<body>
		@yield('content')
		@yield('javascript')
	</body>
</html>