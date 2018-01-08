<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo config_item('site_name'); ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link rel="shortcut icon" href="<?php echo site_url("assets/icons/favicon.ico");?> " type="image/x-icon">

        <script type="text/javascript">
        <!--
        var base_url = '<?php echo site_url();?>';
        var index_page = "";
        // -->
        </script>

        <link href="<?php echo site_url('assets/css/project.min.css');?>" rel="stylesheet" type="text/css" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <script type="text/javascript" src="<?php echo site_url('assets/js/jquery-2.1.4.min.js');?>"></script>
    </head>
    
    <body class="login-page">

    <div class="login-box">
        <?php print form_open('auth')?>
        <div class="login-logo">
            <a href="<?php echo site_url('admin');?>"><?php echo config_item('site_name');?></a>
        </div><!-- /.login-logo -->

        <div class="login-box-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <?php //print displayStatus();?>
            <div class="form-group has-feedback">
                <input type="text" name="email" id="email" class="form-control" autocomplete="off" placeholder="<?php echo lang('general_username');?>" value="<?php echo set_value('email');?>" />
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" id="pass" name="pass" class="form-control" placeholder="<?php echo lang('general_password');?>"/>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <?php echo generate_recaptcha_field(); ?>
            </div>
            <div class="row">
                <div class="col-xs-8">    
                </div><!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>  
                </div><!-- /.col -->
            </div>
        <?php print form_close()?>
        <a href="<?php echo site_url('forgot_password');?>">Forgot Password</a><br>
        </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <script type="text/javascript" src="<?php echo site_url('assets/js/project.min.js');?>"></script>
</body>
</html>