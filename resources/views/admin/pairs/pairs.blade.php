@extends('admin.layouts/admin')
@section('content')

<ul class="breadcrumb cm_breadcrumb">
  <li><a href="{{ URL::to($redirectUrl) }}">Home</a></li>
  <li><a href="#">Manage Pairs</a></li>
  <li><a href="#">Pairs List</a></li>
</ul>
<div class="inn_content">
  <form class="cm_frm1 verti_frm1">
    <div class="cm_head1">
      <h3>Pairs List</h3>
    </div>

    <?php if (Session::has('success')) {?>
      <div role="alert" class="alert alert-success" style="height:auto;"><button type="button"  class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><?php echo Session::get('success'); ?> </div>
    <?php }?>

    <?php if (Session::has('error')) {?>
      <div role="alert" class="alert alert-danger" style="height:auto;"><button type="button"  class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Oh!</strong><?php echo Session::get('error'); ?> </div>
    <?php }?>


    <div class="cm_tablesc1 dep_tablesc mb-20">
      <div class="mb-20">
        <a href="{{ URL::to($redirectUrl.'/addPair') }}" ><button type="button" class="btn cm_blacbtn">Add New Pair</button></a>
      </div>
      <div class="form-group row clearfix">
        <div class="col-sm-3 col-xs-12">
          <label class="form-control-label">Network Type</label>
          <select name="nw_type" id="nw_type" class ="form-control">
            <option value="BSC">BSC</option>
            <option value="ETC">ETC</option>
          </select>
        </div>
        <div class="col-sm-3 col-xs-12">
          <label class="form-control-label">Pair Type</label>
          <select name="pair_type" id="pair_type" class ="form-control">
            <option value="1">Liquidity</option>
            <option value="2">Staking</option>
          </select>
        </div>
      </div>
      <div class="dataTables_wrapper form-inline dt-bootstrap">
        <div class="row">
          <div class="col-sm-12">
            <div class="cm_tableh3 table-responsive">
              <table class="table m-0" id="data_table_">
                <thead>
                  <tr>
                    <th>S.No.<span class="fa fa-sort"></span></th>
                    <th>Pair Name<span class="fa fa-sort"></span></th>
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

  </form>
</div>

<script>
  var redirectUrl = '<?php echo $redirectUrl;?>';
  adminurl = "{{URL::to('/')}}";
  $(document).ready(function(){
    pairList('BSC', '1');
  });

  function pairList(nw_type, pair_type) {
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
      "url":  adminurl + '/' + redirectUrl +'/pairHistory/'+ nw_type + '/' + pair_type,
    },
  });
  }

  $('#nw_type').change(function(){
    var nw_type = $(this).val();
    var pair_type = $('#pair_type').val();
    pairList(nw_type,pair_type);
  });

  $('#pair_type').change(function(){
    var nw_type = $('#nw_type').val();
    var pair_type = $(this).val();
    pairList(nw_type,pair_type);
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

  $('#data_table_').on('click', '.deleteUser', function () {
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