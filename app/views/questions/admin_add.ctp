<style>
.date label{ 
	display: block;
}
.date select {
	width: 100px;
}
</style>
<div class="roles form">
    <h2><?php echo $title_for_layout; ?></h2>
    <?php echo $this->Form->create('Question', array("url" => array("action" => $action, "event_id" => $event_id)));?>
    <fieldset>
        <div class="tabs">
            <ul>
                <li><a href="#role-main"><span><?php __('Question'); ?></span></a></li>
                <?php echo $this->Layout->adminTabs(); ?>
            </ul>

            <div id="role-main">
            <?php
				echo $this->Form->input('event_id', array("value" => $event_id, "type" => "hidden"));	
				if($action == "edit")
				{
                	echo $this->Form->input('id');
				}
                echo $this->Form->input('title');
				echo $this->Form->input('keyword');
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