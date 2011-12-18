<?php echo sprintf(__('Hello %s', true), $user['User']['email']); ?>,

<?php
    $url = Router::url(array(
        'controller' => 'users',
        'action' => 'login'
    ), true);
    echo __('you have an invitation from ' . Configure::read('Site.title'));
	
	
	
	
?>	

your details to login is as follows

User name: <?php echo $user['User']['email']; ?>
Password: <?php echo $user['User']['password']; ?>

Please  go to the following URL, to login and join the event and share your ideas. <br />
<?php echo $url; ?>
