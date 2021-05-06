@extends('layouts.admin.app')

@section('active-panel')
　システム管理者
@endsection

@section('title')
　システム管理者 新規登録
@endsection

@section('content')
<div class="container-fluid">
	<div class="row justify-content-center">
		
		<!-- 一般ユーザ -->
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
			<!-- card Start -->
			<div class="card">
				<div class="card-header">システム管理者　新規登録</div>

				<!-- card-body Start -->
				<div class="card-body">
					
					<form method="POST" action="{{ route('admin.m_app.store_m_app')}}" class="">
						@csrf
						
						<div class="form-group row">
							<label for="name" class="col-md-4 col-form-label text-md-right">名前</label>

							<div class="col-md-6">
								<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" required autocomplete="name" autofocus>

								@error('name')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
						</div>
						
						<div class="form-group row">
							<label for="email" class="col-md-4 col-form-label text-md-right">メールアドレス</label>

							<div class="col-md-6">
								<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" required autocomplete="email">

								@error('email')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
								
							</div>
						</div>
						
						<div class="form-group row mb-0">
							<div class="col-md-6 offset-md-6 d-flex justify-content-end">
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