
	<div class="card">
		<div class="card-header">ユーザ情報</div>

		<!-- card-body Start -->
		<div class="card-body container">
			
			<div class="form-group row">
				<label for="name" class="col-md-4 col-form-label text-md-right">名前</label>

				<div class="col-md-6 d-flex align-items-center">
					<div class="mx-2"> {{ $user->name }}</div>
				</div>
			</div>

			<div class="form-group row">
				<label for="email" class="col-md-4 col-form-label text-md-right">メールアドレス</label>

				<div class="col-md-6 d-flex align-items-center">
					<div class="mx-2"> {{ $user->email }}</div>
				</div>
			</div>
		</div><!-- card-body End -->
			
	</div><!-- card End -->
