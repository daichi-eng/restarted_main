
{{-- Start footer --}}
<footer class="footer bg-info py-3">
	<div class="container">
		
		<div class="row mb-2">
			<div class="col-md-6 col-sm-12 mb-2">
				
				<div>開発者のアカウント</div>
				
				Twitter<a class="text-light m-2" href="https://twitter.com/Daichi_Started"><i class="ml-1 fab fa-twitter"></i></a>
				
				Github<a class="text-light m-2" href="https://github.com/daichi-eng"><i class="fab fa-github"></i></a>
			</div>
			
			<div class="col-md-4 col-sm-12 mb-2">
				<a class="btn text-light" href="{{ route('admin.home') }}">
					システム管理者ページ
				</a>

				<a class="btn text-light" href="{{ route('user.home') }}">
					一般ユーザーページ
				</a>
			</div>
		</div>
		
	</div>
</footer>

{{-- End footer --}}