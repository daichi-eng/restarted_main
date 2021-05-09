@extends('layouts.admin.app')

@section('active-panel')
　システム管理者
@endsection

@section('title')
　ユーザー編集
@endsection

@section('content')
<div class="container-fluid">

	<div class="row justify-content-center">
		
		<!-- 一般ユーザ -->
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
			<div class="card">
				<div class="card-header text-success">一般ユーザ 詳細</div>

				<!-- card-body Start -->
				<div class="card-body">
					
					<form method="POST" action="{{ route('admin.user.update_user', ['id' => $user->id]) }}">
						@csrf

						<div class="form-group row">
							<label for="name" class="col-md-4 col-form-label text-md-right">名前</label>

							<div class="col-md-6 d-flex align-items-center">
								<div class="mx-2">{{$user->name}}</div>
							</div>
						</div>

						<div class="form-group row">
							<label for="email" class="col-md-4 col-form-label text-md-right">メールアドレス</label>

							<div class="col-md-6 d-flex align-items-center">
								<div class="mx-2">{{$user->email}}</div>
							</div>
						</div>

						
						{{-- Appの使用権限の編集 --}}
						@foreach($role_m_apps as $role_m_app)
						<div class="form-group row">
							<label for="email" class="col-md-4 col-form-label text-md-right">{{ $role_m_app->app_name }}</label>

							<div class="col-md-6">
								{{-- APP権限有り--}}
								<ul class="list-group list-group-horizontal border-0">
									<li class="list-group-item border-0">
										<div class="form-check">
											<input class="form-check-input" type="radio" name="{{ $role_m_app->app_no }}" id="{{ $role_m_app->app_no }}_1" value="true" @if(isset($role_m_app->app_role_id)) checked @endif>
											<label class="form-check-label" for="{{ $role_m_app->app_no }}_1">許可</label>
										</div>
									</li>
									
									<li class="list-group-item border-0">
										<div class="form-check">
											<input class="form-check-input" type="radio" name="{{ $role_m_app->app_no }}" id="{{ $role_m_app->app_no }}_2" value="false" @if(!isset($role_m_app->app_role_id)) checked @endif>
											<label class="form-check-label" for="{{ $role_m_app->app_no }}_2">不可</label>
										</div>
									</li>
								</ul>
								
								@error('app_no')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
						</div>
						@endforeach
						
						<div class="form-group row mb-0">
							<div class="col-md-6 offset-md-4 d-flex justify-content-end">
								<button type="submit" class="btn btn-primary">
									更新する
								</button>
							</div>
						</div>
					</form>
					
				</div><!-- card-body End -->
					
			</div>
		</div>
	</div>
</div>
@endsection