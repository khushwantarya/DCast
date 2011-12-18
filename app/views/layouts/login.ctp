<?php
/**
 * Default Theme for Configure::read('Site.title') CMS
 *
 * @author khushwant
 * @link 
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title_for_layout; ?>&raquo;<?php echo Configure::read('Site.title'); ?></title>
<?php
		echo $this->Html->meta('icon');
		echo $this->Layout->meta();
		echo $this->Layout->feed();
		echo $this->Html->css(array(
				'reset',
				'960',
				'style',
		));
		echo $this->Layout->js();
		echo $this->Html->script(array(
				'jquery/jquery.min',
				'jquery/jquery.hoverIntent.minified',
				'jquery/superfish',
				'jquery/supersubs',
				'theme',
		));
		echo $scripts_for_layout;
?>
</head>
<body>
<div id="wrapper">
	<div id="header">
		<div id="logo"> 
			<?php echo $html->link($html->image("imageslogo.png", array("alt" => "DiscoeryCast")), "/", array("title" => "Go to home", "escape" => false)); ?>
		</div>
		<div id="status">
			<h3>DiscoveryCast Login</h3>
		</div>
		<div id="clientlogo"> <img src="images/imagesclientlogo-sage.png" alt=""> </div>
	</div>
	<div id="middle">
		<div id="nav">
		&nbsp;
		</div>
		<div id="container">
			<div id="eventsummary">
				<div class="login_setup">
					<?php $this->Layout->sessionFlash(); ?>
					<?php echo $content_for_layout; ?>	
					
				</div>
			</div>
			<div id="copyright">
				Copyright &copy; 2011 <a href="http://www.discoverycast.com/" target="_blank">DiscoveryCast</a>, 
				Inc.&nbsp;&nbsp; 
			</div>
		</div>
	</div>
</div>
</body>
</html>
