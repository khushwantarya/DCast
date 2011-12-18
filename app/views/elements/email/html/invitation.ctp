<?php echo sprintf(__('Hello %s', true), $user['User']['email']); ?>,

<?php
    $url = Router::url(array(
        'controller' => 'users',
        'action' => 'login'
    ), true);
?>

<h2><?php echo __('you have an invitation from ' . Configure::read('Site.title')); ?></h2>

<div>User name: <?php echo $user['User']['email']; ?></div>
<div>Password: <?php echo $user['User']['password']; ?></div>
<p>
	Please  go to the following URL, to login and join the event and share your ideas. <br />
	<?php echo $url; ?>
</p>
