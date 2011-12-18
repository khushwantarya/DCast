<?php if(!empty($live_array)) { ?>
<ul class="ideas">
	<?php foreach($live_array as $qk => $qv) { ?>
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
<div id="pagination" class="datapager">
	<?php
	//'complete' => 'pagination_call_back()'
	$paginator->options(array('url' => $to_pass . "/tab:livestream", 'update' => '#livestream_container'/*, 'indicator' => '#spinner'*/));
	echo $html->div(null,
	$paginator->prev(__('Previous',true), array('class' => 'pagerbtn'),null,array('class' => 'previous-off')) . "&nbsp; &nbsp;" .
	$paginator->numbers(array("separator"=>'&nbsp;&nbsp;', 'class' => 'pager', 'url' => $to_pass . "/tab:livestream")) . "&nbsp; &nbsp;" .
	$paginator->next(__('Next',true),array('class' => 'pagerbtn'),null,array('class' => 'next-off')),array('style' => 'width: 100%;'));  
	?>
	<div class="clear"></div>
</div>	

<?php } else {  ?>
	<ul>
		<li style="padding: 10px;">There is no Item Live Stream.</li>
	</ul>
<?php } ?>
<?php echo $this->Js->writeBuffer(); ?>