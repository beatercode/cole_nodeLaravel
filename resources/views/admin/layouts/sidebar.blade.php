<aside class="main-sidebar">
    <div class="sidebar">
      <!-- sidebar menu -->
      <ul class="sidebar-menu" id="accord_side">
        <li class="hidden-xs">
            <a href="{{ URL::to($redirectUrl) }}" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <span class="fa fa-bars hdt_cnt">Menu</span> </a>
        </li>
        <li>
            <a href="{{ URL::to($redirectUrl) }}" class="mn_catgcur fa fa-tachometer"><span>Dashboard</span></a>
        </li>
        <?php
        $currentRoute = \Route::getCurrentRoute()->getActionName();
        $explodeRoute = explode('@', $currentRoute);
        $uri = $explodeRoute[1];
        ?>
        <?php if (Session::get('adminId') == "1" && Session::get('adminRole') == "admin") {?>
            <li class="childcateg <?php if ($uri == "viewHistory" || $uri == "userList" || $uri == "userDetail") {echo "active";}?>">
                <a class="mn_sib fa fa-users" data-toggle="collapse" data-parent="#accord_side" href="#sid_mn2" aria-expanded="true"><span>Manage Users</span></a>
                <ul id="sid_mn2" class="mnsub_catglis collapse <?php if ($uri == "viewHistory" || $uri == "userList" || $uri == "userDetail") {echo "in";}?>" aria-expanded="true" style="">
                    <li><a href="{{ URL::to($redirectUrl.'/viewuser') }}" class="mnsub_catg fa fa-list-ul">User List</a></li>
                </ul>
            </li>
            <li class="childcateg <?php if ($uri == "viewSubadmin" || $uri == "addSubadmin" || $uri == "loginHistory") {echo "active";}?>"> 
                <a class="mn_sib fa fa-user" data-toggle="collapse" data-parent="#accord_side" href="#sid_mn1" aria-expanded="true"><span>Manage SubAdmin</span></a>
                <ul id="sid_mn1" class="mnsub_catglis collapse <?php if ($uri == "viewSubadmin" || $uri == "addSubadmin" || $uri == "loginHistory") {echo "in";}?>" aria-expanded="true" style="">
                    <li><a href="{{ URL::to($redirectUrl.'/viewSubadmin') }}" class="mnsub_catg fa fa-user-secret">View Subadmin</a></li>
                    <li><a href="{{ URL::to($redirectUrl.'/addSubadmin') }}" class="mnsub_catg fa fa-user-plus">Add Subadmin</a></li>
                    <li><a href="{{ URL::to($redirectUrl.'/loginHistory') }}" class="mnsub_catg fa fa-history">Admin Log history</a></li>
                </ul>
            </li>


            <li class="<?php if ($uri == "viewPairs") {echo "active";}?>">
                <a href="{{ URL::to($redirectUrl.'/viewPairs') }}" class="mn_catgcur fa fa-exchange"><span>Manage Pairs</span> </a>
            </li>

            <li class="childcateg <?php if ($uri == "staking_history" || $uri == "swap_history") {echo "active";}?>"> 
                <a class="mn_sib fa fa-exchange" data-toggle="collapse" data-parent="#accord_side" href="#sid_mn4" aria-expanded="true"><span>Manage Transactions</span></a>
                <ul id="sid_mn4" class="mnsub_catglis collapse <?php if ($uri == "staking_history" || $uri == "swap_history") {echo "in";}?>" aria-expanded="true" style="">
                    <li><a href="{{ URL::to($redirectUrl.'/staking_history') }}" class="mnsub_catg fa fa-history">Stake History</a></li>
                    <li><a href="{{ URL::to($redirectUrl.'/swap_history') }}" class="mnsub_catg fa fa-history">Swap History</a></li>
                </ul>
            </li>

            <li class="<?php if ($uri == "presale") {echo "active";}?>">
                <a href="{{ URL::to($redirectUrl.'/presale') }}" class="mn_catgcur fa fa-money"><span>Presale</span> </a>
            </li>

            <li class="<?php if ($uri == "viewBlockIp") {echo "active";}?>">
                <a href="{{ URL::to($redirectUrl.'/viewBlockIp') }}" class="mn_catgcur fa fa-user-times"><span>Block IP Address</span> </a>
            </li>

            <li class="<?php if ($uri == "viewWhitelistIp") {echo "active";}?>">
                <a href="{{ URL::to($redirectUrl.'/viewWhitelistIp') }}" class="mn_catgcur fa fa-user-times"><span>Whitelist IP Address</span> </a>
            </li>

            <li class="<?php if ($uri == "viewFaq") {echo "active";}?>">
                <a href="{{ URL::to($redirectUrl.'/viewfaq') }}" class="mn_catgcur fa fa-question"><span>Manage FAQ</span> </a>
            </li>

            <li class="<?php if ($uri == "viewRoadmap" || $uri == "roadmapEdit") {echo "active";}?>">
                <a href="{{ URL::to($redirectUrl.'/viewRoadmap') }}" class="mn_catgcur fa fa-road"><span>Manage Roadmap</span> </a>
            </li>

            <li class="childcateg <?php if ($uri == "viewCms") {echo "active";}?>">
                <a class="mn_sib fa fa-files-o" data-toggle="collapse" data-parent="#accord_side" href="#sid_mn3" aria-expanded="true"> <span>CMS Management</span> </a>
                <ul id="sid_mn3" class="mnsub_catglis collapse <?php if ($uri == "viewCms") {echo "in";}?>" aria-expanded="true" style="">
                    <li><a href="{{ URL::to($redirectUrl.'/viewcms/page') }}" class="mnsub_catg fa fa-clone">CMS Pages</a></li>
                    <li><a href="{{ URL::to($redirectUrl.'/viewcms/content') }}" class="mnsub_catg fa fa-folder-open-o">CMS Static content</a></li>
                </ul>
            </li>
        <?php } else {
            $permis = App\Model\SubAdmin::getPermission(Session::get('adminId'));
            $permis = explode(',', $permis);
            ?>
            <?php if (in_array("1", $permis)) { ?>
                <li class="childcateg <?php if ($uri == "viewHistory" || $uri == "userList" || $uri == "userDetail") {echo "active";}?>">
                    <a class="mn_sib fa fa-users" data-toggle="collapse" data-parent="#accord_side" href="#sid_mn2" aria-expanded="true"><span>Manage Users</span></a>
                    <ul id="sid_mn2" class="mnsub_catglis collapse <?php if ($uri == "viewHistory" || $uri == "userList" || $uri == "userDetail") {echo "in";}?>" aria-expanded="true" style="">
                        <li><a href="{{ URL::to($redirectUrl.'/viewuser') }}" class="mnsub_catg fa fa-list-ul">User List</a></li>
                    </ul>
                </li>
            <?php }

            if (in_array("2", $permis)) {?>
                <li class="<?php if ($uri == "viewPairs") {echo "active";}?>">
                    <a href="{{ URL::to($redirectUrl.'/viewPairs') }}" class="mn_catgcur fa fa-exchange"><span>Manage Pairs</span> </a>
                </li>

                <li class="childcateg <?php if ($uri == "staking_history" || $uri == "swap_history") {echo "active";}?>"> 
                    <a class="mn_sib fa fa-exchange" data-toggle="collapse" data-parent="#accord_side" href="#sid_mn4" aria-expanded="true"><span>Manage Transactions</span></a>
                    <ul id="sid_mn4" class="mnsub_catglis collapse <?php if ($uri == "staking_history" || $uri == "swap_history") {echo "in";}?>" aria-expanded="true" style="">
                        <li><a href="{{ URL::to($redirectUrl.'/staking_history') }}" class="mnsub_catg fa fa-history">Stake History</a></li>
                        <li><a href="{{ URL::to($redirectUrl.'/swap_history') }}" class="mnsub_catg fa fa-history">Swap History</a></li>
                    </ul>
                </li>

                <li class="<?php if ($uri == "presale") {echo "active";}?>">
                    <a href="{{ URL::to($redirectUrl.'/presale') }}" class="mn_catgcur fa fa-money"><span>Presale</span> </a>
                </li>
            <?php }

            if (in_array("3", $permis)) {?>
                <li class="<?php if ($uri == "viewBlockIp") {echo "active";}?>">
                    <a href="{{ URL::to($redirectUrl.'/viewBlockIp') }}" class="mn_catgcur fa fa-user-times"><span>Block IP Address</span> </a>
                </li>
            <?php }

            if (in_array("4", $permis)) {?>
                <li class="<?php if ($uri == "viewWhitelistIp") {echo "active";}?>">
                    <a href="{{ URL::to($redirectUrl.'/viewWhitelistIp') }}" class="mn_catgcur fa fa-user-times"><span>Whitelist IP Address</span> </a>
                </li>
            <?php }

            if (in_array("5", $permis)) {?>
                <li class="<?php if ($uri == "viewFaq") {echo "active";}?>">
                    <a href="{{ URL::to($redirectUrl.'/viewfaq') }}" class="mn_catgcur fa fa-question"><span>Manage FAQ</span> </a>
                </li>
            <?php } 

            if (in_array("6", $permis)) {?>
                <li class="<?php if ($uri == "viewRoadmap" || $uri == "roadmapEdit") {echo "active";}?>">
                    <a href="{{ URL::to($redirectUrl.'/viewRoadmap') }}" class="mn_catgcur fa fa-road"><span>Manage Roadmap</span> </a>
                </li>
            <?php }

            if (in_array("7", $permis)) {?>
                <li class="childcateg <?php if ($uri == "viewCms") {echo "active";}?>">
                    <a class="mn_sib fa fa-files-o" data-toggle="collapse" data-parent="#accord_side" href="#sid_mn3" aria-expanded="true"> <span>CMS Management</span> </a>
                    <ul id="sid_mn3" class="mnsub_catglis collapse <?php if ($uri == "viewCms") {echo "in";}?>" aria-expanded="true" style="">
                        <li><a href="{{ URL::to($redirectUrl.'/viewcms/page') }}" class="mnsub_catg fa fa-clone">CMS Pages</a></li>
                        <li><a href="{{ URL::to($redirectUrl.'/viewcms/content') }}" class="mnsub_catg fa fa-folder-open-o">CMS Static content</a></li>
                    </ul>
                </li>
            <?php }
        }?>
    </ul>
</div>
</aside>