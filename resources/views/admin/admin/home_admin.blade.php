@extends('layouts.admin.app')

@section('active-panel')
　システム管理者
@endsection

@section('title')
　システム管理者TOP
@endsection

@section('content')
<div class="container-fluid">

	<div class="row justify-content-center">
		
		<!-- ----------------------------------
			管理者ユーザ 
		----------------------------------- -->
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
			<div class="card">
				<div class="card-header text-success">システム管理者</div>
				
				<div class="card-body">
					{{-- システム管理者　新規登録 --}}
					{{-- 
					<a href="{{ url('admin/admin/create_admin') }}" class="btn btn-primary text-center mb-2">新規登録</a>
					--}}
					
					{{-- システム管理者　一覧表示 
						 登録済みのシステム担当者がいるときのみ表示
					--}}
					<table class="table table-sm">
						@if (session('status'))
						<div class="alert alert-success" role="alert">
							{{ session('status') }}
						</div>
						@endif
						<thead>
							<tr>
								<th scope="col">No</th>
								<th scope="col">名前</th>
								<th scope="col">メールアドレス</th>
								<th scope="col">登録日時</th>
								<th scope="col">更新日時</th>
								<th scope="col" class="">オペレーション</th>
							</tr>
						</thead>
						<tbody>
							<?php $admin_counter = 0 ?>
							@foreach ($admins as $admin)
								<?php $admin_counter = $admin_counter +1?>
							<tr>
								<th scope="row"> <?php echo $admin_counter ?></th>
								<td>{{ $admin->name }}</td>
								<td>{{ $admin->email }}</td>
								<td>{{ $admin->created_at }}</td>
								<td>{{ $admin->updated_at }}</td>
								<td class="">
									<a href="{{ url('admin/admin/edit_admin/'.$admin->id) }}" class="btn btn-primary text-center mr-1">編集する</a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					{{ $admins->links() }}
				</div>
			</div>
		</div>
		
	</div>
</div>
@endsection