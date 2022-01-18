@extends('admin.layouts/admin')
@section('content')

<ul class="breadcrumb cm_breadcrumb">
  <li><a href="{{ URL::to($redirectUrl) }}">Home</a></li>
  <li><a href="#">Manage FAQ</a></li>
  <li><a href="#">FAQ List</a></li>
</ul>
<div class="inn_content">
  <form class="cm_frm1 verti_frm1">
    <div class="cm_head1">
      <h3>FAQ List</h3>
    </div>

    <?php if (Session::has('success')) {?>
      <div role="alert" class="alert alert-success" style="height:auto;"><button type="button"  class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><?php echo Session::get('success'); ?> </div>
    <?php }?>

    <?php if (Session::has('error')) {?>
      <div role="alert" class="alert alert-danger" style="height:auto;"><button type="button"  class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Oh!</strong><?php echo Session::get('error'); ?> </div>
    <?php }?>


    <div class="cm_tablesc1 dep_tablesc mb-20">
      <div class="mb-20">
        <a href="{{ URL::to($redirectUrl.'/addFaq') }}" ><button type="button" class="btn cm_blacbtn">Add New FAQ</button></a>
      </div>

      <div class="dataTables_wrapper form-inline dt-bootstrap">
        <div class="row">
          <div class="col-sm-12">
            <div class="cm_tableh3 table-responsive">
              <table class="table m-0" id="data_table_">
                <thead>
                  <tr>
                    <th>S.No.<span class="fa fa-sort"></span></th>
                    <th>FAQ Question<span class="fa fa-sort"></span></th>
                    <th>Description<span class="fa fa-sort"></span></th>
                    <th>Status<span class="fa fa-sort"></span></th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($faq_list) {
                   $ii = 1;foreach ($faq_list as $faq) {$faqId = encrypText($faq->id);?>
                    <tr>
                      <td><?php echo $ii; ?></td>
                      <td><?php echo strip_tags($faq->question); ?></td>

                      <td><?php echo strip_tags($faq->description); ?></td>
                      <td><a href="#" class="clsCtlr <?php if ($faq->status == "active") {echo "clsActive";} else {echo "clsDeactive";}?>"><?php echo ucfirst(strip_tags($faq->status)); ?></span></td>

                        <td>
                          <a href="{{ URL::to($redirectUrl.'/faqStatus/'.$faqId) }}" class="userRemove"><img src="{{ asset('/').('public/AVKpqBqmVJ/images/remove-user-icon.png') }}" title="Remove" /></a>

                          <a href="{{ URL::to($redirectUrl.'/faqEdit/'.$faqId) }}" class="editUser"><img src="{{ asset('/').('public/AVKpqBqmVJ/images/edit-icon.png') }}" title="Edit"  /></a>

                          <a href="{{ URL::to($redirectUrl.'/faqDelete/'.$faqId) }}" class="deleteUser"><img src="{{ asset('/').('public/AVKpqBqmVJ/images/delete-icon.png') }}" title="Delete"  /></a>
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