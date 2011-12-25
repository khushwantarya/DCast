<div id="popup">
  <div id="popupcontent">
    <div style="float: left; width: 300px;">
      <h1>Build On Idea</h1>
			
			<?php
				$number_image = $ideatree->get_qi_image($idea_array);
				
				//check for the big idea 
				$favorite_idea = '<a class="favorite_idea" id="favorite_idea' . Configure::read("CV.fields_separator") . $idea_array["Idea"]["id"] . '">' . $this->Html->image("icon-grey-star.png", array("alt" => "Mark Favorite")) . '</a>';
				if(isset($idea_array["UsersFavoriteIdea"]["id"]) && ($idea_array["UsersFavoriteIdea"]["id"] > 0))
				{
					$favorite_idea = '<a>' . $this->Html->image("icon-yellow-star.png", array("alt" => "Mark Favorite")) . '</a>';
				}
				
				$big_idea = $this->Html->image("award-outlier-idea-off.png", array("alt" => "Outlier", "style" => "height: 16px;"));
				if(isset($idea_array["UsersBigIdea"]["id"]) && ($idea_array["UsersBigIdea"]["id"] > 0))
				{
					$big_idea = $this->Html->image("award-outlier-idea.png", array("alt" => "Outlier", "style" => "height: 16px;"));
				}			
			?>
			
			<!-- start idea deatil section to show -->
      <div id="ideadetails">
        <div style="padding: 0px 25px;">
          <div style="height: 83px; overflow: auto;"> <?php echo $this->Html->link($idea_array["Idea"]["idea"], "/questions/build_idea/" . $idea_array["Idea"]["id"], array("title" => "Build on Idea", "class" => "hyperlink2")); ?> </div>
          <div style="height: 25px;">
            <div style="float: left; width: 25px;"> <?php echo $number_image; ?> </div>
            <div class="submittedby" style="float: left;"> 
							<?php echo $ideatree->calc_duration($idea_array["Idea"]["created"]); ?>
							by <?php echo $ideatree->set_user_profile_link($idea_array); ?>
						</div>
            <div class="clear"></div>
          </div>
          <div style="height: 20px;">
            <div style="float: left; width: 115px;"> 
								<div class="favorite">
									<?php echo $favorite_idea; ?> Mark Favorite
								</div>
						</div>
						<?php if($this->Session->read("Auth.User.role_id") != Configure::read('CV.role_regular')) { ?>
            <div style="float: left; margin-top: -4px;">
              <table>
                <tbody>
                  <tr>
                    <td>
											<div class="build_idea_big_idea" id="build_idea_big_idea<?php echo Configure::read("CV.fields_separator") . $idea_array["Idea"]["id"]; ?>">
												<a class="big_idea" title="Outlier Award"><?php echo $big_idea; ?></a> 
											</div>
										</td>
                  </tr>
                </tbody>
              </table>
            </div>
						<?php } ?>
            <div class="clear"></div>
          </div>
        </div>
      </div>
			<!-- end the idea detail section to show -->
			

			<!-- start the buttons of actions to take on idea -->
			<div class="build_idea_actions" id="build_idea_actions<?php echo Configure::read("CV.fields_separator") . $idea_array["Idea"]["id"]; ?>" style="margin-left: -7px; margin-right: -17px; margin-top: 5px; height: 30px;"> 
				<a class="buttonsm agree agree_idea buildon">Agree</a> 
				<a class="buttonsm disagree disagree_idea">Disagree</a> 
				<a class="buttonsm modify modify_idea">Modify</a> 
				<a class="buttonsm ques question_idea">Question</a>
      </div>
			<!-- end the buttons of actions to take on idea -->
			
			<!-- start the text area for the input -->
			<input type="hidden" name="type" id="idea_type<?php echo Configure::read("CV.fields_separator") . $idea_array["Idea"]["id"]; ?>" value="<?php echo Configure::read('CV.comments_types.agree'); ?>">
			<textarea cols="30" id="sub_idea_input<?php echo Configure::read("CV.fields_separator") . $idea_array["Idea"]["id"]; ?>" class="sub_idea_input watermark" rows="4" cols="35" maxlength="32" style="width: 100%; height: 35px;"><?php echo Configure::read('CV.agree_default_text'); ?></textarea>
			<div class="status"><span id="sub_idea_input<?php echo Configure::read("CV.fields_separator") . $idea_array["Idea"]["id"]; ?>_idea_chars_count">250</span> character(s) left</div>
      <!-- end the text area for the input -->
			
			<!-- start submit button -->
			<div style="text-align: right; margin-top: -10px;"> 
				<a  id="submit_sub_idea<?php echo Configure::read("CV.fields_separator") . $idea_array["Idea"]["id"]; ?>" class="submit_sub_idea">
					<?php echo $this->Html->image("submit-orange.png", array("alt" => "Submit")); ?>
				</a> 
			</div>
			<!-- end submit button -->

			<!-- start notes submit section -->
			<?php
				//pr($idea_array);
				if(isset($idea_array["UserNote"]["note"]) && ($idea_array["UserNote"]["note"] != ""))
				{
					$user_note = $idea_array["UserNote"]["note"];
					$note_watermark_class = "";
				}
				else
				{
					$user_note = Configure::read("CV.note_default_text");
					$note_watermark_class = "watermark";
				}
			?>
			
      <h2 style="margin: 0px 0px 0px 0;">My Private Notes</h2>
      <textarea style="width: 100%; height: 35px;" rows="4" cols="35" id="notes<?php echo Configure::read("CV.fields_separator") . $idea_array["Idea"]["id"]; ?>" name="notes" class="notes <?php echo $note_watermark_class; ?>"><?php echo $user_note; ?></textarea>
      <div class="status"><span id="notes<?php echo Configure::read("CV.fields_separator") . $idea_array["Idea"]["id"]; ?>_idea_chars_count">500</span> character(s) left</div>
      <div style="text-align: right; margin-top: -10px;">
				<a  id="submit_note<?php echo Configure::read("CV.fields_separator") . $idea_array["Idea"]["id"]; ?>" class="submit_note">
					<?php echo $this->Html->image("save-orange.png", array("alt" => "Save")); ?>
				</a> 
			</div>
			<!-- end notes submit section -->
			
			<!-- start tags submit section -->
      <!-- <div style="position: relative; margin-top: 5px;">
        <input type="text" style="width: 240px; margin-right: 10px;" size="32" value="" class="tags watermark" id="tags">
        <span class="tagMatches"></span>
        <div style="position: absolute; right: 0px; top: 4px;"><a><?php echo $this->Html->image("save-orange.png", array("alt" => "Save")); ?></a></div>
      </div> -->
			<!-- end tags submit section -->
    </div>
		
		<?php if(!empty($parent_array)) { ?>
		<div style="position: absolute; top: 25px; left: 290px;"><?php echo $this->Html->image("double-arrow.png", array("alt" => "Thumb UP", "id" => "parentarrow")); ?> </div>
		<?php } ?>
    <div style="float: right; width: 300px;">
      <?php 
			$child_idea_height = "350px";
			if(!empty($parent_array)) 
			{ 
				//set height of the  child idea array section
				$child_idea_height = "240px";
				$number_image = $ideatree->get_qi_image($parent_array);
				
				//check for the big idea 
				$favorite_idea = '<a class="favorite_idea" id="favorite_idea' . Configure::read("CV.fields_separator") . $parent_array["Idea"]["id"] . '">' . $this->Html->image("icon-grey-star.png", array("alt" => "Mark Favorite")) . '</a>';
				if(isset($parent_array["UsersFavoriteIdea"]["id"]) && ($parent_array["UsersFavoriteIdea"]["id"] > 0))
				{
					$favorite_idea = '<a>' . $this->Html->image("icon-yellow-star.png", array("alt" => "Mark Favorite")) . '</a>';
				}
				
			?>
			<!-- start to show parent idea, this only will be shown when there is a parent idea of the  current idea -->
			<div style="height: 100px;">
        <h2>Parent Idea</h2>
        <div id="parent">
          <div class="idea">
            <div class="idealeft"> <?php echo $number_image; ?>
              <div class="favorite"><?php echo $favorite_idea; ?></div>
            </div>
            <div class="idearight"> 
							<?php echo $this->Html->link($parent_array["Idea"]["idea"], "/questions/build_idea/" . $parent_array["Idea"]["id"], array("title" => "Build on Idea", "class" => "hyperlink2")); ?>
              <div class="submittedby"> 
								<?php echo $ideatree->calc_duration($parent_array["Idea"]["created"]); ?>
								by <?php echo $ideatree->set_user_profile_link($parent_array); ?>
							</div>
            </div>
          </div>
        </div>
      </div>
			<!-- end to show parent idea, this only will be shown when there is a parent idea of the  current idea -->
			<?php } ?>
      <h2 style="margin: 5px 0px 10px 0px;">Related Ideas</h2>
      <div style="height: <?php echo $child_idea_height; ?>; margin: 10px 0 0 0;" class="box">
				
				<?php if(!empty($child_idea_array)) { ?>
					<ul class="ideas" id="relatedideas">
						<?php 
						foreach($child_idea_array as $key => $val) 
						{ 
							$number_image = $ideatree->get_qi_image($val);
							$favorite_idea = '<a class="favorite_idea" id="favorite_idea' . Configure::read("CV.fields_separator") . $val["Idea"]["id"] . '">' . $this->Html->image("icon-grey-star.png", array("alt" => "Mark Favorite")) . '</a>';
							if(isset($val["UsersFavoriteIdea"]["id"]) && ($val["UsersFavoriteIdea"]["id"] > 0))
							{
								$favorite_idea = '<a>' . $this->Html->image("icon-yellow-star.png", array("alt" => "Mark Favorite")) . '</a>';
							}
						?>
							<li>
								<div class="idea" id="idea<?php echo Configure::read("CV.fields_separator") . $val["Idea"]["id"]; ?>">
									<div class="idealeft"> <?php echo $number_image; ?>
										<div class="favorite">
											<?php echo $favorite_idea; ?>
										</div>
									</div>
									<div class="idearight"> 
										<?php echo $this->Html->link($val["Idea"]["idea"], "/questions/build_idea/" . $val["Idea"]["id"], array("title" => "Build on Idea", "class" => "build_idea hyperlink2")); ?>
										<div class="submittedby"> 
											<?php echo $ideatree->calc_duration($val["Idea"]["created"]); ?>
											by <?php echo $ideatree->set_user_profile_link($val); ?>
										</div>
									</div>
								</div>
							</li>
						<?php } ?>
					</ul>
				<?php } else { ?>
					<ul class="ideas" id="relatedideas">
						<div class="emptybox">This idea has no related ideas. Use the form to the left to build on this idea.</div>
					</ul>
				<?php } ?>

      </div>
    </div>
    <div class="clear"></div>
  </div>
