<?php
/**
 * Default Theme for Configure::read('Site.title') CMS
 *
 * @author khushwant
 * @link 
 */
//get the event detail if the event_id is set
//
$app_event_data = array();
if(isset($event_id))
{
	//echo $event_id;
	//$app_event_data = $this->requestAction('/events/get_event/' . $event_id);
}
 
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
				'jquery.treeview',
				/*'js-tree','jquery',*/
				'jquery-theme/jquery-custom',
				'jquery.loadmask',
				'colorbox',
				'wordcloud'
				
		));
		echo $this->Layout->js();
		echo $this->Html->script(array(
				'jquery/jquery.min',
				'jquery/jquery-ui-1.8.16.min',
				'jquery/jquery.cookie',
				'jquery/jquery.treeview',
				'general-function',
				'jquery/jquery.loadmask',
				'jquery/jquery.colorbox',
				'visualization/jit',
				'visualization/rgraph'
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
      <h3>Sage Commons Congress Ideation Space</h3>
      <hr>
      Status: <span class="highlight">POST-EVENT</span> | 
      
      Contributors: 
	  <span class="highlight">
		<?php
			//get this logo by the event_id
			if(!empty($app_event_data))
			{
				echo $app_event_data["users_count"];
			}
		?>
	  
	  </span> | 
      Ideas: 
	  <span class="highlight">
		<?php
			//get this logo by the event_id
			if(!empty($app_event_data))
			{
				echo $app_event_data["ideas_count"];
			}
		?> 
	  </span> 
	  <br>
      <div class="mTop5"> 
		  <?php echo $this->Html->link('DiscoveryCast for your Company', 'javascript:void(0);', array('title' => 'DiscoveryCast for your Company')); ?> | 
		  <?php echo $this->Html->link('Invite others to this event', 'javascript:void(0);', array('title' => 'Invite others to this event')); ?>
	  </div>
    </div>
	
	<div id="login"> 
		Welcome&nbsp;<strong><?php echo __($this->Session->read('Auth.User.username'), true); ?></strong>, 
		<?php echo $this->Html->link('Log-out', '/users/logout', array('title' => 'Logout')); ?>
		
		<div style="clear: both;"></div>
		<div id="clientlogo">
		<?php
			//get this logo by the event_id
			if(!empty($app_event_data))
			{
				if($app_event_data["logo"] != "")
				{
					echo $this->Html->image(Configure::read('CV.logo_browse_path') . $app_event_data["logo"], array("alt" => "Client Logo", "width" => "200px"));
				}
			}
		?>
		</div>
	</div>
	
  </div>
  <div id="middle">
  	<!-- start left navigatoin -->
		<?php echo $this->element(Configure::read('Config.front_element_path') . '/left_navigation'); ?>
	<!-- end left navigatoin -->

    <div id="container">
      <div id="content">
		<?php $this->Layout->sessionFlash(); ?>
		<?php  echo $content_for_layout; ?>
      </div>
      <div id="copyright">Copyright &copy; 2011 <a href="http://www.discoverycast.com/" target="_blank">DiscoveryCast</a>, Inc.&nbsp;&nbsp; </div>
    </div>
  </div>
</div>

<script language="javascript" type="text/javascript">
$(document).ready(function(){
	if($(".ui-widget-header").length > 0)
	$(".ui-widget-header").removeClass("ui-widget-header");
	if($(".ui-widget-content").length > 0)
	$(".ui-widget-content").removeClass("ui-widget-content");
});
</script>
  
</body>
</html>
