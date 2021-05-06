	{{-- Start navigation --}}
	<nav class="navbar navbar-expand-lg navbar-dark">
	
		<a class="navbar-brand" href="{{ url('user/home')}}">
			<i class="fas fa-shopping-cart mr-2"></i>{{ config('app.name', 'EC') }}
		</a>
		
		<div class="collapse navbar-collapse px-3" id="navbarSupportedContent">
			
			<!-- Right Side Of Navbar -->
			<ul class="navbar-nav ml-auto">
				@unless (Auth::guard('user')->check())
				<li class="nav-item">
					<a class="nav-link" href="{{ route('user.login') }}">ログイン</a>
				</li>
				
    				{{--  管理者でないと登録権限を与えない --}}
    				@if (Route::has('user.register'))
    				<li class="nav-item">
    					<a class="nav-link" href="{{ route('user.register') }}">ユーザー登録</a>
    				</li>
    				@endif
				@else
				<li class="nav-item dropdown">
					<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
						<i class="fas fa-user-circle m-1"></i>{{ Auth::user()->name }} <span class="caret"></span>
					</a>
			
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="{{ route('user.logout') }}"
							onclick="event.preventDefault();
							document.getElementById('logout-form').submit();">
							{{ __('Logout') }}
						</a>
						<form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
							@csrf
						</form>
					</div>
				</li>
				@endunless
			</ul>
		</div>
	</nav>
	{{-- End navigation --}}


	{{-- Start header-down --}}
	<div class="bg-white header-down ">
				
		<ul class="">
			<li class=""><a href="{{ url('user/shop/index') }}" >ショップ情報</a></li>
			<li class=""><a href="{{ url('user/download/index')}}" >CSV一括ダウンロード</a></li>
			<li class=""><a href="{{ url('user/upload/index')}}" >CSV一括アップロード</a></li>
			<li class=""><a href="{{ url('user/home') }}" class="text-danger">マニュアルページ</a></li>
		</ul>
	</div>{{-- End header-down --}}
	
	