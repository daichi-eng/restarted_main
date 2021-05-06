@extends('layouts.admin.app')

@section('title')
	一般ユーザ 詳細
@endsection

@section('content')
<div class="container-fluid">

	<!-- ログインステータスを非表示
    <div class="row justify-content-center mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">ログインステータス</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
	-->

	<div class="row justify-content-center">
		
		<!-- 一般ユーザ -->
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
			<div class="card">
				<div class="card-header">一般ユーザ 詳細</div>

				<!-- card-body Start -->
				<div class="card-body">
					
					<form method="POST" action="{{ route('admin.update_user', ['id' => $user->id ]) }}" class="mb-3">
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

						<div class="form-group row">
							<label for="email" class="col-md-4 col-form-label text-md-right">ユーザ権限</label>

							<div class="col-md-6 d-flex align-items-center mx-2">
								<div class="radio mr-2">
									<label class="radio mb-0">
										<input type="radio" name="role" id="radio1a" value="0" @if ($user->role == 0)checked @endif>
										未課金
									</label>
								</div>
								<div class="radio mx-2">
									<label class="radio mb-0">
										<input type="radio" name="role" id="radio1b" value="1" @if ($user->role == 1)checked @endif>
										課金済
									</label>
								</div>
							</div>
						</div>
						
						<div class="form-group row mb-0">
							<div class="col-md-6 offset-md-4 d-flex justify-content-end">
								<button type="submit" class="btn btn-secondary">
									更新する
								</button>
							</div>
						</div>
					</form>
					{{-- EDIT 2020-08-13
					削除機能の実装を保留「実装機能.xlsx」を参照すること
					<form method="POST" action="{{ route('admin.destroy_user', ['id' => $user->id ]) }}">
						@csrf
						<div class="form-group row mb-0">
							<div class="col-md-6 offset-md-4 d-flex justify-content-end">
								<a href="#" data-id="$user>id" class="btn btn-danger" Onclick="deletePost(this);">
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