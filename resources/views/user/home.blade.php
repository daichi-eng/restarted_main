@extends('layouts.user.app')

@section('active-panel')
　一般ユーザー
@endsection

@section('title')
	au PAYマーケット（旧wowma!）
@endsection


@section('content')	
	
	{{-- =============================================
		 		Start Shop
		 ============================================= --}}
	<div class="card mb-3">
		
		<div class="card-header">au Pay ショップ情報</div>
		
		<!-- card-body Start -->
		<div class="card-body container">
		
			<div class="row">
				<div class="col-md-12 mb-2">Shop情報を登録・編集できます。</div>
			</div>
			
			<div class="row">
				<div class="col-md-12 d-flex justify-content-end">
        			<a href="{{ url('user/shop/index') }}" class="btn btn-success py-2 px-3">
        				<i class="fas fa-arrow-circle-right mr-2"></i>MENU
        			</a>
    			</div>
			</div>
			
		</div>
		
	</div>


	@if(isset($shop))
	{{-- ================================
			csvアップロード 
		================================= --}}
	<div class="card mb-3">
		
		<div class="card-header">一括商品CSVアップロード</div>
		
		<div class="card-body container">
		
			<div class="row">
				<div class="col-md-12 p-2">
					CSVデータファイルを利用して、
					多数の商品を一括で出品、または商品情報を一括で変更できるサービスです。
				</div>
			</div>
				
			<div class="row">
				<div class="col-md-12 d-flex justify-content-end">
					<a href="{{ url('user/upload/index')}}" class="btn btn-success py-2 px-3">
						<i class="fas fa-arrow-circle-right mr-2"></i>MENU
					</a>
				</div>
			</div>
			
		</div><!-- End Card-Body-->
		
	</div>


	{{-- ================================
			csvダウンロード 
		================================= --}}
	<div class="card mb-3">
		
		<div class="card-header ">一括商品CSVダウンロード</div>
		
		<div class="card-body container">
		
			<div class="row mb-2 p-2">削除予定です。</div>
				
			<div class="row mb-2">
				<div class="col-md-12 d-flex justify-content-end">
					<a href="{{ url('user/download/index')}}" class="btn btn-success py-2 px-3">
						<i class="fas fa-arrow-circle-right mr-2"></i>MENU
					</a>
				</div>
			</div>
			
		</div><!-- End Card-Body-->
		
	</div>
		
	@else
	
	<div class="card mb-3">
		
		<div class="card-header">CSVオプションの利用について</div>
		
		<div class="card-body container">
			<div class="row">
					店舗情報を登録してください。登録後に使用できます。
			</div>
		</div><!-- End Card-Body-->
	</div>
	@endif
	
        	
@endsection
