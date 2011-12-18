<?php
	
	Configure::write('CV.logo_upload_path', "../../app/webroot/img/events");
	Configure::write('CV.avatar_upload_path', "../../app/webroot/img/avatars");
	Configure::write('CV.file_upload_path', "../../app/webroot/uploads/files");	
	

	Configure::write('CV.file_browse_path', "/uploads/files/");
	Configure::write('CV.avatar_browse_path', "/img/avatars/");
	Configure::write('CV.logo_browse_path', "/img/events/");
	
	//image width and height for assoc small image
	Configure::write('CV.assoc_image_small_width', 125);
	Configure::write('CV.assoc_image_small_height', 75);	
	
	
	Configure::write('CV.fields_separator', '-');	
	Configure::write('CV.role_admin', 1);	
	Configure::write('CV.role_sme', 2);	
	Configure::write('CV.role_regular', 3);		
	
	
	//characters count	
	Configure::write('CV.chars_count', 250);
	
	//constants for the default idea type text like agree, disagree, modify, question and tag
	Configure::write('CV.agree_default_text', 'I agreee with this...');	
	Configure::write('CV.disagree_default_text', 'I disagreee with this...');	
	Configure::write('CV.modify_default_text', 'I see this differently...');	
	Configure::write('CV.question_default_text', 'I have the following question...');	
	Configure::write('CV.tag_default_text', 'Enter keyword(s) separated by commas to tag ideas.');				
	
	Configure::write('CV.your_idea_gets_favorited', 'your_idea_gets_favorited');	
	Configure::write('CV.someone_builds_on_your_idea', 'someone_builds_on_your_idea');	
	Configure::write('CV.you_select_an_avatar', 'you_select_an_avatar');	
	Configure::write('CV.you_select_an_unique_id', 'you_select_an_unique_id');	
	Configure::write('CV.you_post_an_idea', 'you_post_an_idea');	
	Configure::write('CV.you_are_the_grandparent_of_big_idea', 'you_are_the_grandparent_of_big_idea');	
	Configure::write('CV.you_are_the_parent_of_big_idea', 'you_are_the_parent_of_big_idea');	
	Configure::write('CV.your_idea_marked_as_big', 'your_idea_marked_as_big');	
	Configure::write('CV.your_idea_marked_as_favortie_20_times', 'your_idea_marked_as_favortie_20_times');	

	
	$scoring_rule_array = array(
		Configure::read('CV.your_idea_gets_favorited') => array("value" => 50, "title" => "Your idea gets favorited"),
		Configure::read('CV.someone_builds_on_your_idea') => array("value" => 50, "title" => "Someone builds on your idea"),
		Configure::read('CV.you_select_an_avatar') => array("value" => 50, "title" => "You select an avatar"),
		Configure::read('CV.you_select_an_unique_id') => array("value" => 50, "title" => "You select a unique anonymous UserID"),
		Configure::read('CV.you_post_an_idea') => array("value" => 100, "title" => "You post an idea (any idea type)"),
		Configure::read('CV.you_are_the_grandparent_of_big_idea') => array("value" => 100, "title" => "You're the grandparent of a top idea or BIG idea"),
		Configure::read('CV.you_are_the_parent_of_big_idea') => array("value" => 250, "title" => "You're the parent of a top idea or BIG idea"),
		Configure::read('CV.your_idea_marked_as_big') => array("value" => 1000, "title" => "Your idea is marked as \"BIG\" by a moderator"),
		Configure::read('CV.your_idea_marked_as_favortie_20_times') => array("value" => 1000, "title" => "Your idea is marked favorite 20 times by others (Top Idea)"),												
	);
	
	/*50  Your idea gets favorited
	50  Someone builds on your idea
	50  You select an avatar
	50  You select a unique anonymous UserID
	100  You post an idea (any idea type)
	100  You're the grandparent of a top idea or BIG idea
	250  You're the parent of a top idea or BIG idea
	1000  Your idea is marked as "BIG" by a moderator
	1000  Your idea is marked favorite 20 times by others (Top Idea)*/
	
	$comments_types = array(
	"agree" => "agree", 
	"disagree" => "disagree",
	"question" => "question", 
	"modify" => "modify");
	Configure::write('CV.comments_types', $comments_types);
		
				
?>