<?php
$getSite = App\Model\User::getSiteLogo();
?>
<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Admin</title>
	<link rel="icon" href="{{asset('/').('public/IuMzmYaMZE/').$getSite->site_favicon}}" type="image/x-icon">
	<link rel="stylesheet" href="{{asset('/').('public/AVKpqBqmVJ/css/style.css')}}">
	<link rel="stylesheet" href="{{asset('/').('public/AVKpqBqmVJ/css/style_dashbard.css')}}">
	<link rel="stylesheet" href="{{asset('/').('public/AVKpqBqmVJ/css/dash_responsive.css')}}">
	<link rel="stylesheet" href="{{asset('/').('public/AVKpqBqmVJ/css/font-awesome.min.css')}}">
	<link rel="stylesheet" href="{{asset('/').('public/AVKpqBqmVJ/css/jquery-ui.css')}}">
	<link rel="stylesheet" href="{{asset('/').('public/AVKpqBqmVJ/css/fullcalendar.min.css')}}">
	<link rel="stylesheet" href="{{asset('/').('public/AVKpqBqmVJ/css/jquery-ui.min.css')}}">
	<link rel="stylesheet" href="{{asset('/').('public/AVKpqBqmVJ/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('/').('public/AVKpqBqmVJ/css/jquery.mCustomScrollbar.css')}}">
	<link rel="stylesheet" href="{{asset('/').('public/AVKpqBqmVJ/css/bootstrap-datetimepicker.min.css')}}">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i">
	<link rel="stylesheet" href="{{asset('/').('public/AVKpqBqmVJ/css/lc_switch.css')}}">
	<link rel="stylesheet" href="{{asset('/').('public/AVKpqBqmVJ/css/jquery.dataTables.min.css')}}">
	<link rel="stylesheet" href="{{asset('/').('public/AVKpqBqmVJ/css/export.css')}}" type="text/css" media="all" />
	<link rel="stylesheet" href="{{asset('/').('public/FbGDnwAZEgTX/css/notifIt.css')}}">
	<style type="text/css">
	.error{
		color:red;
	}

	@media(min-width:1024px){
		.col-lg-20{width:20%;float:left;padding-left:15px;padding-right:15px;}
	}	
</style>
<script src="{{asset('/').('public/AVKpqBqmVJ/js/jquery.min.js')}}"> </script>
<script src="{{asset('/').('public/AVKpqBqmVJ/js/jquery.validate.min.js')}}"> </script>
</head>
<body class="hold-transition sidebar-mini">
	<div class="wrapper">
		@include('admin.layouts.header')
		@include('admin.layouts.sidebar')
		<div class="content-wrapper">
			@yield('content')
		</div>
		<footer>
			@include('admin.layouts.footer')
		</footer>
	</div>
</body>
</html>
<div class="modal fade" id="disconnect-wallet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Connected Network : {{session('adminNetwork')}}</h4>
			</div>
			<div class="modal-body">
				<p>Address: {{session('adminMetaName')}}</p>
			</div>
			<div class="modal-footer">
				<div class="mb-20">
					<a href="{{ URL::to($redirectUrl.'/disconnectWallet') }}"><button type="button" id="disconnect_wallet" class="btn cm_blacbtn" onclick="logout();">Disconnect wallet</button></a>
				</div>
			</div>
		</div>
	</div>
</div>

