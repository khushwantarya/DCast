<h1>Share Ideas</h1>

<div id="tabs">
	<?php if(!empty($data_array)) { ?>
		<ul>
			<?php foreach($data_array as $k => $v) { ?>
			<li><a href="#question<?php echo Configure::read("CV.fields_separator"); ?><?php echo $v["Question"]["id"]; ?>"><?php echo $v["Question"]["keyword"]; ?></a></li>
			<?php } ?>
		</ul>
		
		<?php foreach($data_array as $k => $v) { //$v["Question"]["id"] = $k+1; ?>
			<div id="question<?php echo Configure::read("CV.fields_separator"); ?><?php echo $v["Question"]["id"]; ?>" class="sharetabs">
				<div class="box">
					<div class="innerbox">
						<!-- start search and idea posting box -->
						<div>
							<textarea id="idea_input<?php echo Configure::read("CV.fields_separator"); ?><?php echo $v["Question"]["id"]; ?>" class="idea_input newidea watermark" title="Click here to share your ideas, or click on an idea below to build"><?php echo $v["Question"]["title"]; ?></textarea>
							<input type="hidden" id="idea_input<?php echo Configure::read("CV.fields_separator"); ?><?php echo $v["Question"]["id"]; ?>_default" name="idea_input<?php echo Configure::read("CV.fields_separator"); ?><?php echo $v["Question"]["id"]; ?>_default" value="<?php echo $v["Question"]["title"]; ?>" /> 
							<div class="status"><span id="idea_input<?php echo Configure::read("CV.fields_separator"); ?><?php echo $v["Question"]["id"]; ?>_idea_chars_count">250</span> character(s) left</div>
							<div class="ideasubmit">
								<div style="float:right;">
									<table border="0" cellpadding="2">
										<tbody>
											<tr>
											<td><?php echo $this->Html->image("search-orange.png", array("alt" => "Search", "class" => "search_idea", "id" => "search_idea" . Configure::read("CV.fields_separator") . $v["Question"]["id"])); ?></td>
											<td valign="middle">then</td>
											<td><?php echo $this->Html->image("submit-orange.png", array("alt" => "Submit", "id" => "add_idea" . Configure::read("CV.fields_separator") . $v["Question"]["id"], "class" => "add_idea")); ?></td>
											</tr>
										</tbody>
									</table>
								</div>
								<div style="clear:both;"></div>
							</div>
							<div class="search_result" id="search_result<?php echo Configure::read("CV.fields_separator"); ?><?php echo $v["Question"]["id"]; ?>" style="display: none;"></div>
						</div>
						<!-- End search and idea posting box -->
						
						
						<!-- start ideas listing -->
						<h2 style="margin-top:0px;">Build on Ideas</h2>						
						<?php if(isset($v["Idea"])) { ?>
						<div id="treecontrol<?php echo Configure::read("CV.fields_separator"); ?><?php echo $v["Question"]["id"]; ?>" class="treecontrol">
							<a title="Collapse the entire tree below" href="#"><?php echo $this->Html->image("minus.gif", array("alt" => "Collapse All")); ?> Collapse All</a>
							<a title="Expand the entire tree below" href="#"><?php echo $this->Html->image("plus.gif", array("alt" => "Expand All")); ?> Expand All</a>
							<a title="Toggle the tree below, opening closed branches, closing open branches" href="#">Toggle All</a>
						</div>
				
						<ul id="tree<?php echo Configure::read("CV.fields_separator"); ?><?php echo $v["Question"]["id"]; ?>" class="treeview<?php echo Configure::read("CV.fields_separator"); ?><?php echo $v["Question"]["id"]; ?> ideas">
							<?php echo $ideatree->show('Idea/idea/id', $v["Idea"]); ?> 
						</ul>	
						<script>
							$(document).ready(function(){
								$("#tree<?php echo Configure::read("CV.fields_separator"); ?><?php echo $v["Question"]["id"]; ?>").treeview({
									control: "#treecontrol<?php echo Configure::read("CV.fields_separator"); ?><?php echo $v["Question"]["id"]; ?>",
									persist: "cookie",
									cookieId: "treeview<?php echo Configure::read("CV.fields_separator"); ?><?php echo $v["Question"]["id"]; ?>"
								});
							});
						</script>
						<?php } ?>
						<!-- end ideas listing -->

					</div>
				</div>
			</div>

		<?php } ?>
	<?php } ?>
</div>

