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
		<div class="adminbox">
			<div class="box">
				<div class="leftside" id="leftside">
					<div>
						<?php
							$tag_colors_array = Configure::read('CV.tag_cloud_colors_array');
							// Initite the basic object
							$wordCloud->wordsArray = array();
							$wordCloud->wordCloud();
							foreach($cloud_array as $k => $v)
							{
								if($v > 0)
								{
									$wordCloud->addWord(array('word' => $k, 'size' => $v, 'url' => Router::url("/questions/side_list/" . $k)));
								}
							}
							$myCloud = $wordCloud->showCloud('array');
							
							foreach ($myCloud as $cloudArray) {
								echo ' &nbsp; <a href="'.$cloudArray['url'].'" style="color: '.$tag_colors_array[$cloudArray['range']].';" class="clouds size'.$cloudArray['range'].'">'.$cloudArray['word'].'</a> &nbsp;';
							}	
						?>
					</div>
				</div>
				<div class="rightside">
					<div>
						<div class="ideaskeywordbox">
							<div class="box2" id="cloud_idea_container">
								<div class="emptybox">Click on a word to view related ideas here</div>
							</div>
						</div>
					</div>
				</div>
				<div style="clear:both;"></div>
			</div>
		</div>
	</div>
	<div id="tabs-4">
		<div class="adminbox">
			<div class="box">
				<div class="leftside">
					<div>
						<?php
							$tag_colors_array = Configure::read('CV.tag_cloud_colors_array');
							// Initite the basic object
							$wordCloud->wordsArray = array();
							$wordCloud->wordCloud();
							foreach($tags_array as $k => $v)
							{
								$wordCloud->addWord(array('word' => $v["Tag"]["name"], 'size' => $v[0]["weight"], 'url' => Router::url("/questions/side_list/" . $v["Tag"]["id"])));
							}
							$myTags = $wordCloud->showCloud('array');
							
							foreach ($myTags as $cloudArray) {
								echo ' &nbsp; <a href="'.$cloudArray['url'].'" style="color: '.$tag_colors_array[$cloudArray['range']].';" class="tags size'.$cloudArray['range'].'">'.$cloudArray['word'].'</a> &nbsp;';
							}	
						?>
					</div>
				</div>
				<div class="rightside">
					<div>
						<div class="ideaskeywordbox">
							<div class="box2" id="tag_idea_container">
								<div class="emptybox">Click on a word to view related ideas here</div>
							</div>
						</div>
					</div>
				</div>
				<div style="clear:both;"></div>
			</div>
		</div>
	</div>
	<div id="tabs-5">
		<div class="box" style="background: #FFF;">
			<table width="100%">
				<tbody>
					<tr>
						<td style="width: 100%;">
						
							<div id="center-container">
									<div id="infovis"></div>    
							</div>
							<div id="right-container">
								<div id="inner-details"></div>
							</div>
							<div id="log"></div>
						</td>
					</tr>
					<tr> </tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php echo $this->Js->writeBuffer(); ?>
<script language="javascript" type="text/javascript">
json = $.parseJSON('<?php echo $idea_map_array; ?>');

function other_function()
{
	$(".favorite_idea").click(function(){
		var thisobj = this;
		//alert($(this).parent().attr("id"));
		var idea_id_array = $(this).attr("id").split("<?php echo Configure::read("CV.fields_separator"); ?>");
		var idea_id = idea_id_array[1];
		var post_fix = "<?php echo Configure::read("CV.fields_separator"); ?>" + idea_id;
		$.ajax({
			type: "POST",
			url: "<?php echo $this->Html->url(array("controller" => "questions","action" => "favorite_idea"));?>",
			data: "idea_id=" + idea_id,
			success: function(data){
				//alert(data);
				$(thisobj).html(data);
				$(thisobj).removeClass("favorite_idea");
				//mouseover_actions();
				//actions();
			}
		});
	});
	$(".big_idea").click(function(){
		var thisobj = this;
		//alert($(this).parent().attr("id"));
		var idea_id_array = $(this).parent().attr("id").split("<?php echo Configure::read("CV.fields_separator"); ?>");
		var idea_id = idea_id_array[1];
		var post_fix = "<?php echo Configure::read("CV.fields_separator"); ?>" + idea_id;
		$.ajax({
			type: "POST",
			url: "<?php echo $this->Html->url(array("controller" => "questions","action" => "big_idea"));?>",
			data: "idea_id=" + idea_id,
			success: function(data){
				//alert(data);
				$(thisobj).html(data);

				//mouseover_actions();
				//actions();
			}
		});
	});
}


$(document).ready(function (){

	other_function();
  rgraph_init();
	open_color_box();
	$("#tabs").tabs({ cookie: { expires: 30 } });
	
	
	//get the  list of  the ideas for the  tags 
	$(".tags").click(function (e) {
		e.preventDefault();
		$.ajax({
			type: "POST",
			url: $(this).attr("href"),
			data: "list_for=tag",
			success: function(data){
				//alert(data);
				$("#tag_idea_container").html(data);
				other_function();
				open_color_box();
			}
		});		
	});
	
	//get the list of the ideas for the coulds entry 
	$(".clouds").click(function (e) {
		e.preventDefault();
		$.ajax({
			type: "POST",
			url: $(this).attr("href"),
			data: "list_for=idea",
			success: function(data){
				$("#cloud_idea_container").html(data);
				other_function();
				open_color_box();
			}
		});		
	});	
	
	//ajax call for sorting the data of the livestream section
	$("#live_stream_sort").change(function(){	
		$.ajax({
			type: "POST",
			url: "<?php echo $this->Html->url(array("controller" => "questions","action" => "view_idea")); ?>/tab:livestream/live_stream_sort:" + $(this).val(),
			data: "",
			success: function(data){
				$("#livestream_container").html(data);
			}
		});
	});
});

function open_color_box()
{
	$(".build_idea").colorbox({iframe:true, width:"750px", height:"490px;"});
	$(".view_profile").colorbox({iframe:true, width:"750px", height:"550px;"});
}
</script>

<?php } ?>