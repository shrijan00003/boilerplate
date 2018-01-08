<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $header . ' | ' . config_item('site_name'); ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

        <link rel="shortcut icon" href="<?php echo base_url("assets/icons/favicon.ico");?> " type="image/x-icon">

        <!-- Bootstrap Core CSS -->
        <link href="<?php echo site_url('assets/css/bootstrap/css/bootstrap.min.css');?>" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="<?php echo site_url('assets/css/bootstrap/css/modern-business.css');?>" rel="stylesheet">

        <link href="<?php echo site_url('assets/css/bootstrap/css/carousel.css');?>" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="<?php echo site_url('assets/css/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <script type="text/javascript">
        <!--
        var base_url = '<?php echo base_url();?>';
        var index_page = "";
        // -->
        </script>

    </head>
    
    <body>
        <!-- wrapper -->
        <div class="wrapper">
            <!-- header logo: style can be found in header.less -->
            <?php print $this->load->view($this->config->item('template_public') . 'header');?>

            <!-- Right side column. Contains the navbar and content of the page -->
            <?php print $this->load->view($this->config->item('template_public') . 'content');?>

            <!-- Footer -->
            <?php print $this->load->view($this->config->item('template_public') . 'footer');?>
        
        </div>  
        <!-- ./wrapper -->

        <!-- jQuery -->
        <script src="<?php echo site_url('assets/js/jquery-2.1.4.min.js');?>"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="<?php echo site_url('assets/js/bootstrap/bootstrap.min.js');?>"></script>

        <!-- Script to Activate the Carousel -->
        <script>
        $('.carousel').carousel({
            interval: 5000 //changes the speed
        })

        </script>
    </body>
</html>