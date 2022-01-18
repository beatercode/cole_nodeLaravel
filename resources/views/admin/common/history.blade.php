@extends('admin.layouts/admin')
@section('content')

<ul class="breadcrumb cm_breadcrumb">
  <li><a href="{{ URL::to($redirectUrl) }}">Home</a></li>
  <li><a href="#">View Admin Panel Login History</a></li>
  <li><a href="#">Login History</a></li>
</ul>
<div class="inn_content">
  <form class="cm_frm1 verti_frm1">
    <div class="cm_head1">
      <h3>Login History</h3>
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
              <table class="table m-0" id="data_table_">
                <thead>
                  <tr>
                    <th>S.No.<span class="fa fa-sort"></span></th>
                    <th>Admin name<span class="fa fa-sort"></span></th>
                    <th>IP Address <span class="fa fa-sort"></span></th>
                    <th>Activity  <span class="fa fa-sort"></span></th>
                    <th>Browser  <span class="fa fa-sort"></span></th>
                    <th>OS  <span class="fa fa-sort"></span></th>
                    <th>Time<span class="fa fa-sort"></span></th>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($history) {
                   $ii = 1;foreach ($history as $hist) {
                    $getUser = App\Model\SubAdmin::getProfile(strip_tags($hist->admin_id));
                    $username = $getUser['admin']['admin_username'];?>
                    <tr>
                      <td><?php echo $ii; ?></td>
                      <td><?php echo $username; ?></td>
                      <td><?php echo strip_tags($hist->ip_address); ?></td>
                      <td><?php echo strip_tags($hist->activity); ?></td>
                      <td><?php echo strip_tags($hist->browser_name); ?></td>
                      <td><?php echo strip_tags($hist->os); ?></td>
                      <td><?php echo strip_tags($hist->created_at); ?></td>
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
    $('#data_table_').DataTable();
  });
</script>

@stop