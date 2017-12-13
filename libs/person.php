<?php
/**
 * Created by PhpStorm.
 * User: Nonny
 * Date: 4/12/15
 * Time: 12:19 AM
 */

class Person {
    private $_db;
    //personal info

    private function __construct(){
        $this->_db = Database::getInstance();
    }

    public static function faculty(){
        $db = Database::getInstance();
        $home = $db->get('unizik_faculties')->results();
        $return = '';
        foreach($home as $h){
            $return .= '<option value="'.$h->id.'">'.$h->name.'</option>';

        }
        echo $return;
    }


    public static function depts(){
        $db = Database::getInstance();
        $home = $db->get('unizik_depts')->results();
        $return = '';
        foreach($home as $h){
            $return .= '<option value="'.$h->id.'">'.$h->name.'</option>';

        }
        echo $return;
    }

    public static function student_grad_yr(){
        $db = Database::getInstance();
        $home = $db->get('unizik_grad_yr',array('year','>=',date('Y')))->results();
        $return = '';
        foreach($home as $h){
           // $return .= '<option value="'.$h->id.'">'.$h->year.'</option>';
            $return .= '<option value="'.$h->year.'">'.$h->year.'</option>';

        }
        echo $return;
    }

    public static function alumni_grad_yr(){
        $db = Database::getInstance();
        $home = $db->get('unizik_grad_yr',array('year','<',date('Y')))->results();
        $return = '';
        foreach($home as $h){
            $return .= '<option value="'.$h->id.'">'.$h->year.'</option>';

        }
        echo $return;
    }

    public static function acad_level(){
        $db = Database::getInstance();
        $home = $db->get('unizik_acad_levels')->results();
        $return = '';
        foreach($home as $h){
            $return .= '<option value="'.$h->id.'">'.$h->level.'</option>';

        }
        echo $return;
    }






######################################################################################################################################################
###################################### NIGERIAN STATES ################################################################################################
#######################################################################################################################################################
    public static function naija_state_gen(){
        //<option value="0">Select State</option>
        echo '
              <option value="Abuja FCT">Abuja FCT</option>
              <option value="Abia">Abia</option>
              <option value="Adamawa">Adamawa</option>
              <option value="Akwa Ibom">Akwa Ibom</option>
              <option value="Anambra">Anambra</option>
              <option value="Bauchi">Bauchi</option>
              <option value="Bayelsa">Bayelsa</option>
              <option value="Benue">Benue</option>
              <option value="Borno">Borno</option>
              <option value="Cross River">Cross River</option>
              <option value="Delta">Delta</option>
              <option value="Ebonyi">Ebonyi</option>
              <option value="Edo">Edo</option>
              <option value="Ekiti">Ekiti</option>
              <option value="Enugu">Enugu</option>
              <option value="Gombe">Gombe</option>
              <option value="Imo">Imo</option>
              <option value="Jigawa">Jigawa</option>
              <option value="Kaduna">Kaduna</option>
              <option value="Kano">Kano</option>
              <option value="Katsina">Katsina</option>
              <option value="Kebbi">Kebbi</option>
              <option value="Kogi">Kogi</option>
              <option value="Kwara">Kwara</option>
              <option value="Lagos">Lagos</option>
              <option value="Nassarawa">Nassarawa</option>
              <option value="Niger">Niger</option>
              <option value="Ogun">Ogun</option>
              <option value="Ondo">Ondo</option>
              <option value="Osun">Osun</option>
              <option value="Oyo">Oyo</option>
              <option value="Plateau">Plateau</option>
              <option value="Rivers">Rivers</option>
              <option value="Sokoto">Sokoto</option>
              <option value="Taraba">Taraba</option>
              <option value="Yobe">Yobe</option>
              <option value="Zamfara">Zamfara</option>
     <option value="Non Nigerian">Non Nigerian</option>
        ';

    }

        public static function sex(){
            //<option value="0">Select </option>
            echo '
            <option value="male">Male</option>
            <option value="female">Female</option>
            ';
        }

        public static function used_state(){
            //<option value="0">Select </option>
            echo '
            <option value="new">Brand New</option>
            <option value="used">Fairly Used</option>
            ';
        }

