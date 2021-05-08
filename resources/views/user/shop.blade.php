@extends('layouts.user.app')

@section('active-panel')
　一般ユーザー
@endsection

@section('title')
au Pay ショップ情報TOP
@endsection

@section('content')
	

	<div class="card mb-3">
		
		@if(!isset($shop))
		<div class="card-header">ショップ情報の登録</div>
		@elseif(isset($shop))
		<div class="card-header">ショップ情報編集</div>
		@endif
		
		<div class="card-body">
			{{-- エラーメッセージ --}}
			@if(($stMsgs['status'] == '0') && (is_array($stMsgs['msg'])))
			<ul>
				@foreach($stMsgs['msg'] as $stMsg)
				<li>{{ $stMsg }}</li>
				@endforeach
			</ul>
			@elseif($stMsgs['status'] == '0')
				<p>{{ $stMsgs['msg'] }}</p>
			@endif
			
			{{-- バリデーションメッセージ --}}
			@if($errors->any())
			<div>
				<ul>
					@foreach($errors->all() as $error)
					<li>{{$error }}</li>
					@endforeach
				</ul>
			</div>
			@endif


			{{-- ================================================
				ショップ情報登録 
				================================================ --}}
			@if(!isset($shop))
			
			<form method="POST" action="{{ route('user.shop.store_shop') }}" class="">
				@csrf
				
				<div class="form-group row">
					<label for="number" class="col-md-4 col-form-label text-md-right">会員番号</label>
	
					<div class="col-md-6">
						<input id="shop_num" type="text" class="form-control @error('shop_num') is-invalid @enderror" name="shop_num" placeholder="8桁の数字" maxlength="8" required autocomplete="number" autofocus>
	
						@error('shop_num')
							<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
						@enderror
					</div>
				</div>
				
				<div class="form-group row">
					<label for="text" class="col-md-4 col-form-label text-md-right">APIキー</label>
	
					<div class="col-md-6">
						<input id="shop_api_key" type="text" class="form-control @error('shop_api_key') is-invalid @enderror" name="shop_api_key" placeholder="半角英数字のみ" required autocomplete="text" style="ime-mode:disabled;">
	
						@error('shop_api_key')
							<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
						@enderror
					</div>
				</div>
				
				<div class="form-group row mb-0">
					<div class="col-md-6 offset-md-4 d-flex justify-content-end">登録する</div>
				</div>
			</form>
			<p>※ショップ情報は1ユーザー1つしか登録できません。</p>


			{{-- ================================================
				ショップ情報編集 
				================================================ --}}
			@elseif(isset($shop))
			<form method="POST" action="{{ route('user.shop.update_shop', ['id' => $shop[0]->id ]) }}" class="">
				@csrf
				
				<div class="form-group row">
					<label for="datetime-local" class="col-md-4 col-form-label text-md-right">会員番号</label>
					
					<div class="col-md-6">
						<input id="shop_num" type="text" class="form-control @error('text') is-invalid @enderror" name="shop_num" value="{{$shop[0]->shop_num}}" maxlength="8" required autocomplete="text" style="ime-mode:disabled;">
	
						@error('text')
							<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
						@enderror
					</div>
				</div>
				
				<div class="form-group row">
					<label for="text" class="col-md-4 col-form-label text-md-right">APIキー</label>
	
					<div class="col-md-6">
						<input id="shop_api_key" type="text" class="form-control @error('text') is-invalid @enderror" name="shop_api_key" value="{{$shop[0]->shop_api_key}}" required autocomplete="text" style="ime-mode:disabled;">
	
						@error('text')
							<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
						@enderror
					</div>
				</div>
				
				<div class="form-group row">
					<label for="datetime-local" class="col-md-4 col-form-label text-md-right">登録日時</label>
	
					<div class="col-md-6 d-flex align-items-center">
						<div class="mx-2">
							@if(isset($shop[0]->created_at))
								{{$shop[0]->created_at}}
							@endif
						</div>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="datetime-local" class="col-md-4 col-form-label text-md-right">更新日時</label>
	
					<div class="col-md-6 d-flex align-items-center">
						<div class="mx-2">
							@if(isset($shop[0]->updated_at))
								{{$shop[0]->updated_at}}
							@endif
						</div>
					</div>
				</div>
				
				<div class="form-group row mb-0">
					<div class="col-md-6 offset-md-4 d-flex justify-content-end">
						<button type="submit" class="btn btn-success">更新する</button>
					</div>
				</div>
			</form>
			@endif

			{{-- テスト通信する 
			<form method="GET" action="{{ route('user.aupay.check_api')}}" class="mt-2">
				@csrf
				<div class="form-group row mb-0">
					<div class="col-md-6 offset-md-4 d-flex justify-content-end">
						<button type="submit" class="btn btn-primary">テスト</button>
					</div>
					@if(!isset($result_status))
					
					@elseif($result_status[0] == '0')
						<span class="text-dark d-flex align-items-center"><strong>{{ $result_status[1] }}</strong></span>
					@elseif($result_status[0] == '1')
						<span class="text-danger d-flex align-items-center"><strong>{{ $result_status[1] }}</strong></span>
					@elseif($result_status[0] == '2')
						<span class="text-danger d-flex align-items-center"><strong>{{ $result_status[1] }}</strong></span>
					@endif
				</div>
			</form>
			--}}
			<p>※ショップ情報は1ユーザー1つしか登録できません。</p>
		</div>
	</div>


@endsection