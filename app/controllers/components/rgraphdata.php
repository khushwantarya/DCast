<?php

	class RgraphdataComponent extends Object {

	



		

		function startup (&$controller) {

			// This method takes a reference to the controller which is loading it.

			// Perform controller initialization here.

		}

		

		function Rgraphdata($idea_array) { 
		}

		function set_data($idea_array) { 
			$output = $this->add_data($idea_array);
			
			return $output;
		}

		function add_data($idea_array) {
		
			$output = array();
			foreach ($idea_array as $key => $val)
			{
				$output[$key] = $val["Idea"];
				$output[$key]["data"] = array("relation" => $val["Idea"]["data"]);
				$output[$key]["children"] = $val["children"];
				unset($output[$key]["parent_id"]);
				if(isset($val['children'][0]))
				{
					$output[$key]["data"] = $this->add_data($val['children']);
				}
			}
    	return $output;
		}

	}

	

?>