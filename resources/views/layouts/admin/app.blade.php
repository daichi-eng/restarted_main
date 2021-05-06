<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	
	<title>{{ config('app.name', 'Laravel') }}</title>
	
	<!-- Scripts -->
	<script src="{{ asset('js/app.js') }}" defer></script>
	
	<!-- Fonts -->
	<link rel="dns-prefetch" href="//fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
	
	<!-- Icon -->
	<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
	
	<!-- Styles -->
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
	<div id="app" class="body-wrapper">
		<!-- navigation-bar -->
		<nav class="navbar navbar-expand-lg navbar-dark bg-success">
		
			<a class="navbar-brand" href="{{ route('admin.home')}}">
				<i class="fas fa-shopping-cart mr-2"></i>{{ config('app.name', 'EC') }}
			</a>
			
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			
			<div class="collapse navbar-collapse px-3"  id="navbarSupportedContent">
			
				<!-- Right Side Of Navbar -->
				<ul class="navbar-nav ml-auto">
					<!-- Authentication Links -->
				@unless (Auth::guard('admin')->check())
					<li class="nav-item">
						<a class="nav-link" href="{{ route('admin.login') }}">{{ __('Login') }}</a>
					</li>
					@if (Route::has('admin.register'))
					<li class="nav-item dropdown">
						<a class="nav-link" href="{{ route('admin.register') }}">システム管理者登録</a>
					</li>
					@endif
				@else
					<li class="nav-item dropdown">
						<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
							<i class="fas fa-user-cog m-1"></i>{{ Auth::user()->name }} <span class="caret"></span>
						</a>
				
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
							<a class="dropdown-item" href="{{ route('admin.logout') }}"
								onclick="event.preventDefault();
								document.getElementById('logout-form').submit();">
								{{ __('logout') }}
							</a>
							<form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
								@csrf
							</form>
						</div>
					</li>
					@if (Route::has('admin.register'))
					<li class="nav-item dropdown">
						<a class="nav-link" href="{{ route('admin.register') }}">システム管理者登録</a>
					</li>
					@endif
				@endunless
				</ul>
			</div>
		</nav><!-- End Navigation-bar -->
		
		<!-- Start Header-down -->
		<div class="bg-white">
			<div class="container px-3">
				<div class="row">
					<div class="col-6 " >
						<span class="btn text-success font-weight-bold" style="cursor:default;" >@yield('title')</span>
					</div>
					
					<div class="col-6 text-right">
						<a class="btn text-success" href="{{ route('user.home') }}">
							<i class="fas fa-arrow-circle-right"></i>
							ユーザページ
						</a>
					</div>
				</div>
			</div>
		</div><!-- End Header-down -->
		
		<main class="py-4 container">
			@yield('content')
		</main>
	</div>
</body>
</html>