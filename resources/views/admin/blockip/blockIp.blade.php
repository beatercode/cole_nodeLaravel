@extends('admin.layouts/admin')
@section('content')

<ul class="breadcrumb cm_breadcrumb">
  <li><a href="{{ URL::to($redirectUrl) }}">Home</a></li>
  <li><a href="#">Block IP</a></li>
  <li><a href="#">IP List</a></li>
</ul>
<div class="inn_content">
  <div class="cm_frm1 verti_frm1">
    <div class="cm_head1">
      <h3>IP List</h3>
    </div>

    <?php if (Session::has('success')) {?>
      <div role="alert" class="alert alert-success" style="height:auto;"><button type="button"  class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><?php echo Session::get('success'); ?> </div>
    <?php }?>

    <?php if (Session::has('error')) {?>
      <div role="alert" class="alert alert-danger" style="height:auto;"><button type="button"  class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Oh!</strong><?php echo Session::get('error'); ?> </div>
    <?php }?>


    <div class="cm_tablesc1 dep_tablesc mb-20">
      {!! Form::open(array('url' => $redirectUrl.'/addIpAddress','id'=>'ip_form')) !!}
      <div class="row mb-10 topstatusBar">
        <div class="col-md-4 col-sm-4">
          <label class="">Add New IP</label>
          <div class="">
            <input type="text" name="ip_addr" class="form-control">
          </div>
        </div>
      </div>
      <div class="mb-20">
        <button type="submit" class="btn cm_blacbtn">Submit</button>
      </div>
      {!! Form::close() !!}

      <div class="dataTables_wrapper form-inline dt-bootstrap">
        <div class="row">
          <div class="col-sm-12">
            <div class="cm_tableh3 table-responsive">
              <table class="table m-0" id="data_table_">
                <thead>
                  <tr>
                    <th>S.No.<span class="fa fa-sort"></span></th>
                    <th>IP Address<span class="fa fa-sort"></span></th>
                    <th>Status<span class="fa fa-sort"></span></th>
                    <th>Actions</th>
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

  </div>
</div>

<script>
  adminurl = "{{URL::to('/')}}";
  var redirectUrl = '<?php echo $redirectUrl;?>';
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
      "url":  adminurl + '/' + redirectUrl + '/blockHistory',
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

  $.validator.addMethod('IP4Checker', function(value) {

    var ip="^([01]?\\d\\d?|2[0-4]\\d|25[0-5])\\." +
    "([01]?\\d\\d?|2[0-4]\\d|25[0-5])\\." +
    "([01]?\\d\\d?|2[0-4]\\d|25[0-5])\\." +
    "([01]?\\d\\d?|2[0-4]\\d|25[0-5])$";
    return value.match(ip);
  }, 'Invalid IP address');

  $('#ip_form').validate({
    rules: {
      ip_addr: {
        required: true,
        IP4Checker: true
      }
    },
    messages:{
      ip_addr: {
        required: "Enter IP Address",
      }
    }
  });
</script>

@stop