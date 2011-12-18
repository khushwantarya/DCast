<div id="popup">
  <div id="popupcontent">
		<h1>Update Profile</h1>
		<form name="editForm" id="editForm">
			<div>
				<table cellspacing="5" cellpadding="2" border="0" style="border-width: 0px;" id="">
					<tbody>
						<tr>
							<td valign="top" class="detailsviewheader">Username:</td>
							<td>
								<input type="text" style="width: 150px;" id="unique_id" size="30" value="<?php echo $user_array["User"]["unique_id"]; ?>" name="unique_id">
								<br />
								<small style="font-style: italic; color: rgb(255, 153, 0);">Choose non-identifying fun name for anonymity - ex. Mickey Mouse</small> 
							</td>
						</tr>
						<tr>
							<td valign="top" class="detailsviewheader">Password:</td>
							<td>
								<input type="password" style="width: 150px;" id="password" size="30" name="password">
								<span style="font-weight: bold;"> Confirm Password: </span>
								<input type="password" style="width: 150px;" id="confirm_password" size="30" name="confirm_password">
								<br />
								<span style="color: rgb(255, 153, 0); font-size: x-small; font-style: italic;">New password must contain at least 5 characters or numbers.</span> 
							</td>
						</tr>
						<tr>
							<td valign="top" class="detailsviewheader">Email Alerts:</td>
							<td><table border="0" id="ctl00_main_UserInfo_EmailAlerts">
									<tbody>
										<tr>
											<td><input type="radio" value="1" name="email_alerts" id="email_alerts1" <?php if($user_array["User"]["email_alerts"] == 1) { echo "checked='checked'"; } ?> />
												<label for="email_alerts1">On</label></td>
											<td><input type="radio" checked="checked" value="0" name="email_alerts" id="email_alerts0"<?php if($user_array["User"]["email_alerts"] == 0) { echo "checked='checked'"; } ?> />
												<label for="email_alerts0">Off</label></td>
										</tr>
									</tbody>
								</table>
								<span style="color: rgb(255, 153, 0); font-size: x-small; font-style: italic;">Receive an email when someone builds off your idea, asks you a question, you win awards, your keywords used.</span> </td>
						</tr>
						<tr>
							<td valign="top" class="detailsviewheader">Avatar:</td>
							<td>
								<?php if(!empty($avatars_array)) { ?>
								<table cellpadding="1" border="0" style="font-size: 11px;" width="100%">
									<tbody>
										<tr>
											<?php  foreach($avatars_array as $k => $v) { ?>
											<td width="20%">
											
												<input type="radio" value="<?php echo $v["Avatar"]["id"]; ?>" name="avatar_id" id="avatar_<?php echo $v["Avatar"]["id"]; ?>" <?php if($user_array["User"]["avatar_id"] == $v["Avatar"]["id"]) { echo "checked='checked'"; } ?> />
												<label for="avatar_<?php echo $v["Avatar"]["id"]; ?>"><?php echo $v["Avatar"]["title"]; ?><br />
												
												<?php
													$avatar_image = "mini-avatar.png";
													$alt = "Avatar";
													if(isset($v["Avatar"]["image"]) && $v["Avatar"]["image"] != "")
													{
														$avatar_image = Configure::read('CV.avatar_browse_path') . $v["Avatar"]["image"];
														$alt = $v["Avatar"]["title"];
													}
													echo $this->Html->image($avatar_image, array("alt" => $alt, "width" => "45px"))
												?>
												
											</td>
												
											<?php if(($k+1)%5 == 0 && ($k+1) != 0) { echo "</tr><tr>"; } } ?>
										</tr>
									</tbody>
								</table>
								<?php } ?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div style="text-align: center; margin-top: 0px;">
				<?php echo $this->Form->submit("submit-orange.png", array("id" => "submit", "name" => "submit")); ?>
				
			</div>
		</form>
  </div>
</div>

<script language="javascript" type="text/javascript">
$(document).ready(function (){
	
	$("#submit").click(function(){
		//validate unique_id
		if($("#unique_id").val() == "")
		{
			alert("Please enter your Unique Username.");
			$("#unique_id").focus();
			return false;
		}
		
		if($("#password").length < 5)
		{
			alert("Password length must be equal to 5.");
			$("#password").focus();
			return false;
		}
		
		if($("#password").val() != $("#confirm_password").val())
		{
			alert("Password and Confirm Password must be identical.");
			$("#password").val("");
			$("#confirm_password").val("");			
			$("#password").focus();
			return false;
		}
		
		//send ajax request to update the profile 
		$.ajax({
			type: "POST",
			url: "<?php echo $this->Html->url(array("controller" => "users","action" => "edit"));?>",
			data: "unique_id=" + unique_id + "&password=" + password + "&confirm_password=" + confirm_password + "&email_alerts=" + $("#email_alerts").val() + "&avatar_id=" + $("#avatar_id").val(),
			success: function(data){
				//alert(data);
				$(thisobj).html(data);
				$(thisobj).removeClass("favorite_idea");
				//actions();
			}
		});
		
		alert("clicked");
	});

});
</script>