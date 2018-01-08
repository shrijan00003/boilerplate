<?php
$files = array ('bootstrap/css/bootstrap.min.css', 
'font-awesome/css/font-awesome.min.css', 
'ionicons/css/ionicons.min.css', 
'adminlte/css/AdminLTE.min.css', 
'adminlte/css/AdminLTE-extended.css', 
'adminlte/css/skins/_all-skins.min.css',
'jqwidgets/jqx.base.css',
'jqwidgets/jqx.base.extended.css',
'jqwidgets/jqx.bootstrap.css',
'jqwidgets/jqx.office.css',
'partial-project.css');

$c = '';
$dir = dirname(__FILE__);
foreach ($files as $f) {
	$c .= file_get_contents($dir. "/" . $f);
	//print $c;
}

$h = fopen($dir .'/project.css', 'w');
fwrite($h, $c);
fclose($h);