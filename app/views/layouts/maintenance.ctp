<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo $this->Html->charset(); ?>
<title><?php echo $title_for_layout; ?></title>
<style>
p { text-align:center; font:bold 1.1em sans-serif; }
a { color:#444; text-decoration:none; }
a:hover { text-decoration: underline; color:#44E; }
</style>
<style type="text/css">
<!--
.style1 {
	font-size: 50px;
	font-family: "Courier New", Courier, monospace;
	font-weight: bold;
	color: #FF3399;
}
-->
</style>
</head>

<body>
<p><?php echo $this->Html->image('/img/undermaintenance.jpg'); ?></p>
<p><?php __('Site down for maintenance.'); ?></p>
<p><a href="http://www.testdiscoverycast.com">Discovery Cast</a></p>
</body>
</html>
<?php Configure::write('debug', 0); ?>