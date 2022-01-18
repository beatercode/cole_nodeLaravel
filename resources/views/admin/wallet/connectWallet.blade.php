@extends('admin.layouts/admin')
@section('content')
<ul class="breadcrumb cm_breadcrumb">
  <li><a href="{{ URL::to($redirectUrl) }}">Home</a></li>
  <li><a href="#">Manage Lottery</a></li>
  <li><a href="#">Connect Wallet</a></li>
</ul>
<div class="inn_content">
  <form class="cm_frm1 verti_frm1">
    <div class="cm_head1">
      <h3>Connect Wallet</h3>
    </div>
    <?php if (Session::has('success')) {?>
      <div role="alert" class="alert alert-success" style="height:auto;"><button type="button"  class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><?php echo Session::get('success'); ?> </div>
    <?php }?>

    <?php if (Session::has('error')) {?>
      <div role="alert" class="alert alert-danger" style="height:auto;"><button type="button"  class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Oh!</strong><?php echo Session::get('error'); ?> </div>
    <?php }?>
    <div class="cm_tablesc1 dep_tablesc mb-20">
      <div class="mb-20">
        <a href="javascript:;"><button type="button" id="connect_wallet" class="btn cm_blacbtn login-auto">Connect wallet</button></a>
        <span id="addr" style="display:none;">Address : <span id="connected_wallet"></span></span>
      </div>
    </div>
  </form>
</div>
@stop
