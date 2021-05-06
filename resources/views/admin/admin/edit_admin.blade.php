@extends('layouts.admin.app')

@section('active-panel')
　システム管理者
@endsection

@section('title')
	システム管理者 詳細
@endsection

@section('content')
<div class="container-fluid">
	<div class="row justify-content-center">
		
		<!-- 一般ユーザ -->
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
			<!-- card Start -->
			<div class="card">
				<div class="card-header">システム管理者 詳細</div>

				<!-- card-body Start -->
				<div class="card-body">
					
					<form method="POST" action="{{ route('admin.admin.update_admin', ['id' => $admin->id ]) }}" class="mb-3">
						@csrf
						
						<div class="form-group row">
							<label for="name" class="col-md-4 col-form-label text-md-right">名前</label>

							<div class="col-md-6">
								<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $admin->name }}" required autocomplete="name" autofocus>

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
								<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$admin->email}}" required autocomplete="email">

								@error('email')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
								
							</div>
						</div>
						
						<div class="form-group row">
							<label for="email" class="col-md-4 col-form-label text-md-right">登録日時</label>

							<div class="col-md-6 d-flex align-items-center">
								<div class="mx-2">{{$admin->created_at}}</div>
							</div>
						</div>
						<div class="form-group row">
							<label for="email" class="col-md-4 col-form-label text-md-right">更新日時</label>

							<div class="col-md-6 d-flex align-items-center">
								<div class="mx-2">{{$admin->updated_at}}</div>
							</div>
						</div>
						
						<div class="form-group row mb-0">
							<div class="col-md-6 offset-md-4 d-flex justify-content-end">
								<button type="submit" class="btn btn-primary">
									更新する
								</button>
							</div>
						</div>
					</form>
					
					{{--
					<form method="POST" action="{{ route('admin.destroy_admin', ['id' => $admin->id ]) }}">
						@csrf
						<div class="form-group row mb-0">
							<div class="col-md-6 offset-md-4 d-flex justify-content-end">
								<a href="#" data-id="$admin->id" class="btn btn-danger" Onclick="deletePost(this);">
									削除する
								</a>
							</div>
						</div>
					</form>
					--}}
				</div><!-- card-body End -->
					
			</div><!-- card End -->
		</div>
		
	</div>
</div>
	<!-- 
	*********************************************
	* ADD 2020-08-08
	* 削除ボタン押下時に確認メッセージを出力する。
	*********************************************
	 -->
	 <script>
	 function deletePost(e){
	 	'use strict';
	 	if(confirm('本当に削除しますか？')){
	 		document.ElementById('delete_' +e.dataset.id).submit();
	 	}
	 }
	 
	 </script>
@endsection