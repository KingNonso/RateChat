<?php

class Dashboard extends Controller {

    function __construct() {
        parent::__construct();

        $this->view->generalJS = array('ajax.js');
        $logged = Session::get('loggedIn');
        //$role = Session::get('role');
        if ($logged == false) {

            Redirect::to(URL.'login');
        }

    }
    function index(){
        $types = array('Public','Celebrity','Executive');
        $type = $types[Session::get('user_perms_id')-1];
        $this->view->generalJS = array('ajax.js','liveTimeAgo.js','upload_check.js','post_loader.js');
        $this->view->js = array('dashboard/js/default.js','dashboard/js/wall_pic_post.js','dashboard/js/friendship.js','dashboard/js/direct_chat.js');

        $person = $this->model->get_person();
        $this->view->person = $person;
        $this->view->type = $type;
        $posts = $this->model->dept_post($type[Session::get('user_perms_id')]);
        $this->view->wall_post = $posts;
        $this->view->relates = $this->model->get_my_friends_once();;
        $this->view->direct_chat = $this->model->direct_chat();;
        $this->view->title = 'Discussion '.Session::get('logged_in_user_first_name').'\'s '.$type;
        $this->view->render('dashboard/group','admin');
    }

    public function directChat(){
        $person = $this->model->saveDirectChat();
    }
    public function GetDirectChat($person = null){
        $person = $this->model->GetDirectChat($person);
    }
    public function GetNewChat($person = null){
        $person = $this->model->GetNewChat($person);
    }

    public function member($slug){
        $member = $this->model->member($slug);
        $this->view->title = $member['first'] .'\'s - Profile';
        $this->view->member = $member;
        $this->view->render('dashboard/profile','admin');
        //$this->view->js = array('profile/js/friendship.js');

        //$this->view->posts = $this->model->get_two_chat($_SESSION['user_id'],Session::get('receiver_id'));
        //$this->view->conversation = $this->model->get_conversation();
        //$this->view->isFriend = $this->model->friend_system(Session::get('user_id'),$member['id']);
        //$this->view->isFriend = $this->model->friend_system(3,1);
        //$this->view->isBlocked = $this->model->member($slug);

    }

    function update_pass() {
        //@Task: Do your error checking
        if (Input::exists()) {
            if (1) {
                $validate = new Validate();
                //validate input
                $validation = $validate->check($_POST, array(
                    'login_email' => array(
                        'name' => 'Email',
                    ),
                    'old_pass' => array(
                        'name' => 'Old Password',
                        'required' => true,
                        'min' => 6,
                    ),
                    'new_pass' => array(
                        'name' => 'New Password',
                        'required' => true,
                    ),
                    'new_again' => array(
                        'name' => 'New Password Confirmation',
                        'required' => true,
                        'matches' => 'new_pass',
                    ),
                ));

                if ($validation->passed()) {
                    if ($this->model->update_password()) {
                    }
                } else {
                    if (count($validation->errors()) == 1) {
                        $message = "There was 1 error in the form.";
                    } else {
                        $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                    }
                    $message .= $validate->display_errors();
                    Session::put('error', $message);

                }
            }
        }
        Redirect::to(backToSender());

    }


    function picture_update() {
        //@Task: Do your error checking
        if (Input::exists()) {
            if (1) {
                $upload = $this->upload('profile');

                $this->model->picture_update($upload);
            }
        }
        Redirect::to(backToSender());

    }

    function upload($folder = '', $error = false) {
        //echo($max);
        $result = array();

        //upload
        $destination = UPLOAD_PATH . $folder;
        $upload = new Upload($destination);
        //$upload->setMaxSize($max);
        $upload->allowAllTypes();
        $upload->upload();
        foreach ($upload->getMessages() as $msg) {
            $result[] = $msg;
        }
        //if the sub-folder doesn't exist yet create it
        if (!is_dir($destination)) {
            mkdir($destination);
        }
        $path = $upload->fileName();

        if (!isset($path) && $error) {
            $result[] = "Please Upload an Image file";
            $path = NULL;
            $output = "<p class=\"errors\"> ";
            $output .= "Please review the following fields: <br />";
            foreach ($result as $error) {
                $output .= " - " . $error . "<br />";
            }
            $output .= "</p>";
            Session::put('error', $output);
            //Redirect::to(URL . $step);
            //$this->view->render('reg/member/'.$step, true);

            return false;
        } else {
            return $path;
        }
        //Do not resize, do not save any resized image. Responsive system automatically adjust to fit screen size
        /*
          else{
          $resize = new Resize($destination.$path);
          $resize->resizeImage(120, 90, 'exact');
          $resize->saveImage($destination.'/'.$id_key.'/'.$path, 100);
          } */
    }



