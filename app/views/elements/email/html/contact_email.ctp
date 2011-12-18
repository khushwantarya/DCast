<?php echo sprintf(__('Hello %s', true), "Admin"); ?>,

<h2><?php echo __('An User send you a question/feedback as follows on ' . Configure::read('Site.title')); ?></h2>

<div><b>Contact Type:</b> <?php echo ucwords($data['post']['contact_type']); ?></div>
<div><b>comments:</b> <?php echo $data['post']['comments']; ?></div>

<p>
	User Detail who send this question/feedback as below. <br />
	
	<div><b>User name:</b> 
	
	<?php 
		if($data["user"]["User"]["unique_id"] != "")
		{
			echo $data["user"]["User"]["unique_id"];
		}
		else
		{
			echo $data["user"]["User"]["username"];
		}
	?>
	
	</div>
</p>
