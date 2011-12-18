<div id="popup">
  <div id="popupcontent">
    <h1><?php echo __(ucwords($title_for_layout), true); ?></h1>
    <div style="float: left; width: 300px;"> <strong><?php echo __("Points", true); ?>:</strong> <span><?php echo __($data["User"]["points"], true); ?></span><br />
			<br />
			<strong>Ideas Marked Favorite:</strong> 
			<span>
			<?php 
				if(isset($data["User"]["favorite_ideas_count"])) 
				{
					echo $data["User"]["favorite_ideas_count"];
				}
			?>
			</span> times<br />
			<br />
      <table>
        <tbody>
          <tr>
						<td width="59" height="36" align="center"><strong>Awards:</strong></td>
						<td class="award">
							<div>
								<?php echo $this->Html->image("award-outlier-idea.png", array("alt" => "Outlier Award", "width" => "52", "height" => "36")); ?>
								<?php echo $this->Html->link($data["User"]["big_ideas_count"], "/", array("class" => "")); ?>
							</div>
						</td>
						<td class="award">
						
							<?php if($data["User"]["points"] >= 100 && $data["User"]["points"] < 500) { ?>
								<div><?php echo $this->Html->image("award-novice.png", array("alt" => "Novice", "width" => "29", "height" => "36")); ?></div>
							<?php } else if($data["User"]["points"] >= 500 && $data["User"]["points"] < 1500) { ?>
								<div><?php echo $this->Html->image("award-pro.png", array("alt" => "Pro", "width" => "24", "height" => "36")); ?></div>
							<?php } else if($data["User"]["points"] >= 1500 && $data["User"]["points"] < 3500) { ?>
								<div><?php echo $this->Html->image("award-expert.png", array("alt" => "Expert", "width" => "29", "height" => "36")); ?></div>
							<?php } else if($data["User"]["points"] >= 3500) { ?>
								<div><?php echo $this->Html->image("award-genius.png", array("alt" => "Expert", "width" => "29", "height" => "36")); ?></div>
							<?php } ?>
						
						</td>
						<td class="award"></td>
						<td class="award"></td>
          </tr>
        </tbody>
      </table>
      <br />
      <br />
      <strong>Ideas Played:</strong>
			<span>
				<?php 
					if(isset($data["User"]["idea_count"])) 
					{
						echo $data["User"]["idea_count"];
					}
				?>
			</span>
			
			<br />
      <br />
			<?php
				$avatar_image = "mini-avatar.png";
				if(isset($data["Avatar"]["image"]) && $data["Avatar"]["image"] != "")
				{
					$avatar_image = Configure::read('CV.avatar_browse_path') . $data["Avatar"]["image"];
				}
				echo $this->Html->image($avatar_image, array("alt" => "Avatar"))
			?>
		</div>
    <div style="float: right; width: 300px;">
      <div style="margin-top: -15px;" id="tabs">
        <ul>
          <li><a href="#tabs-1">Questions</a></li>
          <li><a href="#tabs-2">Ideas</a></li>
          <li><a href="#tabs-3">Favorites</a></li>
        </ul>
        <div id="tabs-1">
          <div class="box">
						<?php if(!empty($questions_array)) { ?>
						<ul class="ideas">
							<?php foreach($questions_array as $qk => $qv) { ?>
							<li>
								<div class="idea">
									<div class="idealeft"> 
										
									
										<?php
											$number_image = $ideatree->get_qi_image($qv);
											echo $number_image;
											$favorite_idea = '<a class="favorite_idea" id="favorite_idea' . Configure::read("CV.fields_separator") . $qv["Idea"]["id"] . '">' . $this->Html->image("icon-grey-star.png", array("alt" => "Mark Favorite")) . '</a>';
											if(isset($qv["UsersFavoriteIdea"]["id"]) && ($qv["UsersFavoriteIdea"]["id"] > 0))
											{
												$favorite_idea = '<a>' . $this->Html->image("icon-yellow-star.png", array("alt" => "Mark Favorite")) . '</a>';
											}					
										?>
										<div class="favorite"><a><?php echo $favorite_idea; ?></a></div>
									</div>
									<div class="idearight">
									
										<?php echo $this->Html->link($qv["Idea"]["idea"], "/questions/build_idea/" . $qv["Idea"]["id"], array("title" => "Build on Idea", "class" => "build_idea hyperlink2")); ?>
										<div class="submittedby"> 
											<?php echo $ideatree->calc_duration($qv["Idea"]["created"]); ?> by 
											<?php echo $ideatree->set_user_profile_link($qv, "no"); ?>
										</div>
									</div>
								</div>
							</li>
							<?php } ?>
						</ul>
						<?php } else {  ?>
							<ul>
								<li style="padding: 10px;">There is no question.</li>
							</ul>
						<?php } ?>
          </div>
        </div>
        <div id="tabs-2">
          <div class="box">
						<?php if(!empty($ideas_array)) { ?>
						<ul class="ideas">
							<?php foreach($ideas_array as $qk => $qv) { ?>
							<li>
								<div class="idea">
									<div class="idealeft">
										<?php
											$number_image = $ideatree->get_qi_image($qv);
											echo $number_image;
											$favorite_idea = '<a class="favorite_idea" id="favorite_idea' . Configure::read("CV.fields_separator") . $qv["Idea"]["id"] . '">' . $this->Html->image("icon-grey-star.png", array("alt" => "Mark Favorite")) . '</a>';
											if(isset($qv["UsersFavoriteIdea"]["id"]) && ($qv["UsersFavoriteIdea"]["id"] > 0))
											{
												$favorite_idea = '<a>' . $this->Html->image("icon-yellow-star.png", array("alt" => "Mark Favorite")) . '</a>';
											}					
										?>
										<div class="favorite"><a><?php echo $favorite_idea; ?></a></div>
									</div>
									<div class="idearight">
										<?php echo $this->Html->link($qv["Idea"]["idea"], "/questions/build_idea/" . $qv["Idea"]["id"], array("title" => "Build on Idea", "class" => "build_idea hyperlink2")); ?>
										<div class="submittedby"> 
											<?php echo $ideatree->calc_duration($qv["Idea"]["created"]); ?> by 
											<?php echo $ideatree->set_user_profile_link($qv, "no"); ?>
										</div>
									</div>
								</div>
							</li>
							<?php } ?>
						</ul>
						<?php } else {  ?>
							<ul>
								<li style="padding: 10px;">There is no idea.</li>
							</ul>
						<?php } ?>
          </div>
        </div>
        <div id="tabs-3">
          <div class="box">
						<?php if(!empty($favorites_array)) { ?>
						<ul class="ideas">
							<?php foreach($favorites_array as $qk => $qv) { ?>
							<li>
								<div class="idea">
									<div class="idealeft"> 								
										<?php
											$number_image = $ideatree->get_qi_image($qv);
											echo $number_image;
											$favorite_idea = '<a class="favorite_idea" id="favorite_idea' . Configure::read("CV.fields_separator") . $qv["Idea"]["id"] . '">' . $this->Html->image("icon-grey-star.png", array("alt" => "Mark Favorite")) . '</a>';
											if(isset($qv["UsersFavoriteIdea"]["id"]) && ($qv["UsersFavoriteIdea"]["id"] > 0))
											{
												$favorite_idea = '<a>' . $this->Html->image("icon-yellow-star.png", array("alt" => "Mark Favorite")) . '</a>';
											}					
										?>
										<div class="favorite"><a><?php echo $favorite_idea; ?></a></div>
									</div>
									<div class="idearight">
									
										<?php echo $this->Html->link($qv["Idea"]["idea"], "/questions/build_idea/" . $qv["Idea"]["id"], array("title" => "Build on Idea", "class" => "build_idea hyperlink2")); ?>
										<div class="submittedby"> 
											<?php echo $ideatree->calc_duration($qv["Idea"]["created"]); ?> by 
											<?php echo $ideatree->set_user_profile_link($qv, "no"); ?>
										</div>
									</div>
								</div>
							</li>
							<?php } ?>
						</ul>
						<?php } else {  ?>
							<ul>
								<li style="padding: 10px;">There is no favorite item.</li>
							</ul>
						<?php } ?>
          </div>
        </div>
      </div>
    </div>
    <div class="clear"></div>
  </div>
</div>
<script language="javascript" type="text/javascript">
$(document).ready(function (){
	$("#tabs").tabs({ cookie: { expires: 30 } });
	//open_color_box();
});


function open_color_box()
{
	if($(".build_idea").length > 0)
	{
		$(".build_idea").colorbox({iframe:true, width:"750px", height:"550px;"});
	}
	if($(".build_idea").length > 0)
	{
		$(".view_profile").colorbox({iframe:true, width:"750px", height:"550px;"});
	}
}
</script>