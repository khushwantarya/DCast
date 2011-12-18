<?php
	$navigation = array();
	$navigation["view_challenge"] = array("id" => "navbutton1", "class" => "navbutton", "url" => "/");
	$navigation["share_ideas"] = array("id" => "navbutton2", "class" => "navbutton", "url" => "/questions/share");
	$navigation["see_ideas"] = array("id" => "navbutton3", "class" => "navbutton", "url" => "/questions/view_idea");
	$navigation["help"] = array("id" => "navbutton4", "class" => "navbutton", "url" => "/home/help");
	$navigation["admin"] = array("id" => "navbutton5", "class" => "navbutton", "url" => "/questions/admin");
	$navigation["view_profile"] = array("id" => "navbutton6lit", "class" => "navbutton", "url" => "/users");
?>

<div id="nav">
  <ul id="menu">
  	<?php 
	foreach($navigation as $k => $nav) 
	{ 
		$id = $nav["id"];
		if(isset($active_tab) && $k == $active_tab)
		{
			$id = $nav["id"] . "active";
		}
	?>
	<li><?php echo $this->Html->link('', $nav["url"], array('class' => $nav["class"], 'id' => $id)); ?></li>
	<?php 
	} 
	?>

  </ul>
</div>