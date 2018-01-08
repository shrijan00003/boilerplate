<?php $uri = explode("/", $this->uri->uri_string()); ?>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <?php $css = (!isset($uri[1])) ? 'class="active"' : ''; ?> 
            <li <?php echo $css;?>>
                <a href="<?php echo site_url('admin'); ?>">
                    <i class="fa fa-dashboard"></i> <span><?php echo lang('menu_dashboard'); ?></span>
                </a>
            </li>

            <?php if(control('System', FALSE)):?>
                <?php $css = (isset($uri[1]) && in_array($uri[1], array('users', 'groups', 'permissions'))) ? 'active' : ''; ?>
                <li class="treeview <?php echo $css; ?>">
                    <a href="javascript:void(0)">
                        <i class="fa fa-gear"></i>
                        <span><?php echo lang('menu_system'); ?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                         <?php if(control('Permissions', FALSE)):?>
                        <?php $css = (isset($uri[1]) && $uri[1] == 'permissions') ? 'class="active"' : ''; ?> 
                        <li <?php echo $css; ?>><a href="<?php echo site_url('admin/permissions')?>"><i class="fa fa-circle-o"></i><?php echo lang('menu_permissions');?></a></li>
                        <?php endif;?>
                        <?php if(control('Groups', FALSE)):?>
                        <?php $css = (isset($uri[1]) && $uri[1] == 'groups') ? 'class="active"' : ''; ?> 
                        <li <?php echo $css; ?>><a href="<?php echo site_url('admin/groups')?>"><i class="fa fa-circle-o"></i><?php echo lang('menu_groups');?></a></li>
                        <?php endif;?>
                        <?php if(control('Users', FALSE)):?>
                        <?php $css = (isset($uri[1]) && $uri[1] == 'users') ? 'class="active"' : ''; ?> 
                        <li <?php echo $css; ?>><a href="<?php echo site_url('admin/users')?>"><i class="fa fa-circle-o"></i><?php echo lang('menu_users');?></a></li>
                        <?php endif;?>
                    </ul>
                </li>
            <?php endif;?>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>