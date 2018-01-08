<?php
$files = array (
'jquery-2.1.4.min.js',
'jquery.cookie.js',
'date.js',
'bootstrap/bootstrap.min.js',
'adminlte2/adminlte.js',
'jqwidgets/jqx-all.js',
'jqwidgets/globalization/globalize.js',
'jquery.blockUI.js',
'partial-project.js',
);

$c = '';
$dir = dirname(__FILE__);
foreach ($files as $f) {
	$c .= file_get_contents($dir. "/" . $f);
}

$h = fopen($dir .'/project.js', 'w');
fwrite($h, $c);
fclose($h);