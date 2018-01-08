<?php
$exec = 'all';
if (isset($argv[1]) && $argv[1] == 'css') {
	$exec = 'css';
} elseif (isset($argv[1]) && $argv[1] == 'js') {
	$exec = 'js';
} elseif ((isset($argv[1]) && ($argv[1] != 'js' || $argv[1] != 'css')) || count($argv) > 2)  {
	print "Invalid Arugment";
	print "\r\nExiting...";
	exit;
}

print "\r\nStart\r\n\r\n";


if ($exec == 'all' || $exec == 'css') {
	$cmd  = "php ../assets/css/merge_css.php";
	print "Compressing Merging Multiple CSS files as 'project.css'\r\n\r\n";
	shell_exec($cmd);

	$input = "../assets/css/project.css";
	$output = "../assets/css/project.min.css";
	$cmd = "java -jar yuicompressor-2.4.8.jar {$input} -o {$output}";
	print "Minifying 'project.css' as 'project.min.css'\r\n\r\n";
	shell_exec($cmd);
}

if ($exec == 'all' || $exec == 'js') {
	$cmd  = "php ../assets/js/merge_js.php";
	print "Compressing Merging Multiple JS files as 'project.js'\r\n\r\n";
	shell_exec($cmd);

	$input = "../assets/js/project.js";
	$output = "../assets/js/project.min.js";
	$cmd = "java -jar yuicompressor-2.4.8.jar {$input} -o {$output}";
	print "Minifying 'project.js' as 'project.min.js'\r\n\r\n";
	shell_exec($cmd);
} 
print "Compeleted.........\r\n";

