/**
 * Created by Nonny on 1/11/17.
 */

function insert_found(){
    var reg = $("#found_reg_no").val(); //for reg

    $("#student_id").val(reg);
    $("#find_student_reg_no").modal("hide");
}

function insert_pin(){
    var reg = $("#found_user_pin").val(); //for reg

    $("#student_pin").val(reg);
    $("#get_user_id").modal("hide");
}

function retrieve_reg_no(action, id) {
    //$("#loaderIcon").show();
    var queryString;
    var url;
    switch (action) {
        case "faculty":
            var faculty = $("#faculty").val(); //for class
            queryString = 'faculty=' + faculty ;
            url = '../reg/retrieve/faculty';
            break;
        case "dept":
            var grad_year = $("#grad_year").val(); //for session
            var department = $("#department").val(); //for name
            queryString = 'grad_year='+grad_year + '&department=' + department ;
            url = '../reg/retrieve/dept';
            break;
        case "name":
            var name_id = $("#find_name").val(); //for name
            queryString = 'name_id='+name_id ;
            url = '../reg/retrieve/name';
            break;
        case "my_class":
            var name_id = $("#find_name").val(); //for name
            queryString = 'name_id='+name_id ;
            url = '../reg/retrieve/name';
            break;

    }
    jQuery.ajax({
        url: url,
        data: queryString,
        type: "POST",
        success: function (data) {
            switch (action) {
                case "faculty":
                    $("#department").html(data);

                    break;
                case "dept":
                    $("#find_name").html(data);

                    break;

                case "name":
                case "my_class":
                    $("#ur_reg_no").text('Retrieved ID is: '+data);
                    $("#found_reg_no").val(data);

                    break;

            }

            //$("#loaderIcon").hide();
        },
        error: function () {
        }
    });
}


