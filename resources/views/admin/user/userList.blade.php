@extends('admin.layouts/admin')
@section('content')
<ul class="breadcrumb cm_breadcrumb">
  <li><a href="{{ URL::to($redirectUrl) }}">Home</a></li>
  <li><a href="#">Manage Users</a></li>
  <li><a href="#">User List</a></li>
</ul>
<div class="inn_content">
  <form class="cm_frm1 verti_frm1">
    <div class="cm_head1">
      <h3>User List</h3>
    </div>
    <?php if (Session::has('success')) {?>
      <div role="alert" class="alert alert-success" style="height:auto;"><button type="button"  class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><?php echo Session::get('success'); ?> </div>
    <?php }?>

    <?php if (Session::has('error')) {?>
      <div role="alert" class="alert alert-danger" style="height:auto;"><button type="button"  class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Oh!</strong><?php echo Session::get('error'); ?> </div>
    <?php }?>


    <div class="cm_tablesc1 dep_tablesc mb-20">
      <div class="mb-20">
        <a href="{{ URL::to($redirectUrl.'/csv/userlist') }}" ><button type="button" class="btn cm_blacbtn">Export Users</button></a>
      </div>
      <div class="dataTables_wrapper form-inline dt-bootstrap">
        <div class="row">
          <div class="col-sm-12">

           <div class="cm_tableh3 table-responsive">
            <table class="table m-0" id="data_table_">
              <thead>
                <tr>
                  <th>S.No.<span class="fa fa-sort"></span></th>
                  <th>User<span class="fa fa-sort"></span></th>
                  <th>Registered Date<span class="fa fa-sort"></span></th>
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

<script type="text/javascript">
  var type = '<?php echo $userlist;?>';
  var redirectUrl = '<?php echo $redirectUrl;?>';
  adminurl = "{{URL::to('/')}}";
  $(document).ready(function(){
    $('#data_table_').DataTable({
      dom: 'lBfrtip',
      buttons: [
      'copy', 'csv', 'excel', 'pdf', 'print'
      ], 
      "destroy": true,
      "sServerMethod": "GET",
      "processing": true,
      "serverSide": true,
      "bLengthChange": false,
      oLanguage: { "sSearch": "",sProcessing: "<div id='loader'><i style='font-size:30px' class='fa fa-spinner fa-spin fa-pulse'></i></div>",
      sEmptyTable: "No Records Available",
      sSearch: "Search:",
    },
    "ajax": {
      "url":  adminurl + '/' + redirectUrl +'/userHistory/'+ type,
    },
  });
  });

  $('#data_table_').on('click', '.userRemove', function () {
   var con=confirm("Are you sure ?")
   if(con){
    return true;
  }
  else {
    return false;
  }
});

  $('#data_table_').on('click', '.tfaCls', function () {
   var con=confirm("Are you sure ?")
   if(con){
    return true;
  }
  else {
    return false;
  }
});

  $('#data_table_').on('click', '.delCls', function () {
   var con=confirm("Are you sure ?")
   if(con){
    return true;
  }
  else {
    return false;
  }
});

</script>
@stop