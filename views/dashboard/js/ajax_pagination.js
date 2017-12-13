var rpp = $("#results_per_page").val();
var last = $("#last_page").val();

request_page(1);

function request_page(pn){
    var results_box = document.getElementById("results_box");
    var pagination_controls_up = document.getElementById("pagination_controls_up");
    var pagination_controls_down = document.getElementById("pagination_controls_down");
    results_box.innerHTML = "loading results ...";
    var hr = new XMLHttpRequest();
    hr.open("POST", "../blog/pagination_parser", true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function() {
        if(hr.readyState == 4 && hr.status == 200) {
        results_box.innerHTML = hr.responseText;
        }
    }
hr.send("rpp="+rpp+"&last="+last+"&pn="+pn);
// Change the pagination controls
var paginationCtrls = '<ul class="pager">';
// Only if there is more than 1 page worth of results give the user pagination controls
if(last != 1){
    if (pn > 1) {
        paginationCtrls += '<li class="previous"><button class="btn btn-primary" onclick="request_page('+(pn-1)+')">&laquo; Previous </button></li>';
    }
paginationCtrls += ' &nbsp; &nbsp; <b>Displaying Results '+pn+' of '+last+'</b> &nbsp; &nbsp; ';
if (pn != last) {
    paginationCtrls += '<li class="next" onclick="request_page('+(pn+1)+')"><button class="btn btn-primary" >Next &raquo;</button></li>';
    }
    paginationCtrls += '</ul>';

}
    pagination_controls_up.innerHTML = paginationCtrls;
    pagination_controls_down.innerHTML = paginationCtrls;
}


