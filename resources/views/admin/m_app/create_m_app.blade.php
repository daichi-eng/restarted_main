@extends('layouts.admin.app')

@section('active-panel')
　システム管理者
@endsection

@section('title')
　アプリ新規登録
@endsection

@section('content')
<div class="container-fluid">
	<div class="row justify-content-center">
		
		<!-- 一般ユーザ -->
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
			<!-- card Start -->
			<div class="card">
				<div class="card-header text-success">アプリ新規登録</div>

				<!-- card-body Start -->
				<div class="card-body">
					
					<form method="POST" action="{{ route('admin.m_app.store_m_app')}}" class="">
						@csrf
						
						<div class="form-group row">
							<label for="app_no" class="col-md-4 col-form-label text-md-right">アプリNo</label>

							<div class="col-md-6">
								<input id="app_no" type="text" class="form-control @error('app_no') is-invalid @enderror" name="app_no" required autocomplete="number" autofocus>
								@error('app_no')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
						</div>
						
						<div class="form-group row">
							<label for="name" class="col-md-4 col-form-label text-md-right">アプリ名称</label>

							<div class="col-md-6">
								<input id="name" type="text" class="form-control @error('app_name') is-invalid @enderror" name="app_name" value="" required >

								@error('app_name')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
						</div>
						
						<div class="form-group row mb-0">
							<div class="col-md-6 offset-md-4 d-flex justify-content-end">
								<button type="submit" class="btn btn-primary">
									新規登録
								</button>
							</div>
						</div>
					</form>
					
					
				</div><!-- card-body End -->
					
			</div><!-- card End -->
		</div>
		
	</div>
</div>
@endsection