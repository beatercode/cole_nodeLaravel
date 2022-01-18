@extends('admin.layouts/admin')
<div class="loader" id="myLoad">
	<div class="spinner">
		<div class="double-bounce1"></div>
		<div class="double-bounce2"></div>
	</div>
</div>
@section('content')

<?php if (Session::has('success')) {?>
	<div role="alert" class="alert alert-success" style="height:auto;"><button type="button"  class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><?php echo Session::get('success'); ?> </div>
<?php }?>

<?php if (Session::has('error')) {?>
	<div role="alert" class="alert alert-danger" style="height:auto;"><button type="button"  class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Oh!</strong><?php echo Session::get('error'); ?> </div>
<?php }?>

<ul class="breadcrumb cm_breadcrumb">
	<li><a href="#">Home</a></li>
</ul>
<div class="mainWrapper">
	<div class="cardsTopSec mb-20">
		<div class="row">
			<div class="col-md-3 col-sm-6">
				<a href="{{ URL::to($redirectUrl.'/viewnewuser') }}">
					<div class="cardsBlk cardsClr1">
						<p>New Users</p>
						<div class="midSec">
							{{ $data['new_users'] }}
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-3 col-sm-6">
				<a href="{{ URL::to($redirectUrl.'/viewuser') }}">
					<div class="cardsBlk cardsClr2">
						<p>Total Users</p>
						<div class="midSec">
							{{ $data['total_users'] }}
						</div>						
					</div>
				</a>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">

	setTimeout(function(){
		document.getElementById("myLoad").style.display="none";
	}, 3000);
</script>
@stop