    function account(){
        list($this->view->account,$this->view->lead) = $this->model->get_persons_details(Session::get('user_id'));
        $this->view->personnel_rank = $this->model->personnel_rank();

        $this->view->generalJS = array('upload_check.js');

        $this->view->title = 'My Account';
        $this->view->render('dashboard/account', 'admin');
    }


    function wall(){
        $this->view->generalJS = array('ajax.js','liveTimeAgo.js','upload_check.js','post_loader.js');
        $this->view->js = array('wall/js/default.js','wall/js/wall_pic_post.js','wall/js/friendship.js');
        //$route = $this->reMapRouteToModel('wall');
        $person = $this->model->get_person();
        $this->view->person = $person;
        $this->view->title = 'Rate Chats - '.Session::get('logged_in_user_first_name').'\'s wall';

        $this->view->wall_post = $this->model->wall_post();
        $this->view->friendship_requested = $this->model->friendship_request($person['id']);

        $this->view->myFriends = $this->model->get_my_friends();

        //$this->view->likes = $this->model->get_user_likes($_SESSION['user_id']);

        $this->view->title = 'My Wall ';
        $this->view->render('dashboard/wall','admin');
    }

    function load_more_wall_post($type = null){
        $this->model->load_more_wall_post($type);
    }


    function group($type = 'Public'){
        $types = array('Public','Celebrity','Executive');
        $row = (array_keys($types,$type));
        list($this->view->members,$this->view->celebs,$this->view->execs) = $this->model->get_people_in_class($row[0]+1);

        $this->view->title = $type.' Class ';
        $this->view->js = array('dashboard/js/list_peeps.js');
        $this->view->render('dashboard/list_peeps_by_class','admin');

    }


    function event($action = null, $id = null){
        if($action && $id){
            switch($action){
                case 'update':
                    list($this->view->about, $this->view->count) = $this->model->get_event($id);
                    $page = 'update_event';

                    break;
                case 'ticket':
                    $this->view->about = $this->model->get_event_ticket($id);
                    $page = 'ticket';

                    break;
                case 'attend':
                    $this->model->attend_event($id,1);
                    $this->view->about = $this->model->get_event();
                    $page = 'event';

                    break;
                case 'view':
                    list($this->view->about, $this->view->count) = $this->model->view_event($id);
                    $page = 'view';
                    break;
                case 'statistics':
                    $this->view->about = $this->model->get_event_statistics($id);
                    $page = 'statistics';
                    break;
            }

        }else{
            $this->view->about = $this->model->get_event();
            $page = 'event';
        }
        $this->view->jsPlugin = array('timepicker/bootstrap-timepicker.min.js');
        $this->view->cssPlugin = array('timepicker/bootstrap-timepicker.min.css');
        $this->view->js = array('webmaster/js/ui.js');
        $this->view->generalJS = array('upload_check.js','ajax.js');

        $this->view->title = 'The  Event\'s Calender ';
        $this->view->render('dashboard/event/'.$page, 'admin');
    }

    function event_rsvp($action = null, $id = null){
        $posts = $this->model->event_rsvp($action, $id);
        Redirect::to(backToSender());
    }


        function attend_event($action = null){
        $this->view->about = $this->model->attend_event($action);
        Redirect::to(backToSender());
    }

