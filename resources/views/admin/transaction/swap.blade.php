@extends('admin.layouts/admin')
@section('content')

<ul class="breadcrumb cm_breadcrumb">
  <li><a href="{{ URL::to($redirectUrl) }}">Home</a></li>
  <li><a href="#">Manage Transaction</a></li>
  <li><a href="#">Swap List</a></li>
</ul>
<div class="inn_content">
  <form class="cm_frm1 verti_frm1">
    <div class="cm_head1">
      <h3>Swap List</h3>
    </div>

    <?php if (Session::has('success')) {?>
      <div role="alert" class="alert alert-success" style="height:auto;"><button type="button"  class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><?php echo Session::get('success'); ?> </div>
    <?php }?>

    <?php if (Session::has('error')) {?>
      <div role="alert" class="alert alert-danger" style="height:auto;"><button type="button"  class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Oh!</strong><?php echo Session::get('error'); ?> </div>
    <?php }?>

    <div class="cm_tablesc1 dep_tablesc mb-20">
      <div class="dataTables_wrapper form-inline dt-bootstrap">
        <div class="row">
          <div class="col-sm-12">
            <div class="cm_tableh3 table-responsive">
              <table class="table m-0" id="swap_history">
                <thead>
                  <tr>
                    <th>S.No.<span class="fa fa-sort"></span></th>
                    <th>Pair<span class="fa fa-sort"></span></th>
                    <th>Amount<span class="fa fa-sort"></span></th>
                    <th>Transation ID<span class="fa fa-sort"></span></th>
                    <th>Date & Time<span class="fa fa-sort"></span></th>
                    <th>Status<span class="fa fa-sort"></span></th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<script>
  var redirectUrl = '<?php echo $redirectUrl;?>';
  adminurl = "{{URL::to('/')}}";
  $(document).ready(function(){
    $('#swap_history').DataTable({
      dom: 'lBfrtip',
      "destroy": true,
      "sServerMethod": "GET",
      "processing": true,
      "serverSide": true,
      oLanguage: { "sSearch": "",sProcessing: "<div id='loader'><i style='font-size:30px' class='fa fa-spinner fa-spin fa-pulse'></i></div>",
      sEmptyTable: "No Records Available",
      sSearch: "Search:",
    },
    "ajax": {
      "url": adminurl + '/' + redirectUrl + '/transactionHistory/Swap',
    },
  });
  });
</script>

@stop