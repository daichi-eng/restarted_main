@extends('layouts.user.app')

@section('active-panel')
　一般ユーザー
@endsection

@section('title')
	一括商品CSVダウンロード
@endsection

@section('content')
<div class="container-fluid">

	<div class="row justify-content-center">
		
		<!-- 一般ユーザ -->
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
			<div class="card">
				<div class="card-header">一括商品CSVダウンロード</div>

				<!-- card-body Start -->
				<div class="card-body">
					
					{{-- ファイル作成 --}}
					<form method="POST" action="{{ route('user.aupay.csv_create') }}" class="container">
						@csrf
						<div class="form-group row">
							<div class="col-4 d-flex align-items-center">
								データの種類
							</div>
							
							<div class="col-6">
								<select id="select_1" class="form-control" name="csv_type">
									<option value="item">商品情報</option>
									{{-- <option value="stock">在庫情報</option> --}}
								</select>
							</div>
							
						</div>
						
						<div class="form-group row">
						
							<div class="col-4 d-flex align-items-center">
								取得数（新しい順）
							</div>
							
							<div class="col-6">
								<select id="select_2" class="form-control" name="totalCount">
									<option value="maxCount">全件取得</option>
									<option value="500">500</option>
									<option value="1000">1000</option>
									<option value="1500">1500</option>
									<option value="2000">2000</option>
								</select>
							</div>
						</div>
						
						<div class="form-group row">
							<div class="col-12">
								<button type="submit" class="btn btn-success">
									取得開始
								</button>
								{{-- ファイル作成結果 --}}
								@if(isset($stMsgs) && !empty($stMsg)) 
								<span class="font-weight-bold text-danger d-flex align-items-center p-2">
								@foreach($stMsgs as $stMsg)
									<strong>{{ $stMsg }}</strong>
								@endforeach
								</span>
								@endif {{-- ファイル作成結果 --}}
							</div>
						</div>
					</form><!-- End Form -->
					{{-- ファイル作成 --}}


					{{-- 過去のファイル取得履歴 --}}
					@if(isset($userFiles)	)
					<div class="card">
						
						<div class="card-header">ダウンロード履歴</div>
						
						<table class="table card-body container">
							<thead>
								<tr>
									<th scope="col">No</th>
									<th scope="col">データの種類</th>
									<th scope="col">受付日時</th>
									<th scope="col"></th>
								</tr>
							</thead>
							
							<tbody>
								<?php $cnt = 1; ?>
								@foreach($userFiles as $value)
								<tr>
									<th scope="row">{{ $cnt }}</th>
									<td>{{ $value->filename }}</td>
									<td>{{ $value->created_at }}</td>
									<td>
										<form action="{{ route('user.aupay.csv_download', ['id' => $value->id ]) }}" method="GET" class="container">
											@csrf
											<button type="submit" class="btn btn-success">
												<i class="fas fa-cloud-download-alt"></i>
											</button>
										</form>
									</td>
									<?php $cnt += 1; ?>
								</tr>
								@endforeach
							</tbody>
							
						</table>
					</div>
					{{-- 過去のファイル取得履歴 --}}
					@endif
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