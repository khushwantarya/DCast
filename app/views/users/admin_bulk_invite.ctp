<div class="users form">
    <h2><?php __('Add User'); ?></h2>
    <?php echo $this->Form->create('User');?>
    <fieldset>
        <div class="tabs">
            <ul>
                <li><a href="#user-main"><?php __('User'); ?></a></li>
                <?php echo $this->Layout->adminTabs(); ?>
            </ul>

            <div id="user-main">
            <?php
                echo $this->Form->input('role_id');
				echo $this->Form->input('Event.event_id', array("type" => "select", "options" => $events));
                echo $this->Form->input('emails', array("type" => "textarea")) . "you can add multiple email ids with comma separated.";
                echo $this->Form->input('password');
            ?>
            </div>
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