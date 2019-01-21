<div class="sidebar" >
	<div class="sidebar-inner">
		<!-- ### $Sidebar Header ### -->
		<div class="sidebar-logo "style="padding: 0 0px">
			<div class="peers ai-c fxw-nw">
				<div class="peer peer-greed">
					<a class='sidebar-link td-n' href="/">
						<div class="peers ai-c fxw-nw">
							<div class="peer">
								<div class="logo">
									<img src="{{ asset('/images/assets/logo.png') }}" alt="">
								</div>
							</div>
							<div class="peer peer-greed">
								<h5 class="lh-1 mB-0 logo-text"> {{ env('APP_NAME') }}</h5>
							</div>
						</div>
					</a>
				</div>
			
				<div class="peer">
					<div class="mobile-toggle sidebar-toggle">
						<a href="" class="td-n">
							<i class="ti-arrow-circle-left"></i>
						</a>
					</div>
				</div>
			</div>
		</div>

		<!-- ### $Sidebar Menu ### -->
		<ul class="sidebar-menu scrollable pos-r" >
			@include('partials.menu')
		</ul>
	</div>
</div>
