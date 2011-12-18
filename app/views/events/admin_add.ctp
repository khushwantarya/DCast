<style>
.date label{ 
	display: block;
}
.date select {
	width: 100px;
}
.time label{ 
	display: block;
}
.time select {
	width: 50px;
}
</style>
<div class="roles form">
    <h2><?php echo $title_for_layout; ?></h2>
    <?php echo $this->Form->create('Event', array("action" => $action, "enctype" => "multipart/form-data"));?>
    <fieldset>
        <div class="tabs">
            <ul>
                <li><a href="#role-main"><span><?php __('Event'); ?></span></a></li>
                <?php echo $this->Layout->adminTabs(); ?>
            </ul>

            <div id="role-main">
            <?php	
				if($action == "edit")
				{
                	echo $this->Form->input('id');
				}
                echo $this->Form->input('name');
				echo $this->Form->input('organization_name');
                echo $this->Form->input('contact_name');
				echo $this->Form->input('contact_email');				
                echo $this->Form->input('mobile');
				echo $this->Form->input('phone');
				echo $this->Form->file('logo');
				
				if(isset($this->data["Event"]["logo"]) && ($this->data["Event"]["logo"] != ""))
				{
					echo $this->Form->input('old_logo', array("value" => $this->data["Event"]["logo"], "type" => "hidden"));
					echo $this->Html->image(Configure::read('CV.logo_browse_path') . $this->data["Event"]["logo"], array("alt" => "", "width" => "200px"));
				}
				echo $this->Form->input('event_video');				
				echo $this->Form->input('video_text');		
				echo $this->Form->input('dc_quick_tips');

				echo $this->Form->input('event_information', array("type" => "file"));	
				if(isset($this->data["Event"]["event_information"]) && ($this->data["Event"]["event_information"] != ""))
				{
					echo $this->Html->link("open file", Router::url("/" . Configure::read('CV.file_browse_path') . $this->data["Event"]["event_information"], true ), array("alt" => "", "target" => "_blank"), '', array("escape" => false));
				}
				echo $this->Form->input('summary');				
				echo $this->Form->input('date_from');		
				echo $this->Form->input('date_to');
				echo $this->Form->input('time_from');		
				echo $this->Form->input('time_to');
				
            ?>				
				<?php for($i=0; $i<=4; $i++) { ?>
				  <fieldset class="field_box">
					<legend>Question <?php echo $i+1; ?>:</legend>
					<?php 
						if(isset($this->data["Question"][$i]["id"]))
						{
							echo $this->Form->input('Question.' . $i . '.id', array("type" => "hidden"));
						}
						echo $this->Form->input('Question.' . $i . '.title');
						echo $this->Form->input('Question.' . $i . '.keyword');
					?>
				  </fieldset>	
				<?php } ?>
			  

            </div>
            <?php echo $this->Layout->adminTabs(); ?>
        </div>
    </fieldset>

    <div class="buttons">
    <?php
		if($action == "edit")
		{
			echo $this->Form->end(__('Update', true));
		}
		else
		{	
			echo $this->Form->end(__('Save', true));
		}
        
        echo $this->Html->link(__('Cancel', true), array(
            'action' => 'index',
        ), array(
            'class' => 'cancel',
        ));
    ?>
    </div>
</div>