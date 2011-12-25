<?php 
class IdeatreeHelper extends AppHelper
{
  public $tab = "  ";
  public $helpers = array("Html", "Session");
  function show($name, $data)
  {
    list($modelName, $fieldName, $id) = explode('/', $name);
    $output = $this->list_element($data, $modelName, $fieldName, 0, $id);
    
    return $this->output($output);
  }
	
	function calc_duration($datetime = NULL)
	{
		if($datetime != NULL)
		{
			$time1 = strtotime($datetime);
			$time2 = time();
			$difference = $time2 - $time1;
			$one_minute = 60;
			$one_hour = 3600;
			$one_day = 3600 * 24;
			$one_month = 3600 * 24 * 30;
			$one_year = 3600 * 24 * 12;
				
			$output = '<abbr title="' . date("m/d/Y h:i:s A") . '">';
			if($difference < $one_minute)
			{
				$output .= $difference . " " . (($difference > 1)?"seconds":"second") . " ago ";
			}
			else if($difference < $one_hour)
			{
				$minuts = floor($difference/$one_minute);
				$output .= $minuts . " " . (($minuts > 1)?"minutes":"minute") . " ago ";
			}
			else if($difference < $one_day)
			{
				$hours = floor($difference/$one_hour);
				$output .= $hours . " " . (($hours > 1)?"hours":"hour") . " ago ";
			}
			else if($difference < $one_month)
			{
				$days = floor($difference/$one_day);
				$output .= $days . " " . (($days > 1)?"days":"day") . " ago ";
			}
			else if($difference < $one_year)
			{
				$months = floor($difference/$one_month);
				$output .= $months . " " . (($months > 1)?"months":"month") . " ago ";
			}
			else
			{
				$years = floor($difference/$one_year);
				$output .= $months . " " . (($months > 1)?"years":"year") . " ago ";
			}
			
			
			$output .= '</abbr>';
			return $output;
		}
	}
  
	/*
		this function returns the image to be used for the idea and questions
	*/
	function get_qi_image($val)
	{
			$number_image = "";
			if($val["Idea"]["type"])
			{
				if($val["Idea"]["type"] == Configure::read('CV.comments_types.agree'))
				{
					$number_image = $this->Html->image("icon-thumb-up.png", array("alt" => ""));
				}
				else if($val["Idea"]["type"] == Configure::read('CV.comments_types.disagree'))
				{
					$number_image = $this->Html->image("icon-thumb-down.png", array("alt" => ""));
				}
				else if($val["Idea"]["type"] == Configure::read('CV.comments_types.modify'))
				{
					$number_image = $this->Html->image("icon-modify-adapt.png", array("alt" => ""));	
				}
				else if($val["Idea"]["type"] == Configure::read('CV.comments_types.question'))
				{
					$number_image = $this->Html->image("icon-question.png", array("alt" => ""));	
				}
			}
			else
			{
				if($val["Question"]["number"] == 1)
				{
					$number_image = $this->Html->image("icon-first-thing.png", array("alt" => ""));
				}
				else if($val["Question"]["number"] == 2)
				{
					$number_image = $this->Html->image("icon-second-thing.png", array("alt" => ""));
				}
				else if($val["Question"]["number"] == 3)
				{
					$number_image = $this->Html->image("icon-third-thing.png", array("alt" => ""));	
				}
			}
			return $number_image;
	}
	
	public function get_by($val = NULL)
	{
		$by = "";
		if($val != NULL)
		{
			if(isset($val["User"]["unique_id"]) && ($val["User"]["unique_id"] != ""))
			{
				$by = $val["User"]["unique_id"];
			}
			else if(isset($val["User"]["username"]) && ($val["User"]["username"] != ""))
			{
				$by = $val["User"]["username"];
			}
		}
		return $by;
	}
	