<script language="javascript" type="text/javascript">
$(document).ready(function(){
  $("#tabs").tabs({ cookie: { expires: 30 } });
	
	$(".search_idea").click(function(){
		//alert($(this).attr("id"));
		var question_id_array = $(this).attr("id").split("<?php echo Configure::read("CV.fields_separator"); ?>");
		var question_id = question_id_array[1];
		var keyword = $("#idea_input<?php echo Configure::read("CV.fields_separator"); ?>" + question_id).val();
		if(keyword == "" || keyword == $("#idea_input<?php echo Configure::read("CV.fields_separator"); ?>" + question_id + "_default").val())
		{
			alert("Please enter the term you want to search.");
			$("#idea_input<?php echo Configure::read("CV.fields_separator"); ?>" + question_id).focus();
			return false;
		}
		
		//make a ajax request to search the idea into the ideas table and show the result in the 
		$.ajax({
			type: "POST",
			url: "<?php echo $this->Html->url(array("controller" => "questions","action" => "search_idea"));?>",
			data: "keyword="+keyword,
			success: function(data){   
				//alert(data);
				//var msg_array = $.parseJSON(data);
				//alert(msg_array.type + "\n" + data);
				$("#search_result<?php echo Configure::read("CV.fields_separator"); ?>" + question_id).html(data);
				$("#search_result<?php echo Configure::read("CV.fields_separator"); ?>" + question_id).slideDown();
				open_color_box();
			}
		});
	});
	
	
	/* function is used to add the idea in the ideas table using ajax */
	$(".add_idea").click(function(){
		var question_id_array = $(this).attr("id").split("<?php echo Configure::read("CV.fields_separator"); ?>");
		var question_id = question_id_array[1];
		var keyword = $("#idea_input<?php echo Configure::read("CV.fields_separator"); ?>" + question_id).val();
		if(keyword == "" || keyword == $("#idea_input<?php echo Configure::read("CV.fields_separator"); ?>" + question_id + "_default").val())
		{
			alert("Please enter the term you want to search.");
			$("#idea_input<?php echo Configure::read("CV.fields_separator"); ?>" + question_id).focus();
			return false;
		}
		
		//make a ajax request to add the idea into the ideas table and append it to the start of the list
		$.ajax({
			type: "POST",
			url: "<?php echo $this->Html->url(array("controller" => "questions","action" => "add_idea"));?>",
			data: "keyword=" + keyword + "&question_id=" + question_id,
			success: function(data){
				//alert(data);
				if($("#tree<?php echo Configure::read("CV.fields_separator"); ?>" + question_id + " li:first").length > 0)
				{
					$(data).insertBefore($("#tree<?php echo Configure::read("CV.fields_separator"); ?>" + question_id + " li:first"));
				}
				else
				{
					$("#tree<?php echo Configure::read("CV.fields_separator"); ?>" + question_id).html(data);
				}
				
				$("#tabs").tabs({ cookie: { expires: 30 } });
				open_color_box();
				mouseover_actions();
				actions();
			}
		});
	});

	


	
	
	open_color_box();
	mouseover_actions();
	actions();
});

function mouseover_actions()
{
	/* function to show the actions list when mouseover the idea */
	$(".idea").mouseover(function(){
		var idea_id_array = $(this).attr("id").split("<?php echo Configure::read("CV.fields_separator"); ?>");
		var idea_id = idea_id_array[1];
		$(".build_idea_actions").hide();
		$("#build_idea_actions<?php echo Configure::read("CV.fields_separator"); ?>" + idea_id).show();
	});
}

function open_color_box()
{
	$(".build_idea").colorbox({iframe:true, width:"750px", height:"490px;"});
	$(".view_profile").colorbox({iframe:true, width:"750px", height:"550px;"});
}

