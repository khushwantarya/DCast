<?php
/**
 * Default Theme for Configure::read('Site.title') CMS
 *
 * @author khushwant
 * @link 
 */
//get the event detail if the event_id is set
//
$event_data = array();
if(isset($event_id))
{
	//echo $event_id;
	$event_data = $this->requestAction('/events/get_event/' . $event_id);
}
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title_for_layout; ?>&raquo;<?php echo Configure::read('Site.title'); ?></title>
<?php
		//echo $this->Html->meta('icon');
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
				'colorbox'
				
		));
		echo $this->Layout->js();
		echo $this->Html->script(array(
				'jquery/jquery.min',
				'jquery/jquery-ui-1.8.16.min',
				'jquery/jquery.cookie',
				'jquery/jquery.treeview',
				'general-function',
				'jquery/jquery.loadmask',
				'jquery/jquery.colorbox'
		));
		echo $scripts_for_layout;
?>
</head>
<body>
		<?php $this->Layout->sessionFlash(); ?>
		<?php  echo $content_for_layout; ?>
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