	public function set_user_profile_link($val = NULL, $colorbox = "yes")
	{
		if($val != NULL)
		{
			$by = $this->get_by($val);
			if($colorbox == "yes")
			{
				return $this->Html->link($by, "/users/profile/" . $val["User"]["id"], array("title" => "View Profile", "class" => "view_profile submittedbyname"));
			}
			else
			{
				return $this->Html->link($by, "/users/profile/" . $val["User"]["id"], array("title" => "View Profile", "class" => "submittedbyname"));
			}
		}
	}
	
	
	
	
  function list_element($data, $modelName, $fieldName, $level, $id)
  {
		//echo $id;
    //$tabs = "\n" . str_repeat($this->tab, $level * 2);
    //$li_tabs = $tabs . $this->tab;
    
		if($level != 0)
		{
			$output = "<ul>";
		}
		else
		{
			$output = "";
		}
    
    foreach ($data as $key=>$val)
    {
			$number_image = $this->get_qi_image($val);
			
			//check for the big idea 
			$favorite_idea = '<a class="favorite_idea" id="favorite_idea' . Configure::read("CV.fields_separator") . $val[$modelName][$id] . '">' . $this->Html->image("icon-grey-star.png", array("alt" => "Mark Favorite")) . '</a>';
			if(isset($val["UsersFavoriteIdea"]["id"]) && ($val["UsersFavoriteIdea"]["id"] > 0))
			{
				$favorite_idea = '<a>' . $this->Html->image("icon-yellow-star.png", array("alt" => "Mark Favorite")) . '</a>';
			}
			
			$big_idea = $this->Html->image("award-outlier-idea-off.png", array("alt" => "Outlier", "style" => "height: 16px;"));
			if(isset($val["UsersBigIdea"]["id"]) && ($val["UsersBigIdea"]["id"] > 0))
			{
				$big_idea = $this->Html->image("award-outlier-idea.png", array("alt" => "Outlier", "style" => "height: 16px;"));
			}
			
			//set the by this is the unique_id or the username which is not blank
			
			$not_for_rgular_actions = "";
			if($this->Session->read("Auth.User.role_id") != Configure::read('CV.role_regular'))
			{
				$not_for_rgular_actions = '
																	<a class="buttonsm tag_idea" title="Tag Idea">' . $this->Html->image("icon-tag.png", array("alt" => "Tag")) . '</a> 
																	<a class="buttonsm big_idea" title="Outlier Award">' . $big_idea . '</a> 
																	';
			}
			
			
			
			
			$output .= '
							<li>
								<div class="idea" id="idea' . Configure::read("CV.fields_separator") . $val[$modelName][$id] . '">
									<div class="idealeft">' . $number_image  . ' 
										<div class="favorite">
											' . $favorite_idea . '
										</div>
									</div>
									<div class="idearight" style="position: relative;">' . 
										$this->Html->link($val[$modelName][$fieldName], "/questions/build_idea/" . $val[$modelName][$id], array("title" => "Build on Idea", "class" => "build_idea hyperlink2")) . '
										<div class="submittedby"> 
											' . $this->calc_duration($val[$modelName]["created"]) . '
											by ' . $this->set_user_profile_link($val) . ' 
										</div>
									
									
										<div class="build_idea_actions" id="build_idea_actions' . Configure::read("CV.fields_separator") . $val[$modelName][$id] . '" style="display: none; margin: -15px 0 15px 40%; position: absolute;"> 
											<a class="buttonsm agree_idea" title="Agree">' . $this->Html->image("icon-thumb-up.png", array("alt" => "Thumbs Up")) . '</a> 
											<a class="buttonsm disagree_idea" title="Disagree">' . $this->Html->image("icon-thumb-down.png", array("alt" => "Thumbs Down")) . '</a> 
											<a class="buttonsm modify_idea" title="Modify">' . $this->Html->image("icon-modify-adapt.png", array("alt" => "Modify")) . '</a> 
											<a class="buttonsm question_idea" title="Question">' . $this->Html->image("icon-question.png", array("alt" => "Question Mark")) . '</a>'
											. $not_for_rgular_actions .
											'
										</div>
										
										<div class="build sub_idea_container" id="sub_idea_container' . Configure::read("CV.fields_separator") . $val[$modelName][$id] . '" style="display: none;">
											<input type="hidden" name="type" id="idea_type' . Configure::read("CV.fields_separator") . $val[$modelName][$id] . '">
											<div class="tagscontain">
												<input class="tags watermark" id="tag' . Configure::read("CV.fields_separator") . $val[$modelName][$id] . '" value="Enter keyword(s) separated by commas to tag ideas." size="30" type="text">
												<span class="tagMatches"></span>
											</div>
											<div>
												<textarea cols="30" id="sub_idea_input' . Configure::read("CV.fields_separator") . $val[$modelName][$id] . '" class="sub_idea_input watermark" rows="3" maxlength="250"></textarea>
												<div class="status"><span id="sub_idea_input' . Configure::read("CV.fields_separator") . $val[$modelName][$id] . '_idea_chars_count">250</span> character(s) left</div>
											</div>
											<div class="ideasubmit"> 
												<a id="submit_sub_idea' . Configure::read("CV.fields_separator") . $val[$modelName][$id] . '" class="submit_sub_idea">' . $this->Html->image("submit-orange.png", array("alt" => "Submit")) . '</a> 
												<a id="cancel_sub_idea' . Configure::read("CV.fields_separator") . $val[$modelName][$id] . '" class="cancel_sub_idea">' . $this->Html->image("cancel-grey.png", array("alt" => "Cancel")) . '</a> 
											</div>
										</div>
									</div>
								</div>';
			
      if(isset($val['children'][0]))
      {
        $output .= $this->list_element($val['children'], $modelName, $fieldName, $level+1, $id);
        $output .= "</li>";
      }
      else
      {
        $output .= "</li>";
      }
    }
		if($level != 0)
		{
   	  $output .= "</ul>";
		}
		else
		{
   	  $output .= "";
		}

    
    return $output;
  }
}
?> 