</div>

<script>
$(document).ready(function(){
	actions();
	other_function();
});


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

function actions()
{
	$(".idea_input").keyup(function(){
		countChars(this, <?php echo Configure::read('CV.chars_count'); ?>);
	});
	$(".sub_idea_input").keyup(function(){
		countChars(this, <?php echo Configure::read('CV.chars_count'); ?>);
	});
	$(".notes").keyup(function(){
		countChars(this, <?php echo Configure::read('CV.notes_chars_count'); ?>);
	});	
	
	/* function to show the box of agree action */
	$(".agree_idea").click(function(){
		//add the bold class to this action and remove from other actions
		$(".build_idea_actions a").removeClass("buildon");
		$(this).addClass("buildon");
		var idea_id_array = $(this).parent().attr("id").split("<?php echo Configure::read("CV.fields_separator"); ?>");
		var idea_id = idea_id_array[1];
		var post_fix = "<?php echo Configure::read("CV.fields_separator"); ?>" + idea_id;
		//hide the tag field if it is displayed 
		$("#idea_type" + post_fix).val("<?php echo Configure::read('CV.comments_types.agree'); ?>");
		$("#sub_idea_input" + post_fix).val("<?php echo Configure::read('CV.agree_default_text'); ?>");
		$("#sub_idea_input" + post_fix).addClass("watermark");
	});	
	
	/* function to show the box of disagree action */
	$(".disagree_idea").click(function(){
		$(".build_idea_actions a").removeClass("buildon");
		$(this).addClass("buildon");
		var idea_id_array = $(this).parent().attr("id").split("<?php echo Configure::read("CV.fields_separator"); ?>");
		var idea_id = idea_id_array[1];
		var post_fix = "<?php echo Configure::read("CV.fields_separator"); ?>" + idea_id;
		//hide the tag field if it is displayed 
		$("#idea_type" + post_fix).val("<?php echo Configure::read('CV.comments_types.disagree'); ?>");
		$("#sub_idea_input" + post_fix).val("<?php echo Configure::read('CV.disagree_default_text'); ?>");
		$("#sub_idea_input" + post_fix).addClass("watermark");
		
	});	
	
	/* function to show the box of modify action */
	$(".modify_idea").click(function(){
		$(".build_idea_actions a").removeClass("buildon");
		$(this).addClass("buildon");
		var idea_id_array = $(this).parent().attr("id").split("<?php echo Configure::read("CV.fields_separator"); ?>");
		var idea_id = idea_id_array[1];
		var post_fix = "<?php echo Configure::read("CV.fields_separator"); ?>" + idea_id;
		//hide the tag field if it is displayed 
		$("#idea_type" + post_fix).val("<?php echo Configure::read('CV.comments_types.modify'); ?>");
		$("#sub_idea_input" + post_fix).val("<?php echo Configure::read('CV.modify_default_text'); ?>");
		$("#sub_idea_input" + post_fix).addClass("watermark");
	});		
		
	/* function to show the box of question action */
	$(".question_idea").click(function(){
		$(".build_idea_actions a").removeClass("buildon");
		$(this).addClass("buildon");
		var idea_id_array = $(this).parent().attr("id").split("<?php echo Configure::read("CV.fields_separator"); ?>");
		var idea_id = idea_id_array[1];
		var post_fix = "<?php echo Configure::read("CV.fields_separator"); ?>" + idea_id;
		//hide the tag field if it is displayed 
		$("#idea_type" + post_fix).val("<?php echo Configure::read('CV.comments_types.question'); ?>");
		$("#sub_idea_input" + post_fix).val("<?php echo Configure::read('CV.question_default_text'); ?>");
		$("#sub_idea_input" + post_fix).addClass("watermark");
	});	
	
	
	/* function to show the tag field */
	$(".tag_idea").click(function(){
		//alert($(this).parent().attr("id"));
		var idea_id_array = $(this).parent().attr("id").split("<?php echo Configure::read("CV.fields_separator"); ?>");
		var idea_id = idea_id_array[1];
		var post_fix = "<?php echo Configure::read("CV.fields_separator"); ?>" + idea_id;
		
		//alert("hi");
		$(".sub_idea_container").hide();
		//hide the tag field if it is displayed 
		$("#tag" + post_fix).parent().show();
		$("#idea_type" + post_fix).val("tag");
		$("#sub_idea_input" + post_fix).parent().hide();
		$("#sub_idea_input" + post_fix).val("");
		$("#sub_idea_input" + post_fix).removeClass("watermark");
		$("#sub_idea_container" + post_fix).show();
	});	
	
	
	$(".notes").focus(function() {
		$(this).removeClass("watermark");
		var idea_id_array = $(this).attr("id").split("<?php echo Configure::read("CV.fields_separator"); ?>");
		var idea_id = idea_id_array[1];
		
		var default_text = "<?php echo Configure::read('CV.note_default_text'); ?>";
		if($(this).val() == default_text)
		{
			$(this).val("");
		}
	});
	$(".notes").blur(function() {
		var idea_id_array = $(this).attr("id").split("<?php echo Configure::read("CV.fields_separator"); ?>");
		var idea_id = idea_id_array[1];
		
		var default_text = "<?php echo Configure::read('CV.note_default_text'); ?>";

		if($(this).val() == "")
		{
			$(this).val(default_text);
			$(this).addClass("watermark");
		}
	});
	
	$(".sub_idea_input, .tags").focus(function() {
		$(this).removeClass("watermark");
		var idea_id_array = $(this).attr("id").split("<?php echo Configure::read("CV.fields_separator"); ?>");
		var idea_id = idea_id_array[1];
		var post_fix = "<?php echo Configure::read("CV.fields_separator"); ?>" + idea_id;
		var default_text = "";
		if($("#idea_type" + post_fix).val() == "<?php echo Configure::read('CV.comments_types.agree'); ?>")
		{
			default_text = "<?php echo Configure::read('CV.agree_default_text'); ?>";
		}
		else if($("#idea_type" + post_fix).val() == "<?php echo Configure::read('CV.comments_types.disagree'); ?>")
		{
			default_text = "<?php echo Configure::read('CV.disagree_default_text'); ?>";
		}
		else if($("#idea_type" + post_fix).val() == "<?php echo Configure::read('CV.comments_types.modify'); ?>")
		{
			default_text = "<?php echo Configure::read('CV.modify_default_text'); ?>";
		}
		else if($("#idea_type" + post_fix).val() == "<?php echo Configure::read('CV.comments_types.question'); ?>")
		{
			default_text = "<?php echo Configure::read('CV.question_default_text'); ?>";
		}
		else if($("#idea_type" + post_fix).val() == "tag")
		{
			default_text = "<?php echo Configure::read('CV.tag_default_text'); ?>";
		}
		//alert(default_text + "-" + $(this).val());
		if($(this).val() == default_text)
		{
			$(this).val("");
		}
	});
	
	$(".sub_idea_input, .tags").blur(function() {
		var idea_id_array = $(this).attr("id").split("<?php echo Configure::read("CV.fields_separator"); ?>");
		var idea_id = idea_id_array[1];
		var post_fix = "<?php echo Configure::read("CV.fields_separator"); ?>" + idea_id;
		var default_text = "";
		if($("#idea_type" + post_fix).val() == "<?php echo Configure::read('CV.comments_types.agree'); ?>")
		{
			default_text = "<?php echo Configure::read('CV.agree_default_text'); ?>";
		}
		else if($("#idea_type" + post_fix).val() == "<?php echo Configure::read('CV.comments_types.disagree'); ?>")
		{
			default_text = "<?php echo Configure::read('CV.disagree_default_text'); ?>";
		}
		else if($("#idea_type" + post_fix).val() == "<?php echo Configure::read('CV.comments_types.modify'); ?>")
		{
			default_text = "<?php echo Configure::read('CV.modify_default_text'); ?>";
		}
		else if($("#idea_type" + post_fix).val() == "<?php echo Configure::read('CV.comments_types.question'); ?>")
		{
			default_text = "<?php echo Configure::read('CV.question_default_text'); ?>";
		}
		else if($("#idea_type" + post_fix).val() == "tag")
		{
			default_text = "<?php echo Configure::read('CV.tag_default_text'); ?>";
		}
		
		if($(this).val() == "")
		{
			$(this).val(default_text);
			$(this).addClass("watermark");
		}
	});
	
	
	$(".submit_sub_idea").click(function() {
		var idea_id_array = $(this).attr("id").split("<?php echo Configure::read("CV.fields_separator"); ?>");
		var idea_id = idea_id_array[1];
		var post_fix = "<?php echo Configure::read("CV.fields_separator"); ?>" + idea_id;

		var keyword = $("#sub_idea_input" + post_fix).val();

		var default_text = "";
		if($("#idea_type" + post_fix).val() == "<?php echo Configure::read('CV.comments_types.agree'); ?>")
		{
			default_text = "<?php echo Configure::read('CV.agree_default_text'); ?>";
		}
		else if($("#idea_type" + post_fix).val() == "<?php echo Configure::read('CV.comments_types.disagree'); ?>")
		{
			default_text = "<?php echo Configure::read('CV.disagree_default_text'); ?>";
		}
		else if($("#idea_type" + post_fix).val() == "<?php echo Configure::read('CV.comments_types.modify'); ?>")
		{
			default_text = "<?php echo Configure::read('CV.modify_default_text'); ?>";
		}
		else if($("#idea_type" + post_fix).val() == "<?php echo Configure::read('CV.comments_types.question'); ?>")
		{
			default_text = "<?php echo Configure::read('CV.question_default_text'); ?>";
		}
		else if($("#idea_type" + post_fix).val() == "tag")
		{
			default_text = "<?php echo Configure::read('CV.tag_default_text'); ?>";
		  keyword = $("#tag" + post_fix).val(); 
		}
		
		if(keyword == "" || keyword == default_text)
		{
			alert("Please enter the term you want to submit.");
			$("#sub_idea_input" + post_fix).focus();
			return false;
		}
		

		if($("#idea_type" + post_fix).val() == "tag")
		{
			//add the tag into the ideas_tags table
			$.ajax({
				type: "POST",
				url: "<?php echo $this->Html->url(array("controller" => "questions","action" => "add_tag"));?>",
				data: "tags=" + keyword + "&idea_id=" + idea_id,
				success: function(data) {
					other_function();
				}
			});
		}
		else
		{
			//make a ajax request to add the idea into the ideas table and append it to the start of the list
			$.ajax({
				type: "POST",
				url: "<?php echo $this->Html->url(array("controller" => "questions","action" => "add_idea"));?>",
				data: "keyword=" + keyword + "&parent_id=" + idea_id + "&type=" + $("#idea_type" + post_fix).val() + "&target=popup",
				success: function(data){
					//alert(data);
					//alert($("#idea" + post_fix).parent("li").children("ul").length);
					if($("#relatedideas").find(".emptybox").length > 0)
					{
						//alert("start");
						$("#relatedideas").html(data);		
					}
					else
					{
						//alert("end");
						$("#relatedideas").html(data + $("#relatedideas").html());			
					}

					$("#tabs").tabs({ cookie: { expires: 30 } });
					other_function();
				}
			});
		}	
	});
	
	
	$(".submit_note").click(function() {
		var idea_id_array = $(this).attr("id").split("<?php echo Configure::read("CV.fields_separator"); ?>");
		var idea_id = idea_id_array[1];
		var post_fix = "<?php echo Configure::read("CV.fields_separator"); ?>" + idea_id;

		var note = $("#notes" + post_fix).val();

		var default_text = "<?php echo Configure::read('CV.note_default_text'); ?>";

		
		if(note == "" || note == default_text)
		{
			alert("Please enter the note you want to submit.");
			$("#notes" + post_fix).focus();
			return false;
		}

		//make a ajax request to add the idea into the ideas table and append it to the start of the list
		$.ajax({
			type: "POST",
			url: "<?php echo $this->Html->url(array("controller" => "questions","action" => "add_note"));?>",
			data: "note=" + note + "&idea_id=" + idea_id + "&target=popup",
			success: function(data){
				alert("The note has been saved.");
			}
		});
	});
	
	

	
	
}

</script>