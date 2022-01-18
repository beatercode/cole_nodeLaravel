@extends('admin.layouts/admin')
@section('content')

<ul class="breadcrumb cm_breadcrumb">
	<li><a href="{{ URL::to($redirectUrl) }}">Home</a></li>
	<li><a href="#">Manage SUbadmin</a></li>
	<li><a href="#">Subadmin List</a></li>
</ul>
<div class="inn_content">
  <form class="cm_frm1 verti_frm1">
    <div class="cm_head1">
      <h3>Subadmin List</h3>
    </div>
    <?php if (Session::has('success')) {?>
      <div role="alert" class="alert alert-success" style="height:auto;"><button type="button"  class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><?php echo Session::get('success'); ?> </div>
    <?php }?>

    <?php if (Session::has('error')) {?>
      <div role="alert" class="alert alert-danger" style="height:auto;"><button type="button"  class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Oh!</strong><?php echo Session::get('error'); ?> </div>
    <?php }?>

    <div class="cm_tablesc1 dep_tablesc mb-20">
      <div class="mb-20">
        <a href="{{ URL::to($redirectUrl.'/addSubadmin') }}" ><button type="button" class="btn cm_blacbtn">Create SubAdmin</button></a>
      </div>

      <div class="dataTables_wrapper form-inline dt-bootstrap">
        <div class="row">
          <div class="col-sm-12">
            <div class="cm_tableh3 table-responsive">
              <table class="table m-0" id="data_table_">
                <thead>
                  <tr>
                    <th>S.No.<span class="-fa fa-sort"></span></th>
                    <th>Username<span class="fa fa-sort"></span></th>
                    <th>Email Address<span class="fa fa-sort"></span></th>
                    <th>Created Date<span class="fa fa-sort"></span></th>
                    <th>Status<span class="fa fa-sort"></span></th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($subadmin) {
                   $ii = 1;foreach ($subadmin as $sub) {
                    $id = encrypText($sub->id);?>
                    <tr>
                      <td><?php echo $ii; ?></td>
                      <td><?php echo strip_tags($sub->admin_username); ?></td>
                      <td><?php echo decrypText(strip_tags($sub->admin_desc)) . "@" . decrypText(strip_tags($sub->admin_sub_key)); ?></td>
                      <td><?php echo strip_tags($sub->created_at); ?></td>
                      <td><span class="clsCtlr <?php echo ($sub->status == "active") ? "clsActive" : "clsNotVerify"; ?>"><?php echo ucfirst(strip_tags($sub->status)); ?></span></td>
                      <td>
                        <a href="{{ URL::to($redirectUrl.'/subadminStatus/'.$id) }}" class="userRemove"><img src="{{asset('/').('public/AVKpqBqmVJ/images/remove-user-icon.png')}}" title="Remove" /></a>
                        <a href="{{ URL::to($redirectUrl.'/subadminEdit/'.$id) }}" class="editUser"><img src="{{asset('/').('public/AVKpqBqmVJ/images/edit-icon.png')}}" title="Edit"  /></a>
                        <a href="{{ URL::to($redirectUrl.'/deleteSubadmin/'.$id) }}" class="deleteUser"><img src="{{asset('/').('public/AVKpqBqmVJ/images/delete-icon.png')}}" title="Delete"  /></a>
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
@stop