        public static function scope(){
            //<option value="0">Select </option>
            echo '
            <option value="1">General</option>
            <option value="2">My Class Only</option>
            ';
        }

        public static function title(){
            //<option value="0">Select </option>
            echo '
            <option value="Mr">Mr</option>
            <option value="Mrs">Mrs</option>
            <option value="Master">Master</option>
            <option value="Miss">Miss</option>
            <option value="Chief">Chief</option>
            <option value="Lolo">Lolo</option>
            <option value="Engr">Engr</option>
            <option value="Dr">Dr</option>
            <option value="Rev">Rev</option>
            <option value="Pastor">Pastor</option>
            <option value="Arch">Arch</option>
            <option value="Others">Others</option>
            ';
        }


        public static function event_type(){
            //<option value="0">Select </option>
            echo '
                <option value="Conference">Conference </option>
                <option value="Seminar">Seminar </option>
                <option value="Workshop">Workshop </option>
                <option value="Class">Classes </option>
                <option value="Meeting">Meeting</option>
                <option value="Fundraiser">Fundraiser </option>
                <option value="Honorary Welcome">Honorary Welcome </option>
                <option value="Inauguration">Inauguration </option>
                <option value="Award Ceremony">Award Ceremony </option>
            ';
        }
        public static function event_scope(){
            //<option value="0">Select </option>
            echo '
                <option value="National">National </option>
                <option value="Chapter">Chapter </option>
                <option value="Committee based">Committee based </option>
                <option value="Let me decide">Let me decide</option>
            ';
        }

        public static function ticket_type(){
            //<option value="0">Select </option>
            echo '
                <option value="1">Free </option>
                <option value="2">Paid </option>
                <option value="3">Donation </option>
            ';
        }

        public  static function relationship(){
            //<option value="0">Select</option>
            echo '
            <option value="Mother">Mother</option>
            <option value="Father">Father</option>
            <option value="Son">Son</option>
            <option value="Daughter">Daughter</option>
            <option value="Spouse">Spouse</option>
            <option value="Brother">Brother</option>
            <option value="Sister">Sister</option>
            <option value="Uncle">Uncle</option>
            <option value="Aunt">Aunt</option>
            <option value="Extended Relation">Extended Relation</option>
            <option value="Guardian">Guardian</option>
            <option value="Friend">Friend</option>
            ';
        }

        public  static function rooms(){
            //<option value="0">Select</option>
            echo '
                <option value="Single Room">Single Room</option>
                <option value="Self Contain">Self Contain</option>
                <option value="1 Bedroom Flat">1 Bedroom Flat</option>
                <option value="2 Bedroom Flat">2 Bedroom Flat</option>
                <option value="3 Bedroom Flat">3 Bedroom Flat</option>
                <option value="Others">Others</option>
            ';
        }

        public  static function Marital_status(){
            //<option value="0">Select</option>
            echo '
            <option value="Single">Single</option>
            <option value="Married">Married</option>
            <option value="Divorced">Divorced</option>
            <option value="Widowed">Widowed</option>
            ';
        }

        public  static function locale(){
            //<option value="0">Select</option>
            echo '
                <option value="0">Select</option>
                <option value="Down School">Ifite/ Perm Site/ Amansea</option>
                <option value="Up School">Temp Site/ Arroma/ Eke Awka</option>
                <option value="Others">Others</option>
            ';
        }

