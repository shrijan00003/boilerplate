<?php if (isset($content)): ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1><?php echo lang('backendpro_system'); ?><small><?php echo lang('backendpro_settings'); ?></small></h1>
	</section>

	<!-- Main content -->
	<section class="content">
		<?php //print //displayStatus();?>
		<?php print $content; ?>
	</section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php endif; ?>


<?php
if( isset($page)) {
	if( isset($module)){
		$this->load->view($module.'/'.$page);
	} else {
		$this->load->view($page);
	}
}
?>