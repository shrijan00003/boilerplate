<header class="main-header">
    <a href="<?php echo site_url('admin'); ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><img src="<?php echo site_url('assets/images/logo.png'); ?>" alt="<?php echo config_item('site_name_short');?>" /></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><img src="<?php echo site_url('assets/images/logo.png'); ?>" alt="<?php echo config_item('site_name');?>" />&nbsp;&nbsp;<?php echo config_item('site_name'); ?></span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <?php print $this->load->view($this->config->item('template_admin') . 'server');?>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <?php /* ?>
                <!-- Notifications: style can be found in dropdown.less -->
                <li class="dropdown notifications-menu" id="my-notifications">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-danger"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">Loading...</li>
                        
                    </ul>
                </li>
                <?php */ ?>
                <li class="dropdown user user-menu">
                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                        <?php /* ?><img src="<?php echo site_url('assets/images/avatar5.png');?>" class="user-image" alt="User Image"/><?php */ ?>
                        <span><?php echo $this->session->userdata('username'); ?></span>
                    </a>
                    <ul class="dropdown-menu" style="width:100%;">
                        <?php /* ?>
                        <li><a href="<?php echo site_url('admin/account/profile'); ?>">Profile</a></li>
                        <?php */ ?>
                        <li><a href="<?php echo site_url('admin/account/change_password'); ?>">Change Password</a></li>
                        <li><a href="<?php echo site_url("logout"); ?>">Sign out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
</nav>
</header>