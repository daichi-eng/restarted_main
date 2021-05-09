@extends('layouts.admin.app')

@section('active-panel')
　システム管理者
@endsection

@section('title')
　アプリ管理
@endsection

@section('content')
<div class="container-fluid">

	<div class="row justify-content-center">
		<!-- ----------------------------------
			APPマスタ管理画面 
		----------------------------------- -->
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
			<div class="card">
				<div class="card-header text-success">アプリマスタ</div>
			
				<div class="card-body">	
					{{-- アプリ一新規登録 --}}
					<a href="{{ url('admin/m_app/create_m_app') }}" class="btn btn-primary text-center mb-2">新規登録</a>
				
					{{-- アプリ一覧表示 
						 登録済みのアプリがあるときのみ登録
					--}}
					@if (isset($m_apps[0]))
					<table class="table table-sm">
						<thead>
							<tr>
								<th scope="col">No</th>
								<th scope="col">アプリNo</th>
								<th scope="col">アプリ名称</th>
								<th scope="col">登録日時</th>
								<th scope="col">更新日時</th>
								<th scope="col"></th>
							</tr>
						</thead>
						<tbody>
							<?php $m_app_cnt = 0 ?>
							@foreach ($m_apps as $m_app)
								<?php $m_app_cnt = $m_app_cnt +1?>
							<tr>
								<th scope="row"> <?php echo $m_app_cnt ?></th>
								<td>{{ $m_app->app_no }}</td>
								<td>{{ $m_app->app_name }}</td>
								<td>{{ $m_app->created_at }}</td>
								<td>{{ $m_app->updated_at }}</td>
								<td class="">
									<a href="{{ url('admin/m_app/edit_m_app/'.$m_app->id) }}" class="btn btn-primary text-center mr-1">編集</a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					@endif
				</div>
			</div>
		</div>
		
	</div>
</div>
@endsection