<h1><?php echo __(ucwords($event_array["Event"]["name"]), true); ?></h1>
<p class="tagline">Please review the event video, additional summary and key questions below to prepare yourself to share your ideas</p>
<div id="viewquestions">
  <div class="head_1"> Key Questions for Sage Commons Congress - Ideation Space </div>
  <div class="questions_over">
  	<?php //pr($event_array); ?>
  	<?php if(!empty($event_array["Question"])) { ?>
		<?php foreach($event_array["Question"] as $ques) { ?>
			<div class="question" style=""><?php echo __($ques["title"], true); ?></div>
		<?php } ?>
	<?php } ?>
	<div class="clear"></div>
  </div>
  <div class="video_over">
	<div class="head_2"> 
	<?php
	if(isset($event_array["Event"]["video_text"])) 
	{ 
		echo __($event_array["Event"]["video_text"], true);
	}
	?>
	</div>
	<?php 
		if(isset($event_array["Event"]["event_video"])) 
		{ 
			echo $event_array["Event"]["event_video"];
		}
	?>
  </div>
  <div class="summary_over">
	<div class="head_2"> Summary </div>
	<div class="summary_txt"> 
	
		<?php
		if(isset($event_array["Event"]["summary"])) 
		{ 
			echo nl2br(__($event_array["Event"]["summary"], true));
		}	
		?>
	  
	  
	  <br /><br />
	  Additional Info:<br /> 
	  <!-- Put in an ordered list array of the files here. -->

	  <div id="ctl00_main_pLinks">
	  	
		<?php
			echo "<b>" . __("Quick Tips:", true) . "</b><br />";
			if(isset($event_array["Event"]["dc_quick_tips"])) 
			{ 
				echo nl2br(__($event_array["Event"]["dc_quick_tips"], true));
			}
		 	echo "<br /><br />";
		 	//open the file if some one click it in new window
			if(isset($event_array["Event"]["event_information"]) && ($event_array["Event"]["event_information"] != ""))
			{
				echo $this->Html->link(__("Open File", true), Router::url("/" . Configure::read('CV.file_browse_path') . $event_array["Event"]["event_information"], true ), array("title" => __("Open File", true), "target" => "_blank"), '', array("escape" => false));
			} 
			$event_data = $this->requestAction('/events/get_event/' . $event_id);
		?>
	  </div>
	</div>
  </div>
  <div class="clear"></div>
</div>