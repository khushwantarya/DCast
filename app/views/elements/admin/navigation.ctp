<?php
//get all the roles by request Action
//echo $this->requestAction(array('controller' => 'roles', 'action' => 'get_roles', $deal_slug, $count), array('return'));
//$roles = $this->requestAction(array('controller' => 'roles', 'action' => 'admin_get_roles'));
$roles = $this->requestAction('/admin/roles/get_roles/');

?>

<div id="nav">
  <ul class="sf-menu">
    <li> <?php echo $this->Html->link(__('Events', true), array('plugin' => null, 'controller' => 'events', 'action' => 'view')); ?>
      <ul>
        <li><?php echo $this->Html->link(__('Events', true), array('plugin' => null, 'controller' => 'events', 'action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('New Event', true), array('plugin' => null, 'controller' => 'events', 'action' => 'add')); ?></li>
      </ul>
    </li>
    <!-- <li> <?php echo $this->Html->link(__('Questions', true), array('plugin' => null, 'controller' => 'questions', 'action' => 'index')); ?>
      <ul>
        <li><?php echo $this->Html->link(__('Questions', true), array('plugin' => null, 'controller' => 'questions', 'action' => 'index')); ?></li>
        <li><?php echo $this->Html->link(__('New Question', true), array('plugin' => null, 'controller' => 'questions', 'action' => 'add')); ?></li>
      </ul>
    </li> -->
    <li>
    <?php echo $this->Html->link(__('Users', true), array('plugin' => null, 'controller' => 'users', 'action' => 'index')); ?>
    <ul>
      <?php foreach($roles as $rk => $rv) { ?>
     	 <li><?php echo $this->Html->link(__($rv, true), array('plugin' => null, 'controller' => 'users', 'action' => 'index', $rk)); ?></li>
      <?php } ?>
      <li><?php echo $this->Html->link(__('Add New User', true), array('plugin' => null, 'controller' => 'users', 'action' => 'add')); ?></li>
	  <li><?php echo $this->Html->link(__('Invite Bulk Users', true), array('plugin' => null, 'controller' => 'users', 'action' => 'bulk_invite')); ?></li>
      <!-- <li><?php echo $this->Html->link(__('Roles', true), array('plugin' => null, 'controller' => 'roles', 'action' => 'index')); ?> </li>
      <li><?php echo $this->Html->link(__('Permissions', true), array('plugin' => 'acl', 'controller' => 'acl_permissions', 'action' => 'index')); ?></li>
      -->
    </ul>
    </li>
    <li>
    <?php echo $this->Html->link(__('Settings', true), array('plugin' => null, 'controller' => 'settings', 'action' => 'prefix', 'Site')); ?>
    <ul>
      <!-- <li><?php echo $this->Html->link(__('Other Site Settings', true), array('plugin' => null, 'controller' => 'sitedetails', 'action' => 'edit')); ?></li> -->
      <li><?php echo $this->Html->link(__('Site', true), array('plugin' => null, 'controller' => 'settings', 'action' => 'prefix', 'Site')); ?></li>
      <!--  <li><?php echo $this->Html->link(__('Meta', true), array('plugin' => null, 'controller' => 'settings', 'action' => 'prefix', 'Meta')); ?></li>
      <li><?php echo $this->Html->link(__('Reading', true), array('plugin' => null, 'controller' => 'settings', 'action' => 'prefix', 'Reading')); ?></li>
      <li><?php echo $this->Html->link(__('Writing', true), array('plugin' => null, 'controller' => 'settings', 'action' => 'prefix', 'Writing')); ?></li>
      <li><?php echo $this->Html->link(__('Comment', true), array('plugin' => null, 'controller' => 'settings', 'action' => 'prefix', 'Comment')); ?></li>
      <li><?php echo $this->Html->link(__('Service', true), array('plugin' => null, 'controller' => 'settings', 'action' => 'prefix', 'Service')); ?></li>
      <li><?php echo $this->Html->link(__('Languages', true), array('plugin' => null, 'controller' => 'languages', 'action' => 'index')); ?></li>
      -->
    </ul>
    </li>
    <li> <?php echo $this->Html->link(__('Avatars', true), array('plugin' => null, 'controller' => 'avatars', 'action' => 'index')); ?>
      <ul>
        <li><?php echo $this->Html->link(__('Avatars', true), array('plugin' => null, 'controller' => 'avatars', 'action' => 'index')); ?></li>
        <li><?php echo $this->Html->link(__('New Avatar', true), array('plugin' => null, 'controller' => 'avatars', 'action' => 'add')); ?></li>
      </ul>
    </li>
  </ul>
</div>
