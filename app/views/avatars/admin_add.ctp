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
    <?php echo $this->Form->create('Avatar', array("action" => $action, "enctype" => "multipart/form-data"));?>
    <fieldset>
        <div class="tabs">
            <ul>
                <li><a href="#role-main"><span><?php __('Avatars'); ?></span></a></li>
                <?php echo $this->Layout->adminTabs(); ?>
            </ul>

            <div id="role-main">
            <?php	
				if($action == "edit")
				{
                	echo $this->Form->input('id');
				}			
				echo $this->Form->file('image');
				
				if(isset($this->data["Avatar"]["image"]) && ($this->data["Avatar"]["image"] != ""))
				{
					echo $this->Form->input('old_image', array("value" => $this->data["Avatar"]["image"], "type" => "hidden"));
					echo $this->Html->image(Configure::read('CV.avatar_browse_path') . $this->data["Avatar"]["image"], array("alt" => "", "width" => "50"));
				}
				echo $this->Form->input('title');				
				echo $this->Form->input('desc', array("type" => "textarea"));
            ?>
            </div>
            <?php echo $this->Layout->adminTabs(); ?>
        </div>
    </fieldset>

    <div class="buttons">
    <?php
        echo $this->Form->end(__('Save', true));
        echo $this->Html->link(__('Cancel', true), array(
            'action' => 'index',
        ), array(
            'class' => 'cancel',
        ));
    ?>
    </div>
</div>