<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="Nowa – Laravel Bootstrap 5 Admin & Dashboard Template">
		<meta name="Author" content="Spruko Technologies Private Limited">
		<meta name="Keywords" content="admin dashboard, admin dashboard laravel, admin panel template, blade template, blade template laravel, bootstrap template, dashboard laravel, laravel admin, laravel admin dashboard, laravel admin panel, laravel admin template, laravel bootstrap admin template, laravel bootstrap template, laravel template"/>

		<!-- Title -->
		<title> Nowa – Laravel Bootstrap 5 Admin & Dashboard Template </title>

        @include('admin.nowa.views.layouts.components.styles')

	</head>

	<body class="ltr main-body app sidebar-mini">

		<!-- Loader -->
		<div id="global-loader">
			<img src="{{asset('admin/assets/img/loader.svg')}}" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->

		<!-- Page -->
		<div class="page">

			<div>

                @include('admin.nowa.views.layouts.components.app-header')

                @include('admin.nowa.views.layouts.components.app-sidebar')

			</div>

			<!-- main-content -->
			<div class="main-content app-content">

				<!-- container -->
				<div class="main-container container-fluid">

                    @yield('content')

				</div>
				<!-- Container closed -->
			</div>
			<!-- main-content closed -->

            @include('admin.nowa.views.layouts.components.sidebar-right')

            @include('admin.nowa.views.layouts.components.modal')

            @yield('modal')

            @include('admin.nowa.views.layouts.components.footer')

		</div>
		<!-- End Page -->

        @include('admin.nowa.views.layouts.components.scripts')

    </body>
</html>