    function add_event($update = null) {
        //@Task: Do your error checking
        if (Input::exists()) {
            if (1) {

                $validate = new Validate();
                //validate input
                $validation = $validate->check($_POST, array(
                    'title' => array(
                        'name' => 'Title',
                        'required' => true,
                    ),
                    'description' => array(
                        'name' => 'Description',
                        'required' => true,
                    ),
                    'club_type' => array(
                        'name' => 'Type of Event',
                        'required' => true,
                    ),
                    'venue' => array(
                        'name' => 'Venue',
                        'required' => true,
                    ),
                    'datepicker' => array(
                        'name' => 'Date',
                        'required' => true,
                    ),
                    'timepicker' => array(
                        'name' => 'Time',
                        'required' => true,
                    ),
                ));
                if ($validation->passed()) {
                    $upload = $this->upload('event',true);
                    $this->model->add_event($update, $upload);

                } else {
                    if (count($validation->errors()) == 1) {
                        $message = "There was 1 error in the form.";
                    } else {
                        $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                    }
                    $message .= $validate->display_errors();
                    Session::put('error', $message);
                }
            }
        }
        Redirect::to(backToSender());
    }


    public function like($post, $id){
        $this->model->like($post, $id);
    }

    public function unlike($post, $id){
        $this->model->unlike($post, $id);
    }

    function membership_upgrade() {
        //@Task: Do your error checking
        if (Input::exists()) {
            $validate = new Validate();
            //validate input
            $validation = $validate->check($_POST, array(
                'membership' => array(
                    'name' => 'Membership',
                    'required' => true,
                ),
            ));

            if ($validation->passed()) {
                $this->model->membership_upgrade(Input::get('membership'));

            } else {
                if (count($validation->errors()) == 1) {
                    $message = "There was 1 error in the form.";
                } else {
                    $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                }
                $message .= $validate->display_errors();
                Session::put('error', $message);

            }
        }
        Redirect::to(backToSender());

    }

    function friends(){
        $total = $this->model->get_my_friends();
        list($this->view->members, $this->view->celebs,$this->view->execs) = $total;
        $this->view->count = count($total);
        $this->view->js = array('dashboard/js/friendship.js');
        $this->view->title = 'Friends - Fans - Followers';
        $this->view->render('dashboard/accept_friends','admin');
    }

    function find_friends() {
        //@Task: Do your error checking
        if (Input::exists()) {
            $validate = new Validate();
            //validate input
            $validation = $validate->check($_POST, array(
                'friend_name' => array(
                    'name' => 'Friend Name',
                    'required' => true,
                ),
            ));

            $friend = Input::get('friend_name');

            if ($validation->passed()) {
                list($this->view->members,$this->view->celebs,$this->view->execs) = $this->model->find_friends($friend);
                $this->view->js = array('dashboard/js/friendship.js');
                $this->view->title = 'Search - '.$friend;
                $this->view->render('dashboard/find_friends','admin');
            } else {
                if (count($validation->errors()) == 1) {
                    $message = "There was 1 error in the form.";
                } else {
                    $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                }
                $message .= $validate->display_errors();
                Session::put('error', $message);
                Redirect::to(backToSender());
            }
        }

    }

    public function SendFriendShipRequest(){
        $this->model->SendFriendShipRequest();
    }

    public function AcceptFriendRequest($block = false){
        $this->model->AcceptFriendRequest($block);
    }

    public function RemoveFriendRequest($type = 'Cancel'){
        $this->model->RemoveFriendRequest($type);
    }


    function comment() {
        //@Task: Do your error checking
        if (Input::exists()) {

            $validate = new Validate();
            //validate input
            $validation = $validate->check($_POST, array(
                'txtmessage' => array(
                    'name' => 'message',
                    'required' => true,
                ),
                'post_id' => array(
                    'name' => 'post_id',
                    'required' => true,
                ),
            ));
            if ($validation->passed() && $this->model->comment()) {

                //do nothing
            }
        }
        return false;
    }

    function find_roommate() {
        //@Task: Do your error checking
        if (Input::exists()) {

            $validate = new Validate();
            //validate input
            $validation = $validate->check($_POST, array(
                'roommate_sex' => array(
                    'name' => 'Roommate Sex',
                    'required' => true,
                ),
                'roommate_location' => array(
                    'name' => 'Location',
                    'required' => true,
                ),
                'roommate_hostel' => array(
                    'name' => 'Hostel',
                    'required' => true,
                ),
                'roommate_room' => array(
                    'name' => 'Room',
                    'required' => true,
                ),
            ));
            if ($validation->passed() && $this->model->find_roommate()) {
            } else {
                if (count($validation->errors()) == 1) {
                    $message = "There was 1 error in the form.";
                } else {
                    $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                }
                $message .= $validate->display_errors();
                Session::put('error', $message);
            }

        }
        Redirect::to(backToSender());
        return false;
    }

