<div class="users form">
    <h2><?php __('Login'); ?></h2>
    <?php echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'login')));?>
	<table width="350" border="0" cellspacing="4" cellpadding="2">
		<tr>
			<td colspan="2">Contact: 
			<a href="mailto:support@discoverycast.com">support@discoverycast.com</a><br />if you have any questions.</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2" class="highlight">Please log into the event below.</td>
		</tr>
		<tr>
			<td>Username</td>
			<td><?php echo $this->Form->input('username', array("label" => false)); ?></td>
		</tr>
		<tr>
			<td>Password</td>
			<td><?php echo $this->Form->input('password', array("label" => false)); ?></td>
		</tr>
		<tr>
			<td colspan="2"><span class="highlight">By logging in your are agreeing to our <?php echo $html->link(__('Terms and Conditions', true), "/", array("title" => __('Terms and Conditions', true))); ?>.</span></td>
		</tr>
		<tr>
			<td colspan="2">
				<table width="300" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td width="117"><?php echo $html->link(__('Forgot Password', true), array("controller" => "users", "action" => "forgot"), array("title" => "Login")); ?></td>
						<td width="183"><?php echo $this->Form->end('Login');?></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</table>
</div>