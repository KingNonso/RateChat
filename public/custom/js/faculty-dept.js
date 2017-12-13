

// Universities
var uni_array = new Array("Yes", "No");

// Faculties
var fac_array = new Array();
fac_array[0]="";
fac_array[1]="Arts|Education|Engineering|Agriculture|Physical Sciences|Bio Sciences|Environmental Sciences|Health Sciences and Technology|Law|Management Sciences|Medicine|Social Sciences|Pharmaceutical Sciences|Basic Medical Sciences";

//List of Depts

var dept_array = new Array();
dept_array[0] = "";
dept_array[1] = "English Language|French|History and International Studies|Igbo|Linguistics|Music|Philosophy|Religious Studies|Theatre Arts";
dept_array[2] = "Education Foundation|Health and Physical Education|Library Science|Science Education|Vocational Education|Adult Education|Early Childhood and Primary Education|Educational Management and Policy|Guidance and Counseling";
dept_array[3] = "Chemical Engineering|Civil Engineering|Electrical Engineering|Mechanical Engineering|Materials and Metallurgical Engineering|Agricultural and Bio-Resources Engineering|Electronics and Computer Engineering|Industrial and Production Engineering|Polymer and Textile Engineering";
dept_array[4] = "Crop Science|Animal Science|Food Science and Technology|Agric Economics and Extension|Forestry and Wildlife";
dept_array[5] = "Computer Science|Geological Science|Geophysics|Industrial Maths|Physics and Industrial Physics|Pure and Industrial Chemistry|Statistics";
dept_array[6] = "Applied Biochemistry|Applied Microbiology and Brewing|Botany|Parasitology and Entomology|Zoology";
dept_array[7] = "Architecture|Building|Estate Management|Geography/Meteorology|Surveying/Geo-informatics|Fine Arts|Environmental Management|Quantity Surveying";
dept_array[8] = "Medical Lab. Tech|Medical Rehabilitation and Physiotherapy|Nursing Science|Radiography";
dept_array[9] = "Law";
dept_array[10] = "Accountancy|Banking and Finance|Business Administration|Co-operative Economics|Marketing|Public Administration";
dept_array[11] = "Medicine";
dept_array[12] = "Economics|Mass Communication|Political Science|Psychology|Sociology";
dept_array[13] = "Pharmacy";
dept_array[14] = "Anatomy|Physiology";



function populateDept( facultyElementId, deptElementId ){

    var selectedFacultyIndex = document.getElementById( facultyElementId ).selectedIndex;

    var deptElement = document.getElementById( deptElementId );

    deptElement.length=0;	// rebranded by King
    deptElement.options[0] = new Option('Select Dept','');
    deptElement.selectedIndex = 0;

    var lga_arr = dept_array[selectedFacultyIndex].split("|");

    for (var i=0; i<lga_arr.length; i++) {
        deptElement.options[deptElement.length] = new Option(lga_arr[i],lga_arr[i]);
    }
}
function populateFaculty( uniElementId, facultyElementId,deptElementId ){

    var selectedUniIndex = document.getElementById( uniElementId ).selectedIndex;

    var facultyElement = document.getElementById( facultyElementId );

    facultyElement.length=0;	// Fixed by Julian Woods
    facultyElement.options[0] = new Option('Select Faculty','');
    facultyElement.selectedIndex = 0;

    var state_arr = fac_array[selectedUniIndex].split("|");

    for (var i=0; i<state_arr.length; i++) {
        facultyElement.options[facultyElement.length] = new Option(state_arr[i],state_arr[i]);
    }

    if( deptElementId){
        //show LGA ELEMENT
        facultyElement.onchange = function(){
            populateDept( facultyElementId, deptElementId );
        };

    }

}

function populateUniversity(uniElementId, facultyElementId, deptElementId){
    // given the id of the <select> tag as function argument, it inserts <option> tags
    var uniElement = document.getElementById(uniElementId);
    uniElement.length=0;
    uniElement.options[0] = new Option('Select ','-1');
    uniElement.selectedIndex = 0;
    for (var i=0; i<uni_array.length; i++) {
        uniElement.options[uniElement.length] = new Option(uni_array[i],uni_array[i]);
    }

    // Assigned all countries. Now assign event listener for the states.
    uniElement.onchange = function(){
        var selectedUniIndex = document.getElementById( uniElementId ).selectedIndex;
        var uni_holder = document.getElementById("uni_holder");
        var faculty_holder = document.getElementById("faculty_holder");
        var dept_holder = document.getElementById("dept_holder");
        var facdept = document.getElementById("facdept");

        if(selectedUniIndex===1){ //if it is UNIZIK
            uni_holder.style.display ='none';
            faculty_holder.innerHTML = '<select class="form-control" id="faculty" name="faculty"></select>';
            dept_holder.innerHTML = '<select class="form-control" id="dept" name="dept"></select>';
            facdept.style.display ='block';
            if( facultyElementId ){
                populateFaculty( uniElementId, facultyElementId, deptElementId );
            }
        }else{
            facdept.style.display ='none';
            if(selectedUniIndex !=1){ //if it is not Nigeria
                uni_holder.style.display ='block';
                faculty_holder.innerHTML = '<input type="text"  class="form-control" name="faculty" id="faculty" placeholder="Enter the Name of your faculty" />';
                dept_holder.innerHTML = '<input type="text"  class="form-control" name="dept" id="dept" placeholder="Enter the Name of your dept" />';

            }
        }

    };

}