    function find_facility() {
        //@Task: Do your error checking
        if (Input::exists()) {

            $validate = new Validate();
            //validate input
            $validation = $validate->check($_POST, array(
                'room_type' => array(
                    'name' => 'Room Type',
                    'required' => true,
                ),
                'hostel_location' => array(
                    'name' => 'Hostel Location',
                    'required' => true,
                ),
            ));
            if ($validation->passed() && $this->model->find_facility()) {
            } else {
                if (count($validation->errors()) == 1) {
                    $message = "There was 1 error in the form.";
                } else {
                    $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                }
                $message .= $validate->display_errors();
                Session::put('error', $message);
            }

        }
        Redirect::to(backToSender());
        return false;
    }


    function roommate($sex = null){
        list($this->view->roommate,$this->view->male,$this->view->female) = $this->model->get_roommate_request($sex);
        $this->view->title = 'Find Roommate ';
        $this->view->render('dashboard/roommate','admin');
        return false;

    }

    function facility($type = null,$what = null){
        if(Input::exists()){
            $validate = new Validate();
            //validate input
            $validation = $validate->check($_POST, array(
                'hostel_location' => array(
                    'name' => 'Hostel Location',
                    'required' => true,
                ),
                'room_type' => array(
                    'name' => 'Facility Room Type',
                    'required' => true,
                ),
            ));
            if ($validation->passed()) {
                list($this->view->hostel,$this->view->single,$this->view->self,$this->view->up,$this->view->down) = $this->model->get_facility($type,$what);
            }else {
                if (count($validation->errors()) == 1) {
                    $message = "There was 1 error in the form.";
                } else {
                    $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                }
                $message .= $validate->display_errors();
                Session::put('error', $message);
                Redirect::to(backToSender());
                exit;
            }
        }else{
            list($this->view->hostel,$this->view->single,$this->view->self,$this->view->up,$this->view->down) = $this->model->get_facility($type,$what);

        }

        $this->view->title = 'Find Facility ';
        $this->view->render('dashboard/facility','admin');


    }

    function post($type = null) {
        //@Task: Do your error checking
        if (Input::exists()) {

            $validate = new Validate();
            //validate input
            $validation = $validate->check($_POST, array(
                'message' => array(
                    'name' => 'message',
                    'required' => true,
                ),
            ));
            if ($validation->passed() && $this->model->post($type)) {

                //do nothing
            }
        }
    }

    function picturePost(){
        $max = Input::get('max');
        $folder = 'wall\\';

        $result = array();

        //upload
        $destination = UPLOAD_PATH . $folder;
        $upload = new Upload($destination);
        $upload->setMaxSize($max);
        $upload->allowAllTypes();
        $upload->upload();
        foreach ($upload->getMessages() as $msg) {
            $result[] = $msg;
        }
        //if the sub-folder doesn't exist yet create it
        if (!is_dir($destination)) {
            mkdir($destination);
        }
        $path = $upload->fileName();

        if (!isset($path)) {
            $path = NULL;
            $output = "<p class=\"errors\"> ";
            $output .= "Please review the following fields: <br />";
            foreach ($result as $error) {
                $output .= " - " . $error . "<br />";
            }
            $output .= "</p>";
            echo($output);
            return false;
        } else {
            echo($path);
            exit();
        }
        //Do not resize, do not save any resized image. Responsive system automatically adjust to fit screen size
        /*
          else{
          $resize = new Resize($destination.$path);
          $resize->resizeImage(120, 90, 'exact');
          $resize->saveImage($destination.'/'.$id_key.'/'.$path, 100);
          } */
    }

