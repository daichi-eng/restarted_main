@extends('layouts.admin.app')

@section('active-panel')
　システム管理者
@endsection

@section('title')
　アプリ編集
@endsection

@section('content')
<div class="container-fluid">


	<div class="row justify-content-center">
		
		<!-- 一般ユーザ -->
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
			<div class="card">
				<div class="card-header text-success">アプリ 編集</div>

				<!-- card-body Start -->
				<div class="card-body">
					
					<form method="POST" action="{{route('admin.m_app.update_m_app', ['id' => $m_app->id] )}}" class="mb-2">
						@csrf
						
						<div class="form-group row">
							<label for="name" class="col-md-4 col-form-label text-md-right">アプリNo</label>

							<div class="col-md-6 d-flex align-items-center">
								
								<input id="name" type="text" class="form-control @error('app_no') is-invalid @enderror" name="app_no" value="{{$m_app->app_no}}" required autofocus>

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
								<input id="name" type="text" class="form-control @error('app_name') is-invalid @enderror" name="app_name" value="{{$m_app->app_name}}" required autofocus>

								@error('app_name')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
						</div>
						
						<div class="form-group row">
							<label for="name" class="col-md-4 col-form-label text-md-right">登録日時</label>

							<div class="col-md-6 d-flex align-items-center">
								{{$m_app->created_at}}
							</div>
						</div>
						
						<div class="form-group row">
							<label for="name" class="col-md-4 col-form-label text-md-right">更新日時</label>

							<div class="col-md-6 d-flex align-items-center">
								{{$m_app->updated_at}}
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
					
					{{-- 削除 --}}
					<form method="POST" action="{{route('admin.m_app.destroy_m_app', ['id' => $m_app->id] )}}" id="delete_{{$m_app->id}}" class="form-group row mb-0" >
						@csrf
						<div class="col-md-6 offset-md-4 d-flex justify-content-end">
							<a href="#" class="btn btn-danger" data-id="{{$m_app->id}}" onclick="deletePost(this);">
								削除する
							</a>
						</div>
					</form>
				</div><!-- card-body End -->
					
			</div>
		</div>
	</div>
</div>

	<!-- 
	*********************************************
	* ADD 2020-08-16
	* 削除ボタン押下時に確認メッセージを出力する。
	*********************************************
	 -->
	 <script>
	 function deletePost(e){
	 	'use strict';
	 	if(confirm('\n物理削除のため完全に削除されます。\n\n本当に削除しますか？\n')){
	 		document.getElementById('delete_' + e.dataset.id).submit();
	 	}
	 }
	 </script>


@endsection