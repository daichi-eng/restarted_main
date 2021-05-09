<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	@include('layouts.admin.head')
</head>

<body>
	<div id="app" class="body-wrapper">
		
		{{-- ====== Start Header-navigation ================ --}}
		@include('layouts.admin.header-nav')
		{{-- ====== End Header-navigation ================ --}}

		<main class="py-4 container">
			@yield('content')
		</main>
	</div>

	@include('layouts.admin.footer')

</body>
</html>