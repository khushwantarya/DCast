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
						<li><?php echo $html->link("Edit Details", array('action' => 'edit', $data["Event"]["id"]), array()); ?></li>
					</ul>
				</div>				</td>
			  </tr>
			  <tr>
				<td align="left" valign="top"><strong>Name:</strong></td>
				<td align="left" valign="top"><?php echo $data["Event"]["name"]; ?></td>
				<td align="left" valign="top">&nbsp;</td>
				<td align="left" valign="top"><strong>Start Date: </strong></td>
				<td align="left" valign="top"><?php echo date("F d, Y", strtotime($data["Event"]["date_from"])); ?></td>
			  </tr>
			  <tr>
				<td align="left" valign="top"><strong>Organization Name: </strong></td>
				<td align="left" valign="top"><?php echo $data["Event"]["organization_name"]; ?></td>
				<td align="left" valign="top">&nbsp;</td>
				<td align="left" valign="top"><strong>End Date: </strong></td>
				<td align="left" valign="top"><?php echo date("F d, Y", strtotime($data["Event"]["date_to"])); ?></td>
			  </tr>
			  <tr>
				<td align="left" valign="top"><strong>Contact Name: </strong></td>
				<td align="left" valign="top"><?php echo $data["Event"]["contact_name"]; ?></td>
				<td align="left" valign="top">&nbsp;</td>
				<td align="left" valign="top"><strong>State time: </strong></td>
				<td align="left" valign="top"><?php echo $data["Event"]["time_from"]; ?></td>
			  </tr>
			  <tr>
				<td align="left" valign="top"><strong>Contact Email: </strong></td>
				<td align="left" valign="top"><?php echo $data["Event"]["contact_email"]; ?></td>
				<td align="left" valign="top">&nbsp;</td>
				<td align="left" valign="top"><strong>End time: </strong></td>
				<td align="left" valign="top"><?php echo $data["Event"]["time_to"]; ?></td>
			  </tr>
			  <tr>
				<td align="left" valign="top"><strong>Mobile:</strong></td>
				<td align="left" valign="top"><?php echo $data["Event"]["mobile"]; ?></td>
				<td align="left" valign="top">&nbsp;</td>
				<td align="left" valign="top"><strong>Phone:</strong></td>
				<td align="left" valign="top"><?php echo $data["Event"]["phone"]; ?></td>
			  </tr>
			  <tr>
				<td align="left" valign="top"><strong>Logo</strong></td>
				<td align="left" valign="top"><?php
					if(isset($data["Event"]["logo"]) && ($data["Event"]["logo"] != ""))
					{
						echo $this->Html->image(Configure::read('CV.logo_browse_path') . $data["Event"]["logo"], array("alt" => "", "width" => 100));
					}				
					?></td>
				<td align="left" valign="top">&nbsp;</td>
				<td align="left" valign="top"><strong>Event Information</strong></td>
				<td align="left" valign="top">
				
					<?php
					if(isset($data["Event"]["event_information"]) && ($data["Event"]["event_information"] != ""))
					{
						echo $this->Html->link("open file", Router::url("/" . Configure::read('CV.file_browse_path') . $data["Event"]["event_information"], true ), array("alt" => "", "target" => "_blank"), '', array("escape" => false));
					}				
					?>
				
				</td>
			  </tr>
			  <tr>
			      <td align="left" valign="top"><strong>Event Video</strong></td>
			      <td align="left" valign="top"><?php echo $data["Event"]["event_video"]; ?></td>
			      <td align="left" valign="top">&nbsp;</td>
			      <td align="left" valign="top"><strong>Video Text</strong></td>
			      <td align="left" valign="top"><?php echo $data["Event"]["video_text"]; ?></td>
		        </tr>
			  <tr>
			      <td align="left" valign="top"><strong>DC Quick Tips</strong></td>
			      <td align="left" valign="top"><?php echo $data["Event"]["dc_quick_tips"]; ?></td>
			      <td align="left" valign="top">&nbsp;</td>
			      <td align="left" valign="top"><strong>Summary</strong></td>
			      <td align="left" valign="top"><?php echo $data["Event"]["summary"]; ?></td>
		        </tr>
			  <tr>
				<td width="20%" align="left" valign="top"></td>
				<td width="25%" align="left" valign="top">&nbsp;</td>
				<td width="1%" align="left" valign="top">&nbsp;</td>
				<td width="34%" align="left" valign="top">&nbsp;</td>
				<td width="20%" align="left" valign="top">
				
				<div class="actions">
					<ul>
						<li><?php echo $html->link("Edit Detail", array('action' => 'edit', $data["Event"]["id"]), array()); ?></li>
					</ul>
				</div>				</td>
			  </tr>
			</table>
			
			<div style="margin: 20px 0 0 0;">
   				<h2>Event's Questions</h2>
				<table cellpadding="0" cellspacing="0">
					<tr>
						<th><?php echo __('id'); ?></th>
						<th><?php echo __('title'); ?></th>
						<th><?php echo __('keyword'); ?></th>
						<th><?php echo __('status'); ?></th>
					</tr>
				<?php
	
					$rows = array();	
					foreach ($data["Question"] as $question) {
						$rows[] = array(
							$question['id'],
							$question['title'],
							$question['keyword'],			
							$question['status'],
						);
					}
			
					echo $this->Html->tableCells($rows);
				?>
				</table>
			</div>
			
			
    </fieldset>
</div>