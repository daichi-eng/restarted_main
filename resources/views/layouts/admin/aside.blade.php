
	<div class="card mb-3">
		<div class="card-header text-success">ユーザ情報</div>

		<!-- card-body Start -->
		<div class="card-body container">
			
			<div class="form-group row">
				<label for="name" class="col-md-4 col-form-label text-md-right">名前</label>

				<div class="col-md-6 d-flex align-items-center">
					<div class="mx-2"> {{-- $admin->name --}}{{ Auth::id() }}</div>
				</div>
			</div>

			<div class="form-group row">
				<label for="email" class="col-md-4 col-form-label text-md-right">メール</label>

				<div class="col-md-6 d-flex align-items-center">
					<div class="mx-2"> {{-- $admin->email --}}</div>
				</div>
			</div>
		</div><!-- card-body End -->
			
	</div><!-- card End -->


	<div class="card mb-3">
		<svg class="bd-placeholder-img card-img-top" width="100%" height="180" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Image cap"><title>Placeholder</title><rect fill="#868e96" width="100%" height="100%"/><text fill="#dee2e6" dy=".3em" x="50%" y="50%">Developer Image</text></svg>
		
		<div class="card-header text-success">開発者の自己紹介</div>

		<div class="card-body">

			<p class="card-text">
				はじめまして！エンジニアのだいちです。
			</p>
			<p class="card-text">
				趣味と勉強を兼ねてツールを開発しています。
				ソースコードはGithubに公開しているので批評やアドバイスいただけると嬉しいです(^^)/
			</p>
			<p class="card-text">
				<strong>ツールは無料でご利用いただけます。</strong>
			</p>

			<a class="btn btn-success m-2" href="https://twitter.com/Daichi_Started"><i class="fab fa-twitter mr-1"></i>Twitter</a>
			
			<a class="btn btn-success m-2" href="https://github.com/daichi-eng"><i class="fab fa-github mr-1"></i>Github</a>

			<a class="btn btn-success m-2" href="https://restarted.site/"><i class="fas fa-blog mr-1"></i>ブログ</a>

		</div>
	</div>

	<div class="card mb-3">
		<div class="card-header">お問い合わせはこちら</div>

		<!-- card-body Start -->
		<div class="card-body container">
			
			<p class="card-text">
				エラーを見つけたときは、<a href="https://restarted.site/contact_200906/">お問い合わせページ</a>からご連絡いただけるととても喜びます。
			</p>
			
			<a class="btn btn-success m-2 " href="https://restarted.site/"></i>お問い合わせ</a>

		</div><!-- card-body End -->
			
	</div><!-- card End -->
	
</div>