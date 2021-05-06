@extends('layouts.user.app')

@section('active-panel')
　一般ユーザー
@endsection

@section('title')
	au PAYマーケット（旧wowma!）
@endsection

@section('content')	
	
	@if(isset($shop[0]->id))
	<!-- =============================================
		 		Start Shop Data
		 ============================================= -->
	<div class="card mb-3">
		
		<div class="card-header bg-info text-white">店舗情報</div>
		
		<!-- card-body Start -->
		<div class="card-body container">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					
					<table class="table">
						<thead>
							<tr class="table-light">
								<th scope="col">会員番号</th>
								<th scope="col">APIキー</th>
								<th scope="col">更新日時</th>
								<th scope="col"></th>
							</tr>
						</thead>
						
						<tbody>
							<tr>
								<td>{{ $shop[0]->shop_num}}</td>
								<td>{{ $shop[0]->shop_api_key }}</td>
								<td>{{ $shop[0]->updated_at }}</td>
								<td>
									{{--
									<a href="{{ url('user/aupay/edit_shop/'.$shop[0]->id) }}" class="btn btn-success">
										編集
									</a>
									--}}
									<a href="{{ url('user/shop/shop_index/'.$shop[0]->id) }}" class="btn btn-success">
										編集
									</a>
									<a href="{{ url('user/shop/shop_index/') }}" class="btn btn-success text-center">
										<i class="fas fa-arrow-circle-right mr-2"></i>ショップ情報
									</a>
								</td>
							</tr>
						</tbody>
					</table>
					
					
					{{--
					<div class="row">
						<label for="name" class="col-md-4">会員番号</label>
		
						<div class="col-md-8">
							<p class="word-wrap">{{ $shop[0]->shop_num}}</p>
						</div>
					</div>
		
		
					<div class="row">
						<label for="email" class="col-md-4">APIキー</label>
		
						<div class="col-md-8">
							<p class="text-break">{{ $shop[0]->shop_api_key }}</p>
						</div>
					</div>
		
					<div class="row">
						<label for="email" class="col-md-4">更新日時</label>
		
						<div class="col-md-8">
							<p class="text-break">{{ $shop[0]->updated_at }}</p>
						</div>
					</div>
		
					<div class="row">
						<label for="email" class="col-md-4">更新日時</label>
		
						<div class="col-md-8">
							<a href="{{ url('user/aupay/edit_shop/'.$shop[0]->id) }}" class="btn btn-success py-2 px-3">
								<i class="fas fa-arrow-circle-right mr-2"></i>編集する
							</a>
						</div>
					</div>
					--}}
				</div>
				
			</div>
			
		</div>	<!-- End Card-Body-->
		
	</div>
	<!-- =============================================
		 		End Shop Data
		 ============================================= -->
	@else
	<!-- =============================================
		 		Start Shop Register
		 ============================================= -->
	<div class="card mb-3">
		
		<div class="card-header bg-info text-white">店舗登録</div>
		
		<!-- card-body Start -->
		<div class="card-body container">
			<div class="row">
				<div class="col-md-6 offset-md-6 d-flex justify-content-end">
					<a href="{{ url('user/aupay/create_shop') }}" class="btn btn-success text-center">
						<i class="fas fa-arrow-circle-right mr-2"></i>au Pay 店舗登録
					</a>
				</div>	
			</div>			
		</div>
		
	</div>
	<!-- =============================================
		 		End Shop Register
		 ============================================= -->
		 
	@endif


	<!-- =============================================
		 		Start CSV uploder
		 ============================================= -->
	<div class="card mb-3">
		
		<div class="card-header bg-info text-white">CSVオプション</div>
		
		<!-- card-body Start -->
		{{-- 店舗登録されているとき --}}
		@if(isset($shop))
		<div class="card-body container">
			
			<div class="row mb-2">
				<div class="col-sm-12 col-md-6">
					<div class="col-md-12 p-2">
						一括商品CSVアップロードは、CSVデータファイルを利用して、多数の商品を一括で出品、または商品情報を一括で変更できるサービスです。
					</div>
					
					<div class="col-md-12 d-flex justify-content-end">
						<a href="{{ url('user/upload/show_upload/')}}" class="btn btn-success py-2 px-3">
							<i class="fas fa-arrow-circle-right mr-2"></i>一括商品CSVアップロード
						</a>
					</div>
				</div>
				
				<div class="col-sm-12 col-md-6">
					<div class="col-md-12 p-2">
						削除予定です。
					</div>
					
					<div class="col-md-12 d-flex justify-content-end">
						<a href="{{ url('user/aupay/show_csv_download/')}}" class="btn btn-success py-2 px-3">
							<i class="fas fa-arrow-circle-right mr-2"></i>一括商品CSVダウンロード
						</a>
					</div>
				</div>
			</div>
		</div><!-- End Card-Body-->
		@else
		<div class="card-body container">
			<div class="row">
				<div class="col-md-6 offset-md-6 d-flex justify-content-end">
					店舗情報を登録してください。
					登録後に使用できます。
				</div>
			</div>
		</div><!-- End Card-Body-->
		@endif
		
	</div>
	<!-- =============================================
		 		End CSV uploder
		 ============================================= -->

@endsection
