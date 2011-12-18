<?php
	if($ajax == "yes")
	{
		if($tab == "livestream")
		{
			 echo $this->element('khush/front/paging_ideas_list');
		}
	}
	else
	{
?>


<table width="100%" border="0">
	<tbody>
		<tr>
			<td style="width: 50%;"><h1>See Ideas</h1></td>
			<td style="width: 50%; text-align: right; vertical-align: middle;">
				<!-- <input id="srchBox" style="width: 200px; vertical-align: middle;">
				&nbsp;<a href="#" onclick="javascript:cbSearch()" style="vertical-align: middle;"><img src="images/search-orange.png" alt="Search" style="vertical-align: middle;"></a> -->
			</td>
		</tr>
	</tbody>
</table>

<div id="tabs">
	<ul>
		<li><a href="#tabs-1">LiveStream</a></li>
		<li><a href="#tabs-2">LeaderBoard</a></li>
		<li><a href="#tabs-3">WordCloud</a></li>
		<li><a href="#tabs-4">ExpertTags</a></li>
		<li><a href="#tabs-5">IdeaMap</a></li>
	</ul>
	
	<div id="tabs-1" style="position:relative;">
		<div id="livestreambox" class="box">
			<div style="display:none;">
				<input name="ctl00$main$RefreshIdeas" value="" id="ctl00_main_RefreshIdeas" type="submit">
			</div>
			<div>
				<div class="searchfields"> Order By:
					<select name="live_stream_sort" id="live_stream_sort">
						<option selected="selected" value="N">Newest</option>
						<option value="O">Oldest</option>
						<option value="H">Highest Score</option>
						<option value="S">Lowest Score</option>
					</select>
				</div>
				<div id="livestream_container">
					<?php echo $this->element('khush/front/paging_ideas_list'); ?>
				</div>
			</div>
		</div>
	</div>
	<div id="tabs-2">
		<div class="box">
			<div>
				<?php if(!empty($user_array)) { ?>
				<table class="ideas" border="0" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
							<th colspan="2"><span id="ctl00_main_LeaderBoard_lblUserHeader">User</span></th>
							<th style="text-align: center;"><span id="ctl00_main_LeaderBoard_lblIdeaCntHeader"># Ideas</span></th>
						</tr>
						<?php foreach($user_array as $uk => $uv) { ?>
						<tr>
							<td width="100" align="center">
							
							
							<?php
								$avatar_image = "mini-avatar.png";
								$alt = "Avatar";
								if(isset($uv["Avatar"]["image"]) && $uv["Avatar"]["image"] != "")
								{
									$avatar_image = Configure::read('CV.avatar_browse_path') . $uv["Avatar"]["image"];
									$alt = $uv["Avatar"]["title"];
								}
								echo $this->Html->image($avatar_image, array("alt" => $alt, "title" => $alt, "width" => 45))
							?>
							</td>
							<td valign="top">
							
							<span class="submittedbyname">
								<?php echo $ideatree->set_user_profile_link($uv); ?>
							</span> 
							
							</td>
							<td valign="top" class="ideascore"><?php echo $uv["User"]["idea_count"]; ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
				<?php } else { ?>
				<?php echo "There is no User found in this leaderboard."; ?>
				<?php } ?>
			</div>
		</div>
	</div>
	<div id="tabs-3">
		<div class="box">
			<div id="tab3">
				<div class="leftside" id="leftside">
					<div id="Div4">
						<div id="wordbox" class="tagbox"> 
						<a href="javascript:wordSelect('(financial:1')" style="font-weight: normal; font-size: 12px; color: rgb(17, 106, 174);">(financial</a> 
						<a href="javascript:wordSelect('acepto:2')" style="font-weight: normal; font-size: 12px; color: rgb(0, 0, 0);">acepto</a> 
						<a href="javascript:wordSelect('alpiste:2')" style="font-weight: normal; font-size: 12px; color: rgb(233, 0, 0);">alpiste</a> 
						<a href="javascript:wordSelect('amarillo:3')" style="font-weight: normal; font-size: 12px; color: rgb(45, 106, 0);">amarillo</a> 
						<a href="javascript:wordSelect('approach:2')" style="font-weight: normal; font-size: 12px; color: rgb(202, 140, 33);">approach</a>
						 </div>
					</div>
				</div>
				<div class="rightside">
					<div>
						<input name="ctl00$main$searchHidden" id="ctl00_main_searchHidden" type="hidden">
						<div>
							<div class="box2">
								<div class="">Click on a word to view related ideas here</div>
							</div>
						</div>
					</div>
				</div>
				<div style="clear:both;"></div>
				If Word Cloud does not appear, <a href="http://www.microsoft.com/silverlight/get-started/install/default.aspx" target="_blank">install Microsoft Silverlight</a>. </div>
		</div>
	</div>
	<div id="tabs-4">
		<div class="adminbox">
			<div aria-hidden="true" role="status" id="ctl00_main_UpdateProgress2" style="display:none;">
				<div style="position:absolute; top:160px; left:300px; z-index:10;"> <img src="images/ajax-loader.gif" alt="Refreshing"> </div>
			</div>
			<div class="box">
				<div id="Div1">
					<div class="leftside" id="Div2">
						<div id="Div3">
							<div id="tagContainer" class="tagbox"> <a href="javascript:expertTagSelect('first')" style="font-weight: normal; font-size: 18px; color: rgb(17, 106, 174);">first</a> <a href="javascript:expertTagSelect('second')" style="font-weight: normal; font-size: 18px; color: rgb(0, 0, 0);">second</a> <a href="javascript:expertTagSelect('tag')" style="font-weight: normal; font-size: 18px; color: rgb(233, 0, 0);">tag</a> <a href="javascript:expertTagSelect('this%20is%20keyword')" style="font-weight: normal; font-size: 24px; color: rgb(45, 106, 0);">this is keyword</a> <a href="javascript:expertTagSelect('this%20is%20my%20tag')" style="font-weight: normal; font-size: 24px; color: rgb(202, 140, 33);">this is my tag</a> </div>
						</div>
					</div>
					<div class="rightside">
						<div id="ctl00_main_PanelExpertWc">
							<input name="ctl00$main$expertHidden" id="ctl00_main_expertHidden" type="hidden">
							<div class="ideaskeywordbox">
								<div class="box2">
									<div class="emptybox">Click on a word to view related ideas here</div>
								</div>
							</div>
						</div>
					</div>
					<div style="clear:both;"></div>
				</div>
			</div>
		</div>
	</div>
	<div id="tabs-5">
		<div class="box" style="background: #FFF;">
			<div style="text-align:center; padding-left:10px; padding-top:10px;"> <img src="images/ideamap.png" alt="Expand and Zoom"> </div>
			<div style="clear:both;"></div>
			<table>
				<tbody>
					<tr>
						<td style="width: 500px;"><ul style="margin-top:2px;">
								<li>Idea Map requires <a href="http://www.microsoft.com/silverlight/get-started/install/default.aspx" target="_blank">Microsoft Silverlight</a></li>
								<li>Idea Map updates every minute. Check back often to see how it grows.</li>
							</ul></td>
						<td style="width: 120px;"><div style="text-align:center;"> <a href="http://app.discoverycast.com/IdeaMap.aspx" target="_blank"><img src="images/ideamap.jpg" onmouseover="this.src='images/ideamap_on.jpg';" onmouseout="this.src='images/ideamap.jpg';" alt="Start Idea Map"></a> </div></td>
					</tr>
					<tr> </tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php echo $this->Js->writeBuffer(); ?>
<script language="javascript" type="text/javascript">
$(document).ready(function (){
	open_color_box();
	$("#tabs").tabs({ cookie: { expires: 30 } });
	
	
	//ajax call for sorting the data of the livestream section
	$("#live_stream_sort").change(function(){	
		$.ajax({
			type: "POST",
			url: "<?php echo $this->Html->url(array("controller" => "questions","action" => "view_idea")); ?>/tab:livestream/live_stream_sort:" + $(this).val(),
			data: "",
			success: function(data){
				$("#livestream_container").html(data);
				//$(thisobj).html(data);
				//$(thisobj).removeClass("favorite_idea");
				//actions();
			}
		});
	});
});

function open_color_box()
{
	$(".build_idea").colorbox({iframe:true, width:"750px", height:"550px;"});
	$(".view_profile").colorbox({iframe:true, width:"750px", height:"550px;"});
}
</script>

<?php } ?>