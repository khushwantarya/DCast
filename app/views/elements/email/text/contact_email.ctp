<?php echo sprintf(__('Hello %s', true), "Admin"); ?>,

<?php echo __('An User send you a question/feedback as follows on ' . Configure::read('Site.title')); ?>

Contact Type:<?php echo ucwords($data['post']['contact_type']); ?>
comments:<?php echo $data['post']['comments']; ?>


User Detail who send this question/feedback as below. 

User name:

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