function actions()
{
	$(".idea_input").keyup(function(){
		countChars(this, <?php echo Configure::read('CV.chars_count'); ?>);
	});
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
				mouseover_actions();
				//actions();
			}
		});
	});
	$(".sub_idea_input").keyup(function(){
		countChars(this, <?php echo Configure::read('CV.chars_count'); ?>);
	});
	/* function to show the box of agree action */
	$(".agree_idea").click(function(){
		//alert($(this).parent().attr("id"));
		var idea_id_array = $(this).parent().attr("id").split("<?php echo Configure::read("CV.fields_separator"); ?>");
		var idea_id = idea_id_array[1];
		var post_fix = "<?php echo Configure::read("CV.fields_separator"); ?>" + idea_id;
		$(".sub_idea_container").hide();
		//hide the tag field if it is displayed 
		$("#tag" + post_fix).parent().hide();
		$("#idea_type" + post_fix).val("<?php echo Configure::read('CV.comments_types.agree'); ?>");
		$("#sub_idea_input" + post_fix).parent().show();
		$("#sub_idea_input" + post_fix).val("<?php echo Configure::read('CV.agree_default_text'); ?>");
		$("#sub_idea_input" + post_fix).addClass("watermark");
		$("#sub_idea_container" + post_fix).show();
	});	
	
	/* function to show the box of disagree action */
	$(".disagree_idea").click(function(){
		//alert($(this).parent().attr("id"));
		var idea_id_array = $(this).parent().attr("id").split("<?php echo Configure::read("CV.fields_separator"); ?>");
		var idea_id = idea_id_array[1];
		var post_fix = "<?php echo Configure::read("CV.fields_separator"); ?>" + idea_id;
		$(".sub_idea_container").hide();
		//hide the tag field if it is displayed 
		$("#tag" + post_fix).parent().hide();
		$("#idea_type" + post_fix).val("<?php echo Configure::read('CV.comments_types.disagree'); ?>");
		$("#sub_idea_input" + post_fix).parent().show();
		$("#sub_idea_input" + post_fix).val("<?php echo Configure::read('CV.disagree_default_text'); ?>");
		$("#sub_idea_input" + post_fix).addClass("watermark");
		$("#sub_idea_container" + post_fix).show();
		
	});	
	
	/* function to show the box of modify action */
	$(".modify_idea").click(function(){
		//alert($(this).parent().attr("id"));
		var idea_id_array = $(this).parent().attr("id").split("<?php echo Configure::read("CV.fields_separator"); ?>");
		var idea_id = idea_id_array[1];
		var post_fix = "<?php echo Configure::read("CV.fields_separator"); ?>" + idea_id;
		$(".sub_idea_container").hide();
		//hide the tag field if it is displayed 
		$("#tag" + post_fix).parent().hide();
		$("#idea_type" + post_fix).val("<?php echo Configure::read('CV.comments_types.modify'); ?>");
		$("#sub_idea_input" + post_fix).parent().show();
		$("#sub_idea_input" + post_fix).val("<?php echo Configure::read('CV.modify_default_text'); ?>");
		$("#sub_idea_input" + post_fix).addClass("watermark");
		$("#sub_idea_container" + post_fix).show();
	});		
		
	/* function to show the box of question action */
	$(".question_idea").click(function(){
		//alert($(this).parent().attr("id"));
		var idea_id_array = $(this).parent().attr("id").split("<?php echo Configure::read("CV.fields_separator"); ?>");
		var idea_id = idea_id_array[1];
		var post_fix = "<?php echo Configure::read("CV.fields_separator"); ?>" + idea_id;
		$(".sub_idea_container").hide();
		//hide the tag field if it is displayed 
		$("#tag" + post_fix).parent().hide();
		$("#idea_type" + post_fix).val("<?php echo Configure::read('CV.comments_types.question'); ?>");
		$("#sub_idea_input" + post_fix).parent().show();
		$("#sub_idea_input" + post_fix).val("<?php echo Configure::read('CV.question_default_text'); ?>");
		$("#sub_idea_input" + post_fix).addClass("watermark");
		$("#sub_idea_container" + post_fix).show();
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
		
		
		$(".sub_idea_container").hide();
		if($("#idea_type" + post_fix).val() == "tag")
		{
			//add the tag into the ideas_tags table
			$.ajax({
				type: "POST",
				url: "<?php echo $this->Html->url(array("controller" => "questions","action" => "add_tag"));?>",
				data: "tags=" + keyword + "&idea_id=" + idea_id,
				success: function(data) {
					//alert(data);
					open_color_box();
					mouseover_actions();
					actions();
				}
			});
		}
		else
		{
			//make a ajax request to add the idea into the ideas table and append it to the start of the list
			$.ajax({
				type: "POST",
				url: "<?php echo $this->Html->url(array("controller" => "questions","action" => "add_idea"));?>",
				data: "keyword=" + keyword + "&parent_id=" + idea_id + "&type=" + $("#idea_type" + post_fix).val(),
				success: function(data){
					//alert(data);
					//alert($("#idea" + post_fix).parent("li").children("ul").length);
					if($("#idea" + post_fix).parent("li").children("ul").length > 0)
					{
						//$(data).insertBefore($("#idea" + post_fix).parent("li").children("ul li:first"));
						$("#idea" + post_fix).parent("li").children("ul").html(data + $("#idea" + post_fix).parent("li").children("ul").html());
					}
					else
					{
						$("#idea" + post_fix).parent("li").html($("#idea" + post_fix).parent("li").html() + "<ul>" + data + "</ul>");
					}

					$("#tabs").tabs({ cookie: { expires: 30 } });
					open_color_box();
					mouseover_actions();
					actions();
				}
			});
		}	
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

				mouseover_actions();
				//actions();
			}
		});
	});
	

	
	
	$(".cancel_sub_idea").click(function(){
		var idea_id_array = $(this).attr("id").split("<?php echo Configure::read("CV.fields_separator"); ?>");
		var idea_id = idea_id_array[1];
		var post_fix = "<?php echo Configure::read("CV.fields_separator"); ?>" + idea_id;
		$(".sub_idea_container").hide();
	});
	
	
}
</script>
  