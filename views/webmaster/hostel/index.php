<?php
    $max = 2000 * 1024; //2mb
    $user = new User();
?>

<div class="container-fluid text-center" id="myBody">
    <div class="container-fluid text-center">
        <h2>Search for Hostel</h2>
        <form class="form-inline">
            <input type="text" class="form-control" size="50" placeholder="Enter Hostel Name Here" onkeyup="SearchHostel(this.value)" required>
            <button type="button" class="btn btn-default">Search</button>
        </form>
        <span class="text-center" id="hostel_search_results" ></span>
    </div>

    <!-- Container (About LFC Ifite Section) -->
    <div id="hostel" class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="row text-center">
                    <?php
                        if(isset($this->hostels)){
                            foreach($this->hostels as $h){?>
                                <div class="col-sm-3">
                                    <div class="panel panel-default text-center">
                                        <div class="panel-heading">
                                            <h1> <?php echo($h['hostel_name']); ?></h1>
                                        </div>
                                        <div class="panel-body">
                                            <img src=" <?php echo($h['image']); ?>" class="img-rounded center-block" width="250" height="250" alt="<?php echo($h['hostel_name']); ?>">
                                        </div>
                                        <div class="panel-footer">
                                            <h3> Room Type: <?php echo($h['room_type']); ?></h3>
                                            <h4>Location: <?php echo($h['site']); ?></h4>
                                            <a href=" <?php echo(URL.'hostel/ '.$h['hostel_slug']); ?>" class="btn btn-lg">View Hostel Details</a>
                                        </div>
                                    </div>
                                </div>

                            <?php  }
                        } ?>


                </div>


                <br/><a href="#" class="btn btn-primary btn-lg btn-block"> View All  Hostels</a>

            </div>

        </div>
    </div>

    <!-- Container (roommate Cells Section) -->
    <div id="roommate" class="container-fluid text-center bg-grey">
        <h2>Find a ROOM MATE</h2>
        <div class="row">
            <div class="col-sm-12">
                <span class="glyphicon glyphicon-user logo "></span>
            </div>
            <div class="col-sm-12">
                <h4><strong>FIND:</strong> Someone you can live with</h4>

                <div class="form-group">
                    <select class="form-control" id="sel1">
                        <option>Select Area</option>
                        <option>Any </option>
                        <option>Perm Site</option>
                        <option>Term Site</option>
                    </select>
                </div>
                <br>
                <div class="form-group">
                    <select class="form-control" id="sel1">
                        <option>Select Sex</option>
                        <option>Male </option>
                        <option>Female </option>
                    </select>
                </div>

                <div class="center-block">
                    <a href="" class="btn btn-primary">Search  Roommate</a>
                </div>

            </div>

        </div>
    </div>


</div>

