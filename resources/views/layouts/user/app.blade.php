<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	@include('layouts.user.head')
</head>

<body>
	<div id="app" class="body-wrapper">
		{{-- ====== Start Header-navigation ================ --}}
		@include('layouts.user.header-nav')
		{{-- ====== End Header-navigation ================ --}}
		
		
		{{-- Start container-fluid --}}
		<div class="container-fluid py-4">
			<div class="row justify-content-center">
				
				{{-- Start main --}}
				<main class="col-lg-8 col-md-8 col-sm-12 col-xs-12 mb-3">
					@yield('content')
				</main>
				{{-- End main --}}
				
				
				{{-- == Start aside ============== --}}
				@if (Auth::guard('user')->check())
				<aside class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mb-3">
					@include('layouts.user.aside')
				</aside>
				@endif
				{{-- == End aside ============== --}}
				
			</div>{{-- End row --}}
		</div>
		{{-- End container-fluid --}}
		
		@include('layouts.user.footer')
	</div>
	
	
</body>
</html>