<?php echo sprintf(__('Hello %s', true), $user['User']['first_name']); ?>,

<?php
    $url = Router::url(array(
        'controller' => 'users',
        'action' => 'activate',
        $user['User']['username'],
        $user['User']['activation_key'],
    ), true);
    echo sprintf(__('Please visit this link to activate your account: %s', true), $url);
?>	
<p>
	<b>Note:</b> Alternatively, if the link does not work please copy and paste the following URL into your browser's address bar.<br />
	Once activated then enter your Username (demo-ajeetkhandelwal) and Password in the login box .
</p>
