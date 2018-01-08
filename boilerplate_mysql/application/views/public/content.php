<?php if (isset($content)): ?>

<!-- container -->
<div class="container">
	<?php print $content; ?>
</div>

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