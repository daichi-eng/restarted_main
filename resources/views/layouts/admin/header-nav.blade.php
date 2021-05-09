	{{-- Start navigation --}}
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
					<a class="nav-link" href="{{ route('admin.login') }}">ログイン</a>
				</li>
				@if (Route::has('admin.register'))
				<li class="nav-item dropdown">
					<a class="nav-link" href="{{ route('admin.register') }}">システム担当者登録</a>
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
							ログアウト
						</a>
						<form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
							@csrf
						</form>
					</div>
				</li>
			@endunless
			</ul>
		</div>
	</nav><!-- End Navigation-bar -->
		
	
	{{-- Start header-down --}}
	<div class="bg-white header-down ">
				
		<ul class="">
			<li><a href="{{ url('admin/admin/home_admin') }}" class="btn text-success">システム担当者編集</a></li>
			<li><a href="{{ url('admin/user/home_user')}}" class="btn text-success">一般ユーザー管理</a></li>
			<li><a href="{{ url('admin/m_app/home_m_app')}}" class="btn text-success">アプリマスタ管理</a></li>
			@if (Route::has('admin.register'))
			<li><a href="{{ route('admin.register') }}" class="btn text-success">システム担当者登録</a></li>
			@endif
		</ul>
	</div>{{-- End header-down --}}
	