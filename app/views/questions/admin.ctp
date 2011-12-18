<h1>Administration</h1>
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Idea Type</a></li>
		<li><a href="#tabs-3">Award Ideas</a></li>
		<li><a href="#tabs-unaward">Untagged Ideas</a></li>
	</ul>
	<div id="tabs-1">
		<div class="box">
			<div> 
				<img src="<?php echo Router::url("/questions/bar_chart"); ?>" alt="Idea Bar Chart" />
			</div>
		</div>
	</div>
	<div id="tabs-3">
		<div class="box">
			<?php if(!empty($awarded_array)) { ?>
			<ul class="ideas">
				<?php foreach($awarded_array as $qk => $qv) { ?>
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
							<div class="ideascore"> <?php echo $qv["Idea"]["score"]; ?> </div>
							<?php echo $this->Html->link($qv["Idea"]["idea"], "/questions/build_idea/" . $qv["Idea"]["id"], array("title" => "Build on Idea", "class" => "build_idea hyperlink2 cboxElement")); ?>
							<div class="submittedby"> 
								<?php echo $ideatree->calc_duration($qv["Idea"]["created"]); ?> by 
								<?php echo $ideatree->set_user_profile_link($qv); ?>
							</div>
						</div>
					</div>
				</li>
				<?php } ?>
			</ul>
			<?php } else {  ?>
				<ul>
					<li style="padding: 10px;">There is no Awarded item.</li>
				</ul>
			<?php } ?>
		</div>
	</div>
	<div id="tabs-unaward">
		<div class="box">
			<?php if(!empty($untagged_array)) { ?>
			<ul class="ideas">
				<?php foreach($untagged_array as $qk => $qv) { if(empty($qv["IdeasTag"])) { ?>
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
							<div class="ideascore"> <?php echo $qv["Idea"]["score"]; ?> </div>
							<?php echo $this->Html->link($qv["Idea"]["idea"], "/questions/build_idea/" . $qv["Idea"]["id"], array("title" => "Build on Idea", "class" => "build_idea hyperlink2 cboxElement")); ?>
							<div class="submittedby"> 
								<?php echo $ideatree->calc_duration($qv["Idea"]["created"]); ?> by 
								<?php echo $ideatree->set_user_profile_link($qv); ?>
							</div>
						</div>
					</div>
				</li>
				<?php } } ?>
			</ul>
			<?php } else {  ?>
				<ul>
					<li style="padding: 10px;">There is no Untagged item.</li>
				</ul>
			<?php } ?>
		</div>
	</div>
</div>

<script language="javascript" type="text/javascript">
$(document).ready(function (){
	$("#tabs").tabs({ cookie: { expires: 30 } });
	
	open_color_box();
	
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
				//actions();
			}
		});
	});
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