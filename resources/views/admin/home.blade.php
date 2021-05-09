@extends('layouts.admin.app')

@section('title')
システム担当者TOP
@endsection

@section('title')
システム管理者TOP
@endsection

@section('content')
<div class="container-fluid">


	<div class="row justify-content-center">

		<!-- ----------------------------------
			管理者ユーザ 
		----------------------------------- -->
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
			<div class="card">
			
				<button type="button" class="card-header btn text-success text-left border-0" data-toggle="collapse" data-target="#sysadmin_control" aria-expanded="true" aria-controls="sysadmin_control">システム担当者 管理</button>
				
				<div class="card-body collapse" id="sysadmin_control">
				
					{{-- システム担当者 管理画面へ --}}
					<a href="{{ url('admin/admin/home_admin') }}" class="btn btn-primary text-center mb-2">
						<i class="fas fa-arrow-circle-right mr-1"></i>
						管理画面TOP
					</a>
				
					<table class="table table-sm">
						@if (session('status'))
						<div class="alert alert-success" role="alert">
							{{ session('status') }}
						</div>
						@endif
						<thead>
							<tr>
								<th scope="col">No</th>
								<th scope="col">名前</th>
								<th scope="col">メールアドレス</th>
								<th scope="col">登録日時</th>
								<th scope="col">更新日時</th>
							</tr>
						</thead>
						<tbody>
							<?php $admin_counter = 0 ?>
							@foreach ($admins as $admin)
								<?php $admin_counter = $admin_counter +1?>
							<tr>
								<th scope="row"> <?php echo $admin_counter ?></th>
								<td>{{ $admin->name }}</td>
								<td>{{ $admin->email }}</td>
								<td>{{ $admin->created_at }}</td>
								<td>{{ $admin->updated_at }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<!-- --------------------------------------
			一般ユーザ
			-------------------------------------- -->
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
			<div class="card">
				<button type="button" class="card-header btn text-success text-left border-0" data-toggle="collapse" data-target="#generaluser_control" aria-expanded="true" aria-controls="sysadmin_control">一般ユーザ 管理</button>

				<div class="card-body collapse" id="generaluser_control">
					
					{{-- 一般ユーザ管理画面へ --}}
					<a href="{{ url('admin/user/home_user') }}" class="btn btn-primary text-center mb-2">
						<i class="fas fa-arrow-circle-right mr-1"></i>
						管理画面TOP
					</a>
					
					@if (isset($users[0]))
					<table class="table table-sm">
						@if (session('status'))
						<div class="alert alert-success" role="alert">
							{{ session('status') }}
						</div>
						@endif
						<thead>
							<tr>
								<th scope="col">No</th>
								<th scope="col">名前</th>
								<th scope="col">メールアドレス</th>
								<th scope="col">登録日時</th>
								<th scope="col">更新日時</th>
							</tr>
						</thead>
						<tbody>
							<?php $user_counter = 0 ?>
							@foreach ($users as $user)
								<?php $user_counter = $user_counter +1?>
							<tr>
								
								<th scope="row"><?php echo $user_counter ?></th>
								<td>{{ $user->name }}</td>
								<td>{{ $user->email }}</td>
								<td>{{ $user->created_at }}</td>
								<td>{{ $user->updated_at }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					@endif
					
				</div>
			</div>
		</div>
		
		
		<!-- ----------------------------------
			APPマスタ管理画面 
		----------------------------------- -->
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
			<div class="card">
				<button type="button" class="card-header btn text-success text-left border-0" data-toggle="collapse" data-target="#app_control" aria-expanded="true" aria-controls="app_control">アプリマスタ 管理</button>
			
				<div class="card-body collapse" id="app_control">	
					{{-- アプリ管理画面へ --}}
					<a href="{{ url('admin/m_app/home_m_app') }}" class="btn btn-primary text-center mb-2">
						<i class="fas fa-arrow-circle-right mr-1"></i>
						管理画面TOP
					</a>
					
					{{-- アプリ一覧表示 
						 登録済みのアプリがあるときのみ登録
					--}}
					@if (isset($m_apps[0]))
					<table class="table table-sm">
						<thead>
							<tr>
								<th scope="col">No</th>
								<th scope="col">アプリNo</th>
								<th scope="col">アプリ名称</th>
								<th scope="col">登録日時</th>
								<th scope="col">更新日時</th>
							</tr>
						</thead>
						<tbody>
							<?php $m_app_cnt = 0 ?>
							@foreach ($m_apps as $m_app)
								<?php $m_app_cnt = $m_app_cnt +1?>
							<tr>
								<th scope="row"> <?php echo $m_app_cnt ?></th>
								<td>{{ $m_app->app_no }}</td>
								<td>{{ $m_app->app_name }}</td>
								<td>{{ $m_app->created_at }}</td>
								<td>{{ $m_app->updated_at }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					@endif
								
				</div>
			</div>
		</div>
		
	</div>
</div>
@endsection