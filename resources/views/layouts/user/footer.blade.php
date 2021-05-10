
{{-- Start footer --}}
<div class="footer bg-info py-3">
	<div class="container">
		
		<div class="row mb-2">
			<div class="col-md-6 col-sm-12 mb-2 text-center">
				
				<a class="btn text-light" href="https://twitter.com/Daichi_Started"><i class="mr-1 fab fa-twitter"></i>Twitter</a>
				
				<a class="btn text-light" href="https://github.com/daichi-eng"><i class="mr-1 fab fa-github"></i>Github</a>
			
				<a class="btn text-light" href="https://restarted.site/"><i class="mr-1 fas fa-blog"></i>ブログ</a>
				
			</div>
			
			<div class="col-md-6 col-sm-12 mb-2 text-center">
				<a class="btn text-light" href="{{ route('admin.home') }}">
					システム管理者ページ
				</a>

				<a class="btn text-light" href="{{ route('user.home') }}">
					一般ユーザーページ
				</a>
			</div>
		</div>
		
	</div>
</div>

{{-- End footer --}}