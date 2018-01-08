<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>@TODO/ RETHINK TITLE</title>
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
        <script>
            //paste this code under head tag or in a seperate js file.
            // Wait for window load
            $(window).load(function() {
                // Animate loader off screen
                // setTimeout($(".se-pre-con").fadeOut("slow"), 10000);
                $(".se-pre-con").fadeOut("slow");;
            });
        </script>
    </head>
    
    <body class="sidebar-mini skin-green sidebar-collapse">
        <!-- Paste this code after body tag -->
        <div class="se-pre-con"></div>
        <!-- Ends -->

        <!-- wrapper -->
        <div class="wrapper">
        <!-- header logo: style can be found in header.less -->
        <?php $CI = & get_instance();?>
		<?php print $CI->load->view($CI->config->item('template_admin') . 'admin/header');?>

		<!-- Left side column. contains the logo and sidebar -->
		<?php print $CI->load->view($CI->config->item('template_admin') . 'menu');?>

		<!-- Right side column. Contains the navbar and content of the page -->
		<?php print $CI->load->view($CI->config->item('template_admin') . 'content');?>


		<?php print $CI->load->view($CI->config->item('template_admin') . 'footer');?>

        
        </div>  
        <!-- ./wrapper -->

        <script type="text/javascript" src="<?php echo site_url('assets/js/jquery-2.1.4.min.js');?>"></script>
        <script type="text/javascript" src="<?php echo site_url('assets/js/project.min.js');?>"></script>

        <!-- DEMO PURPOSE -->
        <script type="text/javascript" src="<?php echo site_url('assets/js/adminlte2/pages/dashboard2.js');?>"></script>
        <script type="text/javascript" src="<?php echo site_url('assets/js/plugins/fastclick/fastclick.min.js');?>"></script>
        <script type="text/javascript" src="<?php echo site_url('assets/js/plugins/sparkline/jquery.sparkline.min.js');?>" ></script>
        <script type="text/javascript" src="<?php echo site_url('assets/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js');?>"></script>
        <script type="text/javascript" src="<?php echo site_url('assets/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js');?>"></script>
        <script type="text/javascript" src="<?php echo site_url('assets/js/plugins/slimScroll/jquery.slimscroll.min.js');?>"></script>
        <script type="text/javascript" src="<?php echo site_url('assets/js/plugins/chartjs/Chart.min.js');?>"></script>
        <script type="text/javascript" src="<?php echo site_url('assets/js/adminlte2/demo.js');?>"></script>
        <!-- DEMO PURPOSE ENDS -->
    </body>
</html>