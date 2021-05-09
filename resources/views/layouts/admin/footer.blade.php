
{{-- Start footer --}}
<footer class="footer bg-success p-1">
	<div class="container">
		
		<div class="row mb-2">
			<div class="col-md-6 col-sm-12 p-2">
				
				<div class="p-1">開発者のアカウント</div>
				
				<span class="m-1">
					<a class="btn text-light" href="https://twitter.com/Daichi_Started">Twitter<i class="ml-1 fab fa-twitter"></i></a>
				</span>

				<span class="m-1">
					<a class="btn text-light" href="https://github.com/daichi-eng">Github<i class="ml-1 fab fa-github"></i></a>
				</span>
			</div>
			
			<div class="col-md-6 col-sm-12 mb-2 d-flex align-items-center">
				<a class="btn text-light mx-auto" href="{{ route('admin.home') }}">
					システム管理者ページ
				</a>

				<a class="btn text-light mx-auto" href="{{ route('user.home') }}">
					一般ユーザーページ
				</a>
			</div>
		</div>
		
	</div>
</footer>

{{-- End footer --}}