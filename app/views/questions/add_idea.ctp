<?php if($target == "") { ?>
<?php echo $ideatree->show('Idea/idea/id', $data_array[0]["Idea"]); ?> 
<?php } else { ?>
	<?php if(!empty($data_array)) { ?>
			<?php 
			foreach($data_array as $key => $val) 
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
	<?php } ?>
<?php } ?>