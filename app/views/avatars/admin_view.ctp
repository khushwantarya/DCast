<div class="roles form">
    <h2><?php echo $title_for_layout; ?></h2>
	
    <fieldset>
			<?php //pr($data); ?>
			<table width="95%" border="0" align="center" cellpadding="5" cellspacing="0">
			  <tr>
				<td width="20%" align="left" valign="top"></td>
				<td width="25%" align="left" valign="top">&nbsp;</td>
				<td width="1%" align="left" valign="top">&nbsp;</td>
				<td width="34%" align="left" valign="top">&nbsp;</td>
				<td width="20%" align="left" valign="top">
				
				<div class="actions">
					<ul>
						<li><?php echo $html->link("Edit Detail", array('action' => 'edit', $data["Avatar"]["id"]), array()); ?></li>
					</ul>
				</div>
				
				
				</td>
			  </tr>
			  <tr>
				<td align="left" valign="top"><strong>Name:</strong></td>
				<td align="left" valign="top"><?php echo $data["Avatar"]["name"]; ?></td>
				<td align="left" valign="top">&nbsp;</td>
				<td align="left" valign="top"><strong>Start Date: </strong></td>
				<td align="left" valign="top"><?php echo date("F d, Y", strtotime($data["Avatar"]["date_from"])); ?></td>
			  </tr>
			  <tr>
				<td align="left" valign="top"><strong>Organization Name: </strong></td>
				<td align="left" valign="top"><?php echo $data["Avatar"]["organization_name"]; ?></td>
				<td align="left" valign="top">&nbsp;</td>
				<td align="left" valign="top"><strong>End Date: </strong></td>
				<td align="left" valign="top"><?php echo date("F d, Y", strtotime($data["Avatar"]["date_to"])); ?></td>
			  </tr>
			  <tr>
				<td align="left" valign="top"><strong>Contact Name: </strong></td>
				<td align="left" valign="top"><?php echo $data["Avatar"]["contact_name"]; ?></td>
				<td align="left" valign="top">&nbsp;</td>
				<td align="left" valign="top"><strong>State time: </strong></td>
				<td align="left" valign="top"><?php echo $data["Avatar"]["time_from"]; ?></td>
			  </tr>
			  <tr>
				<td align="left" valign="top"><strong>Contact Email: </strong></td>
				<td align="left" valign="top"><?php echo $data["Avatar"]["contact_email"]; ?></td>
				<td align="left" valign="top">&nbsp;</td>
				<td align="left" valign="top"><strong>End time: </strong></td>
				<td align="left" valign="top"><?php echo $data["Avatar"]["time_to"]; ?></td>
			  </tr>
			  <tr>
				<td align="left" valign="top"><strong>Mobile:</strong></td>
				<td align="left" valign="top"><?php echo $data["Avatar"]["mobile"]; ?></td>
				<td align="left" valign="top">&nbsp;</td>
				<td align="left" valign="top">&nbsp;</td>
				<td align="left" valign="top">&nbsp;</td>
			  </tr>
			  <tr>
				<td align="left" valign="top"><strong>Phone:</strong></td>
				<td align="left" valign="top"><?php echo $data["Avatar"]["phone"]; ?></td>
				<td align="left" valign="top">&nbsp;</td>
				<td align="left" valign="top">&nbsp;</td>
				<td align="left" valign="top">&nbsp;</td>
			  </tr>
			  <tr>
				<td width="20%" align="left" valign="top"></td>
				<td width="25%" align="left" valign="top">&nbsp;</td>
				<td width="1%" align="left" valign="top">&nbsp;</td>
				<td width="34%" align="left" valign="top">&nbsp;</td>
				<td width="20%" align="left" valign="top">
				
				<div class="actions">
					<ul>
						<li><?php echo $html->link("Edit Detail", array('action' => 'edit', $data["Avatar"]["id"]), array()); ?></li>
					</ul>
				</div>
				
				</td>
			  </tr>
			</table>
			
    </fieldset>
</div>