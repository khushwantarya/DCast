<div class="users form">
    <h2><?php __('Login'); ?></h2>
    <?php echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'forgot')));?>
		<table width="350" border="0" cellspacing="4" cellpadding="2">
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
				<td>&nbsp;</td>
				<td><?php echo $this->Form->end('Login');?></td>
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