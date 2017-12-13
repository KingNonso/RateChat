<?php 
class Validate{
	private $_passed = false,
			$_errors = array(),
			$_db = null;
			
	public function __construct(){
		$this->_db = Database::getInstance();
	}
	public function check($source, $items = array()){
		foreach($items as $item => $rules){
			foreach($rules as $rule => $rule_value){
				//my code
					if ($rule == 'name') {
						$handle = $rule_value;
					}	
				//ends here
                if($rule === 'checkbox'){
                    if(!$this->validateCheckbox($source[$item],$rule_value)){
                        $this->addError("Please select at least {$rule_value} from {$handle}");
                    }



                }elseif($rule === 'checked'){
                    if(!$this->isChecked($source[$item],$rule_value)){
                        $this->addError("Please {$handle} must be chosen/ selected/checked.");
                        //$this->addError("Please {$rule_value} must be chosen/ selected/checked in {$handle}");
                    }

                }else{
                    $value = isset($source[$item]) ? (is_array($source[$item]) ? null :trim($source[$item]) ) : null;
                    //use sessions to hold data for return on error
                    Session::put($item,$value);
                    $item = escape($item);

                    if($rule === 'required' && empty($value)){
                        $this->addError("{$handle} is required");
                    }elseif(!empty($value)){

                        switch($rule){
                            case 'min':
                                if(strlen($value) < $rule_value){
                                    $this->addError("{$handle} must be a minimum of {$rule_value} characters.");
                                }
                                break;
                            case 'max':
                                if(strlen($value) > $rule_value){
                                    $this->addError("{$handle} must be a maximum of {$rule_value} characters.");
                                }
                                break;
                            case 'matches':
                                if($value != $source[$rule_value]){
                                    $this->addError("Chosen {$rule_value} does not match with {$handle}");
                                }
                                break;
                            case 'checkbox':
                                if($value != $source[$rule_value]){
                                    $this->addError("Chosen {$rule_value} does not match with {$handle}");
                                }
                                break;
                            case 'unique':
                                $check = $this->_db->get($rule_value, array($item,'=',$value));
                                if($this->_db->count()){
                                    $this->addError("{$handle} already exists. Choose something unique!");
                                }
                                break;
                        }
                    }

                }
			}
		}

		if(empty($this->_errors)){
			$this->_passed = true;
		}
		return $this;
	}

    public function check_date($day, $month, $year){
        $goodDate = checkdate($month,$day,$year)? true : false;
        if(!$goodDate){
            $this->addError("Please check your date format.");
        }
        if(empty($this->_errors)){
            $this->_passed = true;
        }
        return $this;

    }

    private function isChecked($post,$value){
        $post = is_array($post)? $post: array($post);

        if(!empty($post)){
            foreach($post as $checked)
            {
                if($checked == $value)
                {
                    return true;
                }
            }
        }
        return false;
    }

    private function validateCheckbox($posts,$number){
        $posts = is_array($posts)? $posts: array($posts);
        $checkboxes = count($posts);
        if(empty($posts) || ($checkboxes < $number)){
            return false;
        }
        return true;




    }


    public function hostel_check($user_id, $hostel){
        //make sure sex matches with selected hostel conditions
        //get user id
        $female_hostels = array('hostel_a','hostel_b');
        $male_hostels = array('hostel_b');
        $sex =  $this->_db->get_assoc('students',array('user_id','=',$user_id))->results_assoc();
        foreach($sex as $row){
            $person_sex = $row['sex'];
            //use user id to get sex in students table
            //check sex and selected hostel
            if(in_array($hostel, $female_hostels) && $person_sex == 'female'){
                return true;
            }elseif(in_array($hostel, $male_hostels) && $person_sex == 'male'){
                return true;
            }else{
                return false;
            }
        }


    }
    public function room_check($user_id, $room){
        ///get the room number
            $select = preg_replace('/[^0-9]/','',$room); //remove letters from room number
            $male_rooms = range(100,300);
            $female_rooms = range(300,428);

            $person =  $this->_db->get_assoc('students',array('user_id','=',$user_id))->results_assoc();
            foreach($person as $row){
                $sex = $row['sex'];
                $hostel = $row['hostel'];

                if($sex == 'female' && ($hostel == 'hostel_a' || in_array($select,$female_rooms))){
                    return true;
                }elseif(in_array($select,$male_rooms) && $sex == 'male'  ){
                    return true;
                }else{
                    return false;
                }
            }
    }
	private function addError($error){
		$this->_errors[] = $error;
	}
	public function errors(){
		return $this->_errors;
	}
	public function passed(){
		return $this->_passed;
	}

    public 	function display_errors(){
        $output = "<p class=\"errors\"> ";
        $output .= "Please review the following fields: <br />";
        foreach($this->errors() as $error){
            $output .= " - ". $error."<br />";
        }
        $output .= "</p>";
        return $output;
    }


}
?>