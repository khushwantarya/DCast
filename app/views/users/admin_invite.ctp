<style>
.checkbox {
	width: 200px;
	float: left;
}
.checkbox input{
	width: 25px;
	float: left;
	margin: 10px 0 0 0;
}

.checkbox label{
	width: 160px;
	float: left;
}
</style>
<div class="users form">
    <h2><?php __('Invite Users'); ?></h2>
    <?php echo $this->Form->create('User');?>
    <fieldset>
        <div class="tabs">
            <ul>
                <li><a href="#user-main"><?php __('User'); ?></a></li>
                <?php echo $this->Layout->adminTabs(); ?>
            </ul>

            <div id="user-main">
            <?php
                echo $this->Form->input('users', array("multiple" => "checkbox"));
								echo "<div style='clear: both;'></div>";
                echo $this->Form->input('subject');
                echo $this->Form->input('message', array("type" => "textarea"));
            ?>
            </div>
            <?php echo $this->Layout->adminTabs(); ?>
        </div>
    </fieldset>

    <div class="buttons">
    <?php
        echo $this->Form->end(__('Send Invite', true));
        /*echo $this->Html->link(__('Cancel', true), array(
            'action' => 'index',
        ), array(
            'class' => 'cancel',
        ));*/
    ?>
    </div>
</div>