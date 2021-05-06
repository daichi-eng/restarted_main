@extends('layouts.user.app')

@section('active-panel')
　一般ユーザー
@endsection

@section('title')
	一括商品CSVアップロード
@endsection

@section('content')
<div class="container-fluid">

	<div class="row justify-content-center">
		
		<!-- 一般ユーザ -->
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
		
			<div class="card mb-3">
				<div class="card-header">CSV アップロード</div>

				
				<!-- card-body Start -->
				<div class="card-body ">
					<p>
					CSVファイルをアップロードして、商品情報を一括登録できます。
					</p>
					
					{{-- =================================
						 CSVアップロード用のフォーム
						 ================================= --}}
					<form method="POST" action="{{ route('user.upload.csv_upload') }}" class="" enctype="multipart/form-data">
						@csrf
						
						<div class="border rounded mb-2">
							<table class="table table-borderless">
								<thead>
									<tr class="bg-light rounded">
										<th colspan="3">
											ファイル選択
										</th>
									</tr>
								</thead>
								
								<tbody>
									<tr>
										<td scope="row">item.csv</td>
										<td>
											<input type="file" id="validatedCustomFile" name="itemCsv">
										</td>
									</tr>
									<tr>
										<td scope="row">stock.csv</td>
										<td>
											<input type="file" id="validatedCustomFile" name="stockCsv">
										</td>
									</tr>
								</tbody>
							</table>
						</div>
							
						<div class="d-flex justify-content-end">
							<button type="submit" class="btn btn-success mt-2">
								アップロード
							</button>
						</div>
						
					</form>
					
					
					{{-- =================================
						テストアップロード用のフォーム
						================================= --}}
					{{--
					<form method="GET" action="{{ route('user.upload.upload_test') }}" class="container m-2" enctype="multipart/form-data">
					
						<div class="col-5 d-flex justify-content-end">
							<button type="submit" class="btn btn-success">
								test
							</button>
						</div>
					</form>
					--}}
				</div><!-- card-body End -->
					
			</div><!-- card End -->
			
			
			{{-- ====================================
				 アップロード結果
				 ==================================== --}}
			@if($stMsgs['status'] != '99')
			<div class="card mb-3">
				{{-- アップロード失敗 --}}
				@if($stMsgs['status'] == '0')
				<div class="card-header">アップロードエラーが発生しました。</div>
				
				<div class="card-body">
					<ul>
						@foreach ($stMsgs['msg'] as $stMsg)
						<li>{{ $stMsg }}</li>
						@endforeach
					</ul>
				</div>
				
				{{-- アップロード成功 --}}
				@elseif($stMsgs['status'] == '1')
				<div class="card-header ">アップロードに完了しました。</div>
				
				<div class="card-body">
					<p>アップロードが完了しました。</p>
					<p>【アップロード詳細】をダウンロードして確認してください。</p>
				</div>
				@endif
				
			</div><!-- card End -->
			@endif
				
			
			{{-- 過去のファイルアップロード結果 --}}
			@if(isset($userFiles)	)
			<div class="card mb-3">
				
				<div class="card-header">処理結果詳細</div>
				
				<div class="card-body container">
				
					<p>直近5件の処理状況の詳細ファイルをダウンロードできます。詳細ファイルは一週間経過すると削除されます。<p>
					
					
					<div class="border rounded mb-2">
						<table class="table">
							<thead>
								<tr class="table-light">
									<th scope="col">No</th>
									<th scope="col">ファイル名</th>
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
										<form action="{{ route('user.upload.result_download', ['id' => $value->id ]) }}" method="GET" class="container">
											@csrf
											<button type="submit" class="btn btn-success">
												<i class="fas fa-cloud-download-alt p-1"></i>
											</button>
										</form>
									</td>
									<?php $cnt += 1; ?>
								</tr>
								@endforeach
							</tbody>
							
						</table>
					</div>
				</div>
			</div>
			@endif
			{{-- 過去のファイル取得履歴 --}}

			
		</div>
		{{-- 一般ユーザ --}}
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