        public static function naija_region(){
        echo '
            <option value="0">Select</option>
            <option value="NE">North East</option>
            <option value="NW">North West</option>
            <option value="NC">North Central</option>
            <option value="SE">South East</option>
            <option value="SW">South West</option>
            <option value="SS">South South</option>
            ';    }
#################################################################################################################################################
##################################              UNIZIK FUNCTIONS       ###########################################################################
###################################################################################################################################################

        public static function student(){
            //<option value="0">Select</option>
            echo'
			  <option value="Regular">Regular Student</option>
			  <option value="CEP">CEP Student</option>
        	  <option value="PGD">PGD</option>
        	  <option value="MSc">MSc</option>
        	  <option value="PhD">PhD</option>
        	  <option value="Alumni">Alumni</option>
        	  <option value="Others">Others</option>
			';
        }
        public static function support(){
            echo'
			  <option value="Support">Support</option>
			  <option value="Hostel">Hostel Management</option>
        	  <option value="SUG">SUG</option>
        	  <option value="Dean">Dean of Students\' Affairs</option>
        	  <option value="VC">The VC</option>
			';
        }

        public static function groups(){
            //<option value="0">Select</option>
            echo'
	        	  <option value="Educational">Educational</option>
        	  <option value="Social">Social</option>
		  <option value="Religious">Religious</option>
        	  <option value="Entertainment">Entertainment</option>
        	  <option value="Political">Political</option>
        	  <option value="Sports">Sports</option>
        	  <option value="Technology">Technology</option>
        	  <option value="Others">Others</option>
			';
        }

        public static function get_program(){
        //<option value="0">Select</option>
       echo '
        	  <option value="OND">OND</option>
        	  <option value="HND">HND</option>
        	  <option value="B. Sc.">B Sc.</option>
        	  <option value="B. Engr.">B. Engr.</option>
        	  <option value="PGD">PGD</option>
        	  <option value="MSc">MSc</option>
        	  <option value="PhD">PhD</option>
        	  <option value="Professorship">Professorship</option>
        	  <option value="Professional Certification">Professional Certification e.g. PMP</option>
        	  <option value="WAEC">WAEC</option>
        	  <option value="NECO">NECO</option>
        	  <option value="GCE">GCE</option>
			  ';
    }

        public static function mode_of_entry(){
            // <option value="0">Select</option>
            echo '
				<option value="Pre Science">Pre Science</option>
				<option value="JAMB/UTME">JAMB/UTME</option>
				<option value="Direct Entry">Direct Entry</option>

				';
        }
        public static function membership_cadre(){
            // <option value="0">Select</option>
            echo '
				<option value="Fellow">Fellow</option>
				<option value="Member">Member</option>
				<option value="Graduate">Graduate</option>
				<option value="Student">Student</option>

				';
        }
        public static function study_work(){
            // <option value="0">Select</option>
            echo '
				<option value="Studying">Studying</option>
				<option value="Working">Working</option>
				<option value="Working and Studying">Working and Studying</option>
				<option value="Doing Research">Doing Research</option>

				';
        }
        public static function banks(){
            // <option value="0">Select</option>
            echo '
				<option value="Access Bank Plc">Access Bank Plc</option>
				<option value="Diamond Bank Limited">Diamond Bank Limited</option>
				<option value="Ecobank Nigeria Plc">Ecobank Nigeria Plc</option>
				<option value="Equitorial Trust Bank Limited">Equitorial Trust Bank Limited</option>
				<option value="Fidelity Bank Plc">Fidelity Bank Plc</option>
				<option value="First Bank of Nigeria Plc">First Bank of Nigeria Plc</option>
				<option value="First City Monument Bank Ltd.">First City Monument Bank Ltd.</option>
				<option value="Guaranty Trust Bank Plc">Guaranty Trust Bank Plc</option>
				<option value="Intercontinental Bank Ltd.">Intercontinental Bank Ltd.</option>
				<option value="StanbicIBTC Bank">StanbicIBTC Bank</option>
				<option value="Skye Bank">Skye Bank</option>
				<option value="Standard Chartered Bank Nigeria Ltd">Standard Chartered Bank Nigeria Ltd</option>
				<option value="Sterling Bank Plc">Sterling Bank Plc</option>
				<option value="Union Bank of Nigeria Plc">Union Bank of Nigeria Plc</option>
				<option value="United Bank for Africa Plc.">United Bank for Africa Plc.</option>
				<option value="Unity Bank">Unity Bank</option>
				<option value="Wema Bank Plc.">Wema Bank Plc.</option>
				<option value="Zenith International Bank Ltd.">Zenith International Bank Ltd.</option>
				<option value="Citibank">Citibank</option>
				<option value="Heritage Bank Plc.">Heritage Bank Plc. </option>

				';
        }

####################################### COUNTRY DATABASE ###############################
    public static function country()
    {
        //<option value="0">Select a Country</option>
        echo '
    <option value="Afghanistan">Afghanistan</option>
    <option value="&Aring;land Islands">&Aring;land Islands</option>
    <option value="Albania">Albania</option>
    <option value="Algeria">Algeria</option>
    <option value="American Samoa">American Samoa</option>
    <option value="Andorra">Andorra</option>
    <option value="Angola">Angola</option>
    <option value="Anguilla">Anguilla</option>
    <option value="Antarctica">Antarctica</option>
    <option value="Antigua and Barbuda">Antigua and Barbuda</option>
    <option value="Argentina">Argentina</option>
    <option value="Armenia">Armenia</option>
    <option value="Aruba">Aruba</option>
    <option value="Australia">Australia</option>
    <option value="Austria">Austria</option>
    <option value="Azerbaijan">Azerbaijan</option>
    <option value="Bahamas">Bahamas</option>
    <option value="Bahrain">Bahrain</option>
    <option value="Bangladesh">Bangladesh</option>
    <option value="Barbados">Barbados</option>
    <option value="Belarus">Belarus</option>
    <option value="Belgium">Belgium</option>
    <option value="Belize">Belize</option>
    <option value="Benin">Benin</option>
    <option value="Bermuda">Bermuda</option>
    <option value="Bhutan">Bhutan</option>
    <option value="Bolivia, Plurinational State of">Bolivia, Plurinational State of</option>
    <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
    <option value="Botswana">Botswana</option>
    <option value="Bouvet Island">Bouvet Island</option>
    <option value="Brazil">Brazil</option>
    <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
    <option value="Brunei Darussalam">Brunei Darussalam</option>
    <option value="Bulgaria">Bulgaria</option>
    <option value="Burkina Faso">Burkina Faso</option>
    <option value="Burundi">Burundi</option>
    <option value="Cambodia">Cambodia</option>
    <option value="Cameroon">Cameroon</option>
    <option value="Canada">Canada</option>
    <option value="Cape Verde">Cape Verde</option>
    <option value="Cayman Islands">Cayman Islands</option>
    <option value="Central African Republic">Central African Republic</option>
    <option value="Chad">Chad</option>
    <option value="Chile">Chile</option>
    <option value="China">China</option>
    <option value="Christmas Island">Christmas Island</option>
    <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
    <option value="Colombia">Colombia</option>
    <option value="Comoros">Comoros</option>
    <option value="Congo">Congo</option>
    <option value="Congo, the Democratic Republic of the">Congo, the Democratic Republic of the</option>
    <option value="Cook Islands">Cook Islands</option>
    <option value="Costa Rica">Costa Rica</option>
    <option value="C&ocirc;te d\'Ivoire">C&ocirc;te d\' Ivoire</option>
    <option value="Croatia">Croatia</option>
    <option value="Cuba">Cuba</option>
    <option value="Cyprus">Cyprus</option>
    <option value="Czech Republic">Czech Republic</option>
    <option value="Denmark">Denmark</option>
    <option value="Djibouti">Djibouti</option>
    <option value="Dominica">Dominica</option>
    <option value="Dominican Republic">Dominican Republic</option>
    <option value="Ecuador">Ecuador</option>
    <option value="Egypt">Egypt</option>
    <option value="El Salvador">El Salvador</option>
    <option value="Equatorial Guinea">Equatorial Guinea</option>
    <option value="Eritrea">Eritrea</option>
    <option value="Estonia">Estonia</option>
    <option value="Ethiopia">Ethiopia</option>
    <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
    <option value="Faroe Islands">Faroe Islands</option>
    <option value="Fiji">Fiji</option>
    <option value="Finland">Finland</option>
    <option value="France">France</option>
    <option value="French Guiana">French Guiana</option>
    <option value="French Polynesia">French Polynesia</option>
    <option value="French Southern Territories">French Southern Territories</option>
    <option value="Gabon">Gabon</option>
    <option value="Gambia">Gambia</option>
    <option value="Georgia">Georgia</option>
    <option value="Germany">Germany</option>
    <option value="Ghana">Ghana</option>
    <option value="Gibraltar">Gibraltar</option>
    <option value="Greece">Greece</option>
    <option value="Greenland">Greenland</option>
    <option value="Grenada">Grenada</option>
    <option value="Guadeloupe">Guadeloupe</option>
    <option value="Guam">Guam</option>
    <option value="Guatemala">Guatemala</option>
    <option value="Guernsey">Guernsey</option>
    <option value="Guinea">Guinea</option>
    <option value="Guinea-Bissau">Guinea-Bissau</option>
    <option value="Guyana">Guyana</option>
    <option value="Haiti">Haiti</option>
    <option value="Heard Island and McDonald Islands">Heard Island and McDonald Islands</option>
    <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
    <option value="Honduras">Honduras</option>
    <option value="Hong Kong">Hong Kong</option>
    <option value="Hungary">Hungary</option>
    <option value="Iceland">Iceland</option>
    <option value="India">India</option>
    <option value="Indonesia">Indonesia</option>
    <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
    <option value="Iraq">Iraq</option>
    <option value="Ireland">Ireland</option>
    <option value="Isle of Man">Isle of Man</option>
    <option value="Israel">Israel</option>
    <option value="Italy">Italy</option>
    <option value="Jamaica">Jamaica</option>
    <option value="Japan">Japan</option>
    <option value="Jersey">Jersey</option>
    <option value="Jordan">Jordan</option>
    <option value="Kazakhstan">Kazakhstan</option>
    <option value="Kenya">Kenya</option>
    <option value="Kiribati">Kiribati</option>
    <option value="Korea, Democratic People\'s Republic of">Korea, Democratic People\'s Republic of</option>
    <option value="Korea, Republic of">Korea, Republic of</option>
    <option value="Kuwait">Kuwait</option>
    <option value="Kyrgyzstan">Kyrgyzstan</option>
    <option value="Lao People\'s Democratic Republic">Lao People\'s Democratic Republic</option>
    <option value="Latvia">Latvia</option>
    <option value="Lebanon">Lebanon</option>
    <option value="Lesotho">Lesotho</option>
    <option value="Liberia">Liberia</option>
    <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
    <option value="Liechtenstein">Liechtenstein</option>
    <option value="Lithuania">Lithuania</option>
    <option value="Luxembourg">Luxembourg</option>
    <option value="Macao">Macao</option>
    <option value="Macedonia, the former Yugoslav Republic of">Macedonia, the former Yugoslav Republic of</option>
    <option value="Madagascar">Madagascar</option>
    <option value="Malawi">Malawi</option>
    <option value="Malaysia">Malaysia</option>
    <option value="Maldives">Maldives</option>
    <option value="Mali">Mali</option>
    <option value="Malta">Malta</option>
    <option value="Marshall Islands">Marshall Islands</option>
    <option value="Martinique">Martinique</option>
    <option value="Mauritania">Mauritania</option>
    <option value="Mauritius">Mauritius</option>
    <option value="Mayotte">Mayotte</option>
    <option value="Mexico">Mexico</option>
    <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
    <option value="Moldova, Republic of">Moldova, Republic of</option>
    <option value="Monaco">Monaco</option>
    <option value="Mongolia">Mongolia</option>
    <option value="Montenegro">Montenegro</option>
    <option value="Montserrat">Montserrat</option>
    <option value="Morocco">Morocco</option>
    <option value="Mozambique">Mozambique</option>
    <option value="Myanmar">Myanmar</option>
    <option value="Namibia">Namibia</option>
    <option value="Nauru">Nauru</option>
    <option value="Nepal">Nepal</option>
    <option value="Netherlands">Netherlands</option>
    <option value="Netherlands Antilles">Netherlands Antilles</option>
    <option value="New Caledonia">New Caledonia</option>
    <option value="New Zealand">New Zealand</option>
    <option value="Nicaragua">Nicaragua</option>
    <option value="Niger">Niger</option>
    <option value="Nigeria">Nigeria</option>
    <option value="Niue">Niue</option>
    <option value="Norfolk Island">Norfolk Island</option>
    <option value="Northern Mariana Islands">Northern Mariana Islands</option>
    <option value="Norway">Norway</option>
    <option value="Oman">Oman</option>
    <option value="Pakistan">Pakistan</option>
    <option value="Palau">Palau</option>
    <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
    <option value="Panama">Panama</option>
    <option value="Papua New Guinea">Papua New Guinea</option>
    <option value="Paraguay">Paraguay</option>
    <option value="Peru">Peru</option>
    <option value="Philippines">Philippines</option>
    <option value="Pitcairn">Pitcairn</option>
    <option value="Poland">Poland</option>
    <option value="Portugal">Portugal</option>
    <option value="Puerto Rico">Puerto Rico</option>
    <option value="Qatar">Qatar</option>
    <option value="R&eacute;union">R&eacute;union</option>
    <option value="Romania">Romania</option>
    <option value="Russian Federation">Russian Federation</option>
    <option value="Rwanda">Rwanda</option>
    <option value="Saint Barth&eacute;lemy">Saint Barth&eacute;lemy</option>
    <option value="Saint Helena, Ascension and Tristan da Cunha">Saint Helena, Ascension and Tristan da Cunha</option>
    <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
    <option value="Saint Lucia">Saint Lucia</option>
    <option value="Saint Martin (French part)">Saint Martin (French part)</option>
    <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
    <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
    <option value="Samoa">Samoa</option>
    <option value="San Marino">San Marino</option>
    <option value="Sao Tome and Principe">Sao Tome and Principe</option>
    <option value="Saudi Arabia">Saudi Arabia</option>
    <option value="Senegal">Senegal</option>
    <option value="Serbia">Serbia</option>
    <option value="Seychelles">Seychelles</option>
    <option value="Sierra Leone">Sierra Leone</option>
    <option value="Singapore">Singapore</option>
    <option value="Slovakia">Slovakia</option>
    <option value="Slovenia">Slovenia</option>
    <option value="Solomon Islands">Solomon Islands</option>
    <option value="Somalia">Somalia</option>
    <option value="South Africa">South Africa</option>
    <option value="South Georgia and the South Sandwich Islands">South Georgia and the South Sandwich Islands</option>
    <option value="Spain">Spain</option>
    <option value="Sri Lanka">Sri Lanka</option>
    <option value="Sudan">Sudan</option>
    <option value="Suriname">Suriname</option>
    <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
    <option value="Swaziland">Swaziland</option>
    <option value="Sweden">Sweden</option>
    <option value="Switzerland">Switzerland</option>
    <option value="Syrian Arab Republic">Syrian Arab Republic</option>
    <option value="Taiwan, Province of China">Taiwan, Province of China</option>
    <option value="Tajikistan">Tajikistan</option>
    <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
    <option value="Thailand">Thailand</option>
    <option value="Timor-Leste">Timor-Leste</option>
    <option value="Togo">Togo</option>
    <option value="Tokelau">Tokelau</option>
    <option value="Tonga">Tonga</option>
    <option value="Trinidad and Tobago">Trinidad and Tobago</option>
    <option value="Tunisia">Tunisia</option>
    <option value="Turkey">Turkey</option>
    <option value="Turkmenistan">Turkmenistan</option>
    <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
    <option value="Tuvalu">Tuvalu</option>
    <option value="Uganda">Uganda</option>
    <option value="Ukraine">Ukraine</option>
    <option value="United Arab Emirates">United Arab Emirates</option>
    <option value="United Kingdom">United Kingdom</option>
    <option value="United States">United States</option>
    <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
    <option value="Uruguay">Uruguay</option>
    <option value="Uzbekistan">Uzbekistan</option>
    <option value="Vanuatu">Vanuatu</option>
    <option value="Venezuela, Bolivarian Republic of">Venezuela, Bolivarian Republic of</option>
    <option value="Viet Nam">Viet Nam</option>
    <option value="Virgin Islands, British">Virgin Islands, British</option>
    <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
    <option value="Wallis and Futuna">Wallis and Futuna</option>
    <option value="Western Sahara">Western Sahara</option>
    <option value="Yemen">Yemen</option>
    <option value="Zambia">Zambia</option>
    <option value="Zimbabwe">Zimbabwe</option>
    ';
    }


}