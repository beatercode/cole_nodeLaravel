@extends('admin.layouts/admin')
@section('content')
<?php $id = encrypText($userinfo->id);?>
<ul class="breadcrumb cm_breadcrumb">
  <li><a href="{{ URL::to($redirectUrl) }}">Home</a></li>
  <li><a href="{{ URL::to($redirectUrl.'/viewuser') }}">Manage Users</a></li>
  <li><a href="#">User Login List</a></li>
</ul>
<div class="inn_content">
  <form class="cm_frm1 verti_frm1">
    <div class="cm_head1">
      <h3>User Login History</h3>
    </div>
    <?php if (Session::has('success')) {?>
      <div role="alert" class="alert alert-success" style="height:auto;"><button type="button"  class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><?php echo Session::get('success'); ?> </div>
    <?php }?>
    <?php if (Session::has('error')) {?>
      <div role="alert" class="alert alert-danger" style="height:auto;"><button type="button"  class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Oh!</strong><?php echo Session::get('error'); ?> </div>
    <?php }?>
    <div class="cm_tablesc1 dep_tablesc mb-20">
      <div class="dataTables_wrapper form-inline dt-bootstrap">

        <h3>Username - {{$userinfo->consumer_name}}
          <a class="pull-right" href="{{ URL::to($redirectUrl.'/userDetail/'.$id) }}">Back</a>
        </h3>

        <div class="row">
          <div class="col-sm-12">
            <div class="cm_tableh3 table-responsive">
              <table class="table m-0" id="data_table_">
                <thead>
                  <tr>
                    <th>S.No.<span class="fa fa-sort"></span></th>
                    <th>Datetime<span class="fa fa-sort"></span></th>
                    <th>Ip<span class="fa fa-sort"></span></th>
                    <th>Location<span class="fa fa-sort"></span></th>

                  </tr>
                </thead>
                <tbody>
                  <?php if ($activity) {
                   $ii = 1;
                   foreach ($activity as $bal) {
                    ?>
                    <tr>
                      <td>{{$ii}}</td>
                      <td>{{ $bal->created_at }}</td>
                      <td>{{ $bal->ip_address }}</td>
                      <td>{{ $bal->city.','.$bal->country }}</td>

                    </tr>
                    <?php $ii++;}
                  }?>
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
  $(document).ready(function(){
    $('#data_table_').DataTable({
      dom: 'Bfrtip',
      buttons: [
      'copy', 'csv', 'excel', 'pdf', 'print'
      ]
    } );
  });
</script>
@stop