    function uploader($folder = '', $error = false) {
        //echo($max);
        $result = array();

        //upload
        $destination = UPLOAD_PATH . $folder;
        $upload = new Upload($destination);
        //$upload->setMaxSize($max);
        $upload->allowAllTypes();
        $upload->upload();
        foreach ($upload->getMessages() as $msg) {
            $result[] = $msg;
        }
        //if the sub-folder doesn't exist yet create it
        if (!is_dir($destination)) {
            mkdir($destination);
        }
        $path = $upload->fileName();

        if (!isset($path) && $error) {
            $result[] = "Please Upload an Image file";
            $path = NULL;
            $output = "<p class=\"errors\"> ";
            $output .= "Please review the following fields: <br />";
            foreach ($result as $error) {
                $output .= " - " . $error . "<br />";
            }
            $output .= "</p>";
            Session::put('error', $output);
            //Redirect::to(URL . $step);
            //$this->view->render('reg/member/'.$step, true);

            return false;
        } else {
            return $path;
        }
        //Do not resize, do not save any resized image. Responsive system automatically adjust to fit screen size
        /*
          else{
          $resize = new Resize($destination.$path);
          $resize->resizeImage(120, 90, 'exact');
          $resize->saveImage($destination.'/'.$id_key.'/'.$path, 100);
          } */
    }

    function delete($type, $id) {
        $this->model->delete($type, $id);
    }

    function download($action = null, $id = null){
        if($action && $id){
            switch($action){
                case 'update':
                    list($this->view->about, $this->view->count) = $this->model->get_event($id);

                    break;
                case 'event':
                    $event = $this->model->get_event_ticket($id);
                    $this->event_pdf($event);

                    break;
            }

        }else{
            $this->view->about = $this->model->get_event();
            $page = 'event';
        }
    }

    function account_update() {
        //@Task: Do your error checking
        if (Input::exists()) {
            if (1) {
                $validate = new Validate();
                //validate input
                $validation = $validate->check($_POST, array(
                    'email' => array(
                        'name' => 'Email',
                        'required' => true,
                    ),
                    'phone_no' => array(
                        'name' => 'Phone Number',
                        'required' => true,
                    ),
                ));


                if ($validation->passed()) {
                    $this->model->account_update();
                } else {
                    if (count($validation->errors()) == 1) {
                        $message = "There was 1 error in the form.";
                    } else {
                        $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                    }
                    $message .= $validate->display_errors();
                    Session::put('error', $message);
                }
            }
        }
        Redirect::to(backToSender());

    }



    function event_pdf($data){
// Include the main TCPDF library (search for installation path).
        include('public/TCPDF-master/mypdf.php');

// create new PDF document
        $pdf = new MYPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);

// set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Advanapp');
        $pdf->SetTitle('Rate Chats Events');
        $pdf->SetSubject($data['title']);
        $pdf->SetKeywords('Rate Chats, events, venue, time, place');

// set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 048', PDF_HEADER_STRING);

// set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

// ---------------------------------------------------------

// set font
        $pdf->SetFont('helvetica', 'B', 20);

// add a page
        $pdf->AddPage();

        $pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);

        $pdf->SetFont('helvetica', '', 8);

// -----------------------------------------------------------------------------


        $html = '<hr/>
                            <div class="col-xs-12">
                        <p class="lead">Description:  '.$data['title'].'</p>

                        <div>
                            <table style="color:#00c">
                                <tr>
                                    <th style="width:50%">Time:</th>
                                    <td>'.$data['time'].'</td>
                                </tr>
                                <tr>
                                    <th style="width:50%">Date:</th>
                                    <td>'.$data['date'].'</td>
                                </tr>
                                <tr>
                                    <th style="width:50%">Venue:</th>
                                    <td>'.$data['venue'].'</td>
                                </tr>
                                <tr>
                                    <th style="width:50%">Category:</th>
                                    <td>'.$data['event_type'].'</td>
                                </tr>
                            </table>
                        </div>
                        <p> '.$data['description'].' </p>

                    </div>

';
        $tbl = <<<EOD
                $html

EOD;

        $pdf->writeHTML($html, true, false, false, false, '');

// -----------------------------------------------------------------------------


//Close and output PDF document
        $name = 'Rate Chats - Invoice '.$data['ticket'];

        $pdf->Output($name.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

    }



}