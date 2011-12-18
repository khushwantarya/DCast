<h2><?php echo __("Search Results", true); ?></h2>
<div>
	<?php 
	if(!empty($data_array)) 
	{ 
		foreach($data_array as $k => $v)
		{
	?>
		<div class="search_list"><?php echo $this->Html->link(__($v["Idea"]["idea"], true), "/questions/build_idea/" . $v["Idea"]["id"], array("title" => "Build on Idea", "class" => "build_idea")); ?></div>
	<?php 
		} 
	}
	else
	{
		echo "Your search did not result in any similar ideas. Please complete your idea, then click the Submit button to share your idea.";
	}
	?>
</div>