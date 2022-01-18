@extends('admin.layouts/admin')
@section('content')
<ul class="breadcrumb cm_breadcrumb">
  <li><a href="{{ URL::to($redirectUrl) }}">Home</a></li>
  <li><a href="#">Manage CMS</a></li>
  <li><a href="#">CMS List</a></li>
</ul>
<div class="inn_content">
  <form class="cm_frm1 verti_frm1">
    <div class="cm_head1">
      <h3>CMS List</h3>
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
                    <th>CMS Title<span class="fa fa-sort"></span></th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($cms_list) {
                   $ii = 1;foreach ($cms_list as $cms) {
                    $cmsId = encrypText($cms->id);
                    ?>
                    <tr>
                      <td>{{$ii}}</td>
                      <td>{{$cms->title}}</td>
                      <td style="text-align: center;">
                        <a href="{{ URL::to($redirectUrl.'/cmsEdit/'.$cmsId) }}" class="editUser mr-10"><img src="{{asset('/').('public/AVKpqBqmVJ/images/edit-icon.png')}}" title="Edit" /></a>
                        <a href="{{ URL::to($redirectUrl.'/cmsStatus/'.$cmsId) }}" class="delete"><img src="{{ asset('/').('public/AVKpqBqmVJ/images/delete-icon.png') }}" title="Delete"  /></a>
                      </td>
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

  $('#data_table_').on('click', '.delete', function () {
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