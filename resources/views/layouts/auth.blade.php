<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<title>@yield('title') | {{ config('app.name') }}</title>
	@include('auth.includes.css')
    @yield('css')
</head>

<body class="navbar-fixed sidebar-fixed" id="body">
	<script>
	// Show the progress bar
	NProgress.start();
	// Increase randomly
	var interval = setInterval(function() {
		NProgress.inc();
	}, 1000);
	// Trigger finish when page fully loaded
	$(window).load(function() {
		clearInterval(interval);
		NProgress.done();
	});
	// Trigger bar when exiting the page
	$(window).unload(function() {
		NProgress.start();
	});
	</script>
	<div class="wrapper">
		<!-- ====================================
          ——— LEFT SIDEBAR WITH OUT FOOTER
        ===================================== -->
		<aside class="left-sidebar sidebar-dark" id="left-sidebar">
			<div id="sidebar" class="sidebar sidebar-with-footer">
				<!-- Aplication Brand -->
				<div class="app-brand">
					<a href="{{ route('auth.dashboard') }}"> <h3 class="text-white">{{ config('app.name') }}</h3></a>
				</div>
				<!-- begin sidebar scrollbar -->
				<div class="sidebar-left" data-simplebar style="height: 100%;">
					<!-- sidebar menu -->
					<ul class="nav sidebar-inner" id="sidebar-menu">
						<li class="{{ request()->is('auth/dashboard') ? 'active': '' }}">
							<a class="sidenav-item-link" href="{{ route('auth.dashboard') }}"> <i class="mdi mdi-briefcase-account-outline"></i> <span class="nav-text">Dashboard</span> </a>
						</li>


                        <li class="{{ request()->is('auth/trainings') ? 'active': '' }}">
							<a class="sidenav-item-link" href="{{ route('auth.trainings.edit') }}"> <i class="mdi mdi-close-circle"></i> <span class="nav-text">Training</span> </a>
						</li>

                        <li class="{{ request()->is('auth/inbox*') ? 'active': '' }}">
							<a class="sidenav-item-link" href="{{ route('auth.inbox.index') }}"> <i class="mdi mdi-map-marker"></i> <span class="nav-text">Inbox</span> </a>
						</li>

                        <li class="{{ request()->is('auth/accounts/edit') ? 'active': '' }}">
							<a class="sidenav-item-link" href="{{ route('auth.accounts.edit') }}"> <i class="mdi mdi-account"></i> <span class="nav-text">Account</span> </a>
						</li>


                        <li class="{{ request()->is('auth/billings') ? 'active': '' }}">
							<a class="sidenav-item-link" href="{{ route('auth.billings.index') }}"> <i class="mdi mdi-account"></i> <span class="nav-text">Billing</span> </a>
						</li>


                        {{-- <li class="{{ request()->is('admin/notes') ? 'active': '' }}">
							<a class="sidenav-item-link" href="{{ route('admin.notes.index') }}"> <i class="mdi mdi-map-marker"></i> <span class="nav-text">Notes</span> </a>
						</li> --}}

					</ul>
				</div>
			</div>
		</aside>
		<!-- ====================================
      ——— PAGE WRAPPER
      ===================================== -->
		<div class="page-wrapper">
			<!-- Header -->
			<header class="main-header" id="header">
				<nav class="navbar navbar-expand-lg navbar-light" id="navbar">
					<!-- Sidebar toggle button -->
					<button id="sidebar-toggler" class="sidebar-toggle"> <span class="sr-only">Toggle navigation</span> </button> <span class="page-title"></span>
					<div class="navbar-right ">

						<ul class="nav navbar-nav">
							<!-- Offcanvas -->
							<!-- User Account -->
							<li class="dropdown user-menu">
								<button class="dropdown-toggle nav-link" data-toggle="dropdown"> <img src="{{ 'https://ui-avatars.com/api/?name='. auth()->user()->name. '&background=random&color=fff&bold=true' }}" class="user-image rounded-circle" alt="User Image" /> <span class="d-none d-lg-inline-block">{{ auth()->user()->name }}</span> </button>
								<ul class="dropdown-menu dropdown-menu-right">
									<li>
										<a class="dropdown-link-item" href="{{ route('auth.profile.edit') }}"> <i class="mdi mdi-account-outline"></i> <span class="nav-text">My Profile</span> </a>
									</li>

									<li class="dropdown-footer">
										<a href="{{ route('auth.logout') }}" class="dropdown-link-item" href="sign-in.html"> <i class="mdi mdi-logout"></i> Log Out </a>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</nav>
			</header>
			<!-- ====================================
        ——— CONTENT WRAPPER
        ===================================== -->
			@yield('content')

			<!-- Footer -->
			<footer class="footer mt-auto">
				<div class="copyright bg-white">
					<p> &copy; <span id="copy-year"></span> Copyright Mono Dashboard </p>
				</div>
				<script>
				var d = new Date();
				var year = d.getFullYear();
				document.getElementById("copy-year").innerHTML = year;
				</script>
			</footer>
		</div>
	</div>

    @include('auth.includes.scripts')
    @yield('scripts')
</body>

</html>
