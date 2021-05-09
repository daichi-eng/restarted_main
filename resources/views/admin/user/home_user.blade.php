@extends('layouts.admin.app')

@section('active-panel')
　システム管理者
@endsection

@section('title')
　ユーザー管理TOP
@endsection


@section('content')
<div class="container-fluid">


	<div class="row justify-content-center">

		<!-- --------------------------------------
			一般ユーザ
			-------------------------------------- -->
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
			<div class="card">
				<div class="card-header text-success">一般ユーザー</div>

				<div class="card-body">
					
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
								<th scope="col">権限</th>
								<th scope="col" class="">オペレーション</th>
							</tr>
						</thead>
						
						<tbody>
							<?php $user_counter = 0 ?>
							@foreach ($users as $user)
								<?php $user_counter = $user_counter +1?>
							<tr>
								
								<th scope="row"><?php echo $user_counter ?></th>
								<td>{{ $user->name }}</td>
								<td>{{ $user->email }}</td>
								<td>
								@foreach($user_role_array[$user->id] as $key => $value)
								{{$value->app_name}}
								@endforeach
								</td>
								
								<td>
									<a href="{{ url('admin/user/edit_user/'.$user->id) }}" class="btn btn-primary text-center mr-1">編集する</a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>



					
					<!-- Start ページネーション -->
					<div class="d-flex justify-content-center">
						{{ $users->links() }}
					</div><!-- End ページネーション -->
				</div>
			</div>
		</div>
	</div>
</div>
@endsection