<header class="main-header">
  <div class="tp_layer1"> <a href="{{ URL::to($redirectUrl) }}" class="logo">
    <span class="logo-mini">
      <img src="{{asset('/').('public/IuMzmYaMZE/').$getSite->site_logo}}" alt="logo_small"> </span> <span class="logo-lg">
        <img src="{{asset('/').('public/IuMzmYaMZE/').$getSite->site_logo}}" alt=""> </span> </a> <a href="#" class="sidebar-toggle hidden-norm" data-toggle="offcanvas" role="button"> <span class="fa fa-bars hdt_cnt">Dashboard</span> </a> </div>
        <nav class="navbar navbar-static-top">
          <div class="mn_righ">
            <div class="mn_rightp fd_rw">
              <div class="tp_sear1">
              </div>
              <div class="navbar-custom-menu">
                <ul class="nav navbar-right">
                  <li class="dropdown dropdown-user"> 
                    <select class="form-control" id="sel1" onchange="chooseNw()">
                      <option value="BSC" <?php echo (session('adminNetwork') == 'BSC') ? 'selected' : '';?>>BSC</option>
                      <option value="ETC" <?php echo (session('adminNetwork') == 'ETC') ? 'selected' : '';?>>ETC</option>
                    </select>
                  </li>
                  <li class="dropdown dropdown-user"> 
                    <?php
                    if (session('adminMetaName') == "") {?>
                      <a href="javascript:;" id="connect_wallet" class="login-auto"><div class="user-image"><span class="hidden-xs">Connect Wallet</span></div></a>
                    <?php } else {
                      $address = session('adminMetaName');
                      $addr1 = substr($address, 0, 6);
                      $addr2 = substr($address, 38, 42);
                      $addr = $addr1.'..'.$addr2; 
                      ?>
                      <a href="javascript:;" id="disconnect"><div class="user-image"><span class="hidden-xs">{{$addr}}</span></div></a>
                    <?php } ?>
                  </li>
                  <li class="dropdown" id="decreasecount"> <a data-toggle="dropdown" class="dropdown-toggle drop_icocn"><span class="mn_ico1 mn_imbel"><img src="{{asset('/').('public/AVKpqBqmVJ/images/mn_imbel.png')}}"> <sup id="re_count"><?php echo App\Model\SubAdmin::getNotificationCount() ?></sup> </span></a>
                    <?php $notify = App\Model\SubAdmin::getAdminNotifcation();?>
                    <ul class="dropdown-menu anti_dropdown aler_drop notscroll">
                      <?php
                      $url = array(
                       'New-user' => URL::to($redirectUrl.'/viewuser'),
                     );
                      if ($notify != "") {
                       foreach ($notify as $not) {
                        ?>
                        <li class="<?php if ($not->status == "unread") {echo "succ_nrw";} else {echo "prim_nrw";}?> noti_rw1">
                          <a href="<?php echo $url[$not->type]; ?>">
                            <div class="fd_rw">
                              <div class="notification_desc">
                                <p>{{$not->message}}</p>
                                <p class="hr_tx"><?php echo App\Model\SubAdmin::getTimeAgo($not->created_at) ?></p>
                              </div>
                            </div>
                          </a>
                        </li>
                      <?php }} else {?>
                        <li class="noti_rw1">
                          <div class="fd_rw">
                            <div class="notification_desc">
                              <p>No notifications found!</p>
                            </div>
                          </div>
                        </li>
                      <?php }?>
                    </ul>
                  </li>
                  <?php
                  $getProfile = App\Model\SubAdmin::getProfile(Session::get('adminId'));
                  ?>
                  <li class="dropdown dropdown-user"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <div class="user-image"><span class="hidden-xs">Hi, {{ $getProfile['admin']->admin_username }}</span> <img src="{{asset('/').('public/AVKpqBqmVJ/images/mn_imusr.png')}}" class="img-responsive" alt="User"> </div>
                  </a>
                  <ul class="dropdown-menu usr_drpmn">
                    <li class="user-header">
                      <div class="usr_mask">
                        <p> {{ $getProfile['admin']->admin_username }} </p>
                      </div>
                      <div class="admin_profile_icon">
                        <?php if ($getProfile['admin']->admin_profile == "") {?>
                          <img src="{{asset('/').('public/AVKpqBqmVJ/images/default-avatar.png')}}" class="img-responsive" alt="User Image">
                        <?php } else {?>
                          <img src="{{asset('/').('public/IuMzmYaMZE/').$getProfile['admin']->admin_profile}}" class="img-responsive" alt="User Image">
                        <?php }?>
                      </div>
                    </li>
                    <li class="user-body">
                      <div class="">
                        <?php
                        if (Session::get('adminId') == "1" && Session::get('adminRole') == "admin") {?>
                         <div class="col-xs-6"> <a href="{{ URL::to($redirectUrl.'/profile') }}" class="active">Profile</a> </div>
                         <div class="col-xs-6"> <a href="{{ URL::to($redirectUrl.'/settings') }}">Settings</a> </div>
                       <?php } else {?>
                        <div class="col-xs-2"></div>
                        <div class="col-xs-8"> <a href="{{ URL::to($redirectUrl.'/profile') }}" class="active">Profile</a> </div>
                        <div class="col-xs-2"></div>
                      <?php }?>
                    </div>
                  </li>
                  <li class="user-footer text-center"> <a href="{{ URL::to($redirectUrl.'/logout') }}" class="btn btn-flat center-block">Logout</a> </li